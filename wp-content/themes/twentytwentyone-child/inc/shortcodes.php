<?php
	add_shortcode('bags_products', 'bags_products_shortcode');
	function bags_products_shortcode($atts) {
		$atts = shortcode_atts( [
				'count' => 3,
			], $atts);
		
		$args = array(
			'post_type' => 'product',
			'posts_per_page' => $atts['count'],
			'product_cat' => 'bags',
		);
		
		$query = new WP_Query($args);
		
		ob_start();
		
		if ($query->have_posts()) {
			
			woocommerce_product_loop_start();
			
			while ( $query->have_posts() ) {
				$query->the_post();
				
				do_action( 'woocommerce_shop_loop' );
				
				wc_get_template_part( 'content', 'product' );
			}
			
			woocommerce_product_loop_end();
			
			wp_reset_postdata();
		} else {
			_e( 'No products found.', TEXT_DOMAIN );
		}
		
		return ob_get_clean();
	}
