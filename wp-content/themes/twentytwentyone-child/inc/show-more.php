<?php
	add_action( 'woocommerce_after_shop_loop_item_title', 'add_show_more_btn', 15 );
	function add_show_more_btn(){
		global $product;
		echo '<a class="show-more-info" data-id="'.$product->get_id().'">'.__('Show More Info', TEXT_DOMAIN).'</a>';
	}
	
	wp_enqueue_style( 'show-more', get_stylesheet_directory_uri() . '/assets/css/show-more.css' );
	wp_enqueue_script('show-more', get_stylesheet_directory_uri() . '/assets/js/show-more.js', [ 'jquery' ], false, true );
	
	add_action( 'wp_ajax_show_more_info', 'show_more_info' );
	add_action( 'wp_ajax_nopriv_show_more_info', 'show_more_info' );
	function show_more_info() {
		if ( ! isset( $_POST['id'] ) ) {
			wp_send_json_error();
		}
		
		$product = wc_get_product( $_POST['id'] );
		
		$args = [
			'image' => wp_get_attachment_image_src( $product->get_image_id() )[0],
			'description' => $product->get_description()
		];
		
		wp_send_json_success($args);
	}
