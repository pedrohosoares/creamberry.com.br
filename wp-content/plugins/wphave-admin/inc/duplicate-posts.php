<?php

/*
 *******************
 * ADD DUPLICATE LINK TO POST LIST VIEW
 *******************
 *
 *  Add a duplicate link to each row of the post list view.
 *
 *  @type	filter / action
 *  @date	06/18/19
 *  @since	2.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if( ! function_exists('wphave_admin_add_duplicate_link_to_post_list') ) :

	function wphave_admin_add_duplicate_link_to_post_list( $actions, $post ) {

		if( wphave_option('duplicate_posts') ) {
			// Stop here, if disabled
			return $actions;
		}
		
		if( ! current_user_can('edit_post', $post->ID) ) {
			// Stop here, if the user can't edit posts
			return $actions;
		}

		$args = array(
			'action' => 'wphave_admin_action_duplicate_post',
			'post' => $post->ID,
			'nonce' => wp_create_nonce('wphave_admin_action_duplicate_post')
		);

		$url = add_query_arg( $args, admin_url() );
		$link = '<a href="' . esc_url( $url ) . '">' . __('Duplicate', 'list link', 'wphave-admin') . '</a>';

		$actions['wphave_duplicate'] = $link;

		// Return the duplicate link
		return $actions;

	}

endif;
	  
add_filter('post_row_actions', 'wphave_admin_add_duplicate_link_to_post_list', 10, 2);
add_filter('page_row_actions', 'wphave_admin_add_duplicate_link_to_post_list', 10, 2);


/*
 *******************
 * ADD DUPLICATE LINK TO WP ADMIN BAR
 *******************
 *
 *  Add a duplicate link to the WordPress admin bar.
 *
 *  @type	action
 *  @date	06/18/19
 *  @since	2.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if( ! function_exists('wphave_admin_add_duplicate_link_to_admin_bar') ) :

	function wphave_admin_add_duplicate_link_to_admin_bar( $admin_bar ) {

		if( wphave_option('duplicate_posts') ) {
			// Stop here, if disabled
			return;
		}
		
		if( ! is_admin() && ! function_exists('get_current_screen') ) {
			// Current screen is not always available
			// Do not continue here, because "get_current_screen" is only a backend function
			return;
		}

		$screen = get_current_screen();	

		// Check the current screen includes the "post" base
		if( ( strpos( $screen->base, 'post') === FALSE ) ) {
			// Stop here, if the base includes not "post"
			return;
		}

		$is_post = isset( $_GET['post'] ) && $_GET['post'] ? true : false;
		$is_edit_mode = isset( $_GET['action'] ) && $_GET['action'] === 'edit' ? true : false;

		if( ! $is_post && ! $is_edit_mode ) {
			// Stop here, if we are not in the post edit screen
			return;
		}
		
		$post = get_post();

		if( ! $post || ! current_user_can('edit_post', $post->ID) ) {
			// Stop here, if the user has no permission to edit the post
			return;
		}

		$args = array(
			'action' => 'wphave_admin_action_duplicate_post',
			'post' => $post->ID,
			'nonce' => wp_create_nonce('wphave_admin_action_duplicate_post'),
		);

		// Build the admin bar item
		$url = add_query_arg( $args, admin_url() );
		$title = '<span class="ab-icon"></span><span class="ab-label">' . __('Duplicate', 'wphave-admin') . '</span>';

		// Set the admin bar item
		$admin_bar->add_menu( array(
			'id' => 'wphave-admin-duplicate-post-link',
			'title' => $title,
			'href' => esc_url( $url ),
		) );

	}

endif;

add_action('admin_bar_menu', 'wphave_admin_add_duplicate_link_to_admin_bar', 100);


/*
 *******************
 * DUPLICATE POSTS + PAGES
 *******************
 *
 *  Function to manage the duplication of a specific post.
 *
 *  @type	action
 *  @date	06/18/19
 *  @since	2.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if( ! function_exists('wphave_admin_duplicate_post') ) :

	function wphave_admin_duplicate_post() {

		if( wphave_option('duplicate_posts') ) {
			// Stop here, if disabled
			return;
		}
		
		$is_post = isset( $_GET['post'] ) && $_GET['post'] ? true : false;
		$is_duplicate_action = isset( $_GET['action'] ) && $_GET['action'] === 'wphave_admin_action_duplicate_post' ? true : false;
		$has_wp_nonce = isset( $_GET['nonce'] ) && wp_verify_nonce( $_GET['nonce'], 'wphave_admin_action_duplicate_post') ? true : false;

		if( ! ( $is_post && $is_duplicate_action && $has_wp_nonce ) ) {
			// Stop here, if it's not the correct action
			return;
		}

		$post_id = intval( $_GET['post'] );	
		$post = get_post( $post_id );

		if( ! $post || ! current_user_can('edit_post', $post->ID) ) {
			// Stop here, if the user has no permission to edit the post
			return;
		}

		// Define the new post title subfix
		$title_subfix =  ' - ' . __('Duplicate', 'wphave-admin');

		$new_post_title = $post->post_title . $title_subfix;

		$args = array(
			'post_content' => $post->post_content,
			'post_title' => $new_post_title,
			'post_excerpt' => $post->post_excerpt,
			'post_status' => 'publish', // <-- We have to set the "post_status" temporary to "publish" --> Otherwise wp_unique_post_slug() is not working
			'post_type' => $post->post_type,
			'comment_status' => $post->comment_status,
			'ping_status' => $post->ping_status,
			'post_password' => $post->post_password,
			'post_name' => wp_unique_post_slug( $post->post_name, $post->ID, $post->post_status, $post->post_type, $post->post_parent ), // <-- Post slug
			'to_ping' => $post->to_ping,
			'post_parent' => $post->post_parent,
			'menu_order' => $post->menu_order,
			'post_mime_type' => $post->post_mime_type
		);

		$new_post_id = wp_insert_post( $args );

		// Update the "post_status" to draft
		$new_post = array();
		$new_post['ID'] = $new_post_id;
		$new_post['post_status'] = 'draft'; // <-- Lastly we set the "post_status" to "draft"
		wp_update_post( $new_post );

		// Add existing post meta to the new post
		foreach( get_post_meta( $post_id ) as $key => $value ) {
			if( is_array( $value ) ) {
				foreach( $value as $value2 ) {
					$data = @unserialize( $value2 );
					if( $data !== false ) {
						add_post_meta( $new_post_id, $key, $data );
					} else {
						add_post_meta( $new_post_id, $key, wp_slash( $value2 ) );
					}
				}
			} else {
				add_post_meta( $new_post_id, $key, wp_slash( $value ) );
			}
		}

		// Add existing taxonomy terms to the new post
		$taxonomies = get_object_taxonomies( $post->post_type );

		if( ! empty( $taxonomies ) && is_array( $taxonomies ) ) {
			foreach( $taxonomies as $taxonomy ) {
				$post_terms = wp_get_object_terms( $post_id, $taxonomy, ['fields' => 'slugs'] );
				wp_set_object_terms( $new_post_id, $post_terms, $taxonomy, false );
			}
		}

		// Redirect to the post view list of the current post type
		wp_redirect( admin_url( 'edit.php?post_type=' . $post->post_type ) );

	}

endif;

add_action('admin_action_wphave_admin_action_duplicate_post', 'wphave_admin_duplicate_post');