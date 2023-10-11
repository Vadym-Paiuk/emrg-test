<?php
	add_action( 'init', 'create_post_type' );
	function create_post_type() {
		register_post_type( 'project', [
			'taxonomies'    => ['category'],
			'label'         => null,
			'labels'        => [
				'name'              => 'Projects',
				'singular_name'     => 'Project',
				'add_new'           => 'Add Project',
				'add_new_item'      => 'Adding Project',
				'edit_item'         => 'Edit Project',
				'new_item'          => 'New Project',
				'view_item'         => 'See Project',
				'search_items'      => 'Search Project',
				'not_found'         => 'Not Found',
				'parent_item_colon' => '',
				'menu_name'         => 'Projects',
			],
			'description'   => '',
			'public'        => true,
			'show_in_menu'  => null,
			'show_in_rest'  => null,
			'rest_base'     => null,
			'menu_position' => null,
			'menu_icon'     => 'dashicons-book',
			'hierarchical'  => false,
			'supports'      => [ 'title', 'excerpt', 'author', 'thumbnail', 'comments' ],
			'has_archive'   => false,
			'rewrite'       => true,
			'query_var'     => true,
		] );
	}
	
	
	add_filter('post_class', 'add_project_single_post_class');
	function add_project_single_post_class($classes) {
		if( !is_singular('project') ){
			return $classes;
		}
		
		$classes[] = 'projects-single';
		
		return $classes;
	}