<?php

/**
 * Register
 *
 * @package default
 * @author Dion
 **/

class CellRestapi {

	function __construct($args) {

		// get the profile args
		$this->args = $args;

		//add editing endpoint
		add_action( 'init', array($this, 'editing_endpoint'),1001 );

		// add REST rewrite rules
		add_filter( 'generate_rewrite_rules', array($this, 'custom_taxonomy_rewrite'),1001 );

		// add single item rest
		add_action( 'pre_get_posts', array($this, 'get_single_rest_item'));

		// output in json
		add_action( 'template_redirect', array($this, 'makeplugins_endpoints_template_redirect'), 1);
	}

	function custom_taxonomy_rewrite( $wp_rewrite ) {
		$tax_rules = array();
		foreach ($this->args['post_type'] as $post_type) {
			$tax_rules[$post_type.'/json/page/(.+)/?$'] = 'index.php?json&post_type='. $post_type.'&paged='. $wp_rewrite->preg_index(1);
			$tax_rules[$post_type.'/json/(.+)/?$'] = 'index.php?json&post_type='. $post_type.'&post_id='. $wp_rewrite->preg_index(1);
			$tax_rules[$post_type.'/json/?$'] = 'index.php?json&post_type='. $post_type;
		}
		$wp_rewrite->rules = $tax_rules + $wp_rewrite->rules;
	}

	function get_single_rest_item($query){
		global $wp_query;

		if ( ! isset( $wp_query->query_vars['post_id'] ) ){
			return;
		} else {
			$post_array = array($wp_query->query_vars['post_id']);
			$query->set('post__in', $post_array );
		}
	}

	function makeplugins_endpoints_template_redirect() {
		global $wp_query;

		// if this is not a request for json or it's not a singular object then bail
		if ( ! isset( $wp_query->query_vars['json'] ) ){
			return;
		}

		header( 'Content-Type: application/json' );
		$result = $this->format_json($wp_query);
		echo json_encode( $result , JSON_PRETTY_PRINT);
		exit;
	}

	function editing_endpoint() {
		add_rewrite_endpoint( 'json', EP_ALL );
		add_rewrite_tag("%json%", '(.+)');
		add_rewrite_tag("%post_id%", '(.+)');
	}

	function format_json($wp_query){

		$result = array();

		if ($wp_query->post_count == 0) {
			$result['status'] = 'OK';
			$result['post_count'] = 0;

		} elseif ($wp_query->post_count ==1) {

			$result['status'] = 'OK';

			if (isset($this->args[$wp_query->post->post_type])) {
				$result['post'] = call_user_func_array( $this->args[$wp_query->post->post_type] , array($wp_query->post));
			} else {
				$result['post'] = call_user_func_array( 'post_json' , array($wp_query->post));
			}
			
		} else {

			$result['status'] = 'OK';
			$result['found_posts'] = $wp_query->found_posts;

			$posts = $wp_query->posts;
			foreach ($posts as $post_id => $post) {
				if (isset($this->args[$wp_query->post->post_type])) {
					$result['posts'][] = call_user_func_array( $this->args[$wp_query->post->post_type] , array($wp_query->post));
				} else {
					$result['posts'][] = call_user_func_array( 'post_json' , array($wp_query->post));
				}
			}
		}
		// return $wp_query;
		return $result;
	}
}


?>