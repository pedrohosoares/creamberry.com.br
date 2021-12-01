<?php 

/*
 *******************
 * ADD PLUGIN ACTIVATION SUBPAGE
 *******************
 *
 *	Create a subpage for plugin activation.
 *
 *  @type	filter
 *  @date	06/18/19
 *  @since	3.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_page_activation' ) ) :

	function wphave_admin_page_activation() {
			
		add_submenu_page(
			NULL,
			WPHAVE_ADMIN_PLUGIN_NAME . ' ' . esc_html__( 'Activation', 'wphave-admin' ),
			esc_html__( 'Activation', 'wphave-admin' ),
			'manage_options',
			'wphave-admin-purchase-code',
			'wphave_admin_purchase_code_page'
		);
		
	}

endif;

add_action( 'admin_menu', 'wphave_admin_page_activation' );


/*
 *******************
 * TEMPLATE PART - PURCHASE CODE FIELD
 *******************
 *
 *	Template part to output the field for entering the purchase code.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	3.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_code_field' ) ) :

	function wphave_admin_code_field() { 

		// Get activation status
		$is_activated = wphave_admin_activation_status();
		
		// Get input value
		$input_value = '';
		$purchase_code = get_option( wphave_admin_envato_purchase_code() );
		$input_value = isset( $purchase_code ) ? $purchase_code : 'n/a';
		
		// Manage input type
		$input_type = 'text';
		$input_type = 'password';
		
		/****************
		* PURCHASE CODE - INPUT FIELD
		****************/

		?>
			
		<input id="purchase_code" name="purchase_code" type="<?php echo esc_html( $input_type ); ?>" placeholder="<?php echo esc_html__( 'Enter your Purchase Code', 'wphave-admin' ); ?>" value="<?php echo esc_html( $input_value ); ?>" size="40" required />
		<div id="purchase_code_show" class="button">
			<span class="dashicons dashicons-visibility"></span>
			<span class="dashicons dashicons-hidden" style="display: none"></span>
		</div>

		<input id="purchase_root_url" name="purchase_root_url" type="hidden" value="<?php echo wphave_admin_root_url(); ?>" size="40" disabled />										
		<input id="purchase_client_mail" name="purchase_client_mail" type="hidden" size="40" placeholder="<?php echo esc_html__( 'E-mail address', 'wphave-admin' ); ?>" />
		
	<?php }

endif;


/*
 *******************
 * TEMPLATE PART - ACTIVATION BUTTON
 *******************
 *
 *	Template part to output the button for activating the purchase code.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	3.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_activation_button' ) ) :

	function wphave_admin_activation_button() { 

		// Get activation status
		$is_activated = wphave_admin_activation_status();
		
		/****************
		* ACTIVATION - BUTTON
		****************/

		?>
			
		<input id="btn_purchase" type="submit" class="button button-primary" value="<?php echo esc_html__( 'Verify and install license', 'wphave-admin' ); ?>"<?php if( $is_activated ) { ?> disabled<?php } ?> />
		
	<?php }

endif;


/*
 *******************
 * TEMPLATE PART - UNLOCK/RESET BUTTON
 *******************
 *
 *	Template part to output the button for unlocking/reseting the purchase code.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	3.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_unlock_reset' ) ) :

	function wphave_admin_unlock_reset() { 

		// Get purchase data from the users purchase code
		$purchase_data = wphave_admin_get_purchase_theme_details();
		
		/****************
		* UNLOCK - BUTTON
		****************/
		
		?>
			
		<div id="btn_delete_license" class="button">
			<?php echo esc_html__( 'Unlock license', 'wphave-admin' ); ?>
		</div>

		<?php
		
		/****************
		* RESET - BUTTON
		****************/
		
		// By calling URL parameter "reset-purchase-code=on" (http://domain.com/wp-admin/tools.php?page=wphave-admin-purchase-code&tab=activation&reset-purchase-code=on)
		// We can show the "reset license" dialog
		$show_reset_button = isset( $_GET['reset-purchase-code'] ) ? $_GET['reset-purchase-code'] : '';
		$visibility = 'none';
		if( $show_reset_button === 'on' ) {
			$visibility = 'block';
		} ?>

		<div class="license-reset" style="display: <?php echo esc_html( $visibility ); ?>">
			<p>
				<?php $author_mail = '<a href="mailto:' . esc_html( WPHAVE_ADMIN_AUTHOR_MAIL ) . '?subject=' . esc_html__( 'Request to unlock the plugin license for', 'wphave-admin' ) . ' ' . WPHAVE_ADMIN_PLUGIN_NAME . '&amp;body=' . esc_html__( 'Please unlock my purchase code for the following domain:', 'wphave-admin' )  . ' ' . wphave_admin_root_url() . '%0D%0A %0D%0A' . esc_html__( 'Purchase code:', 'wphave-admin' ) . ' ' . $purchase_data['purchase_code'] . '">' . esc_html__( 'contact the author', 'wphave-admin' ) . '</a>';
				printf( wp_kses_post( __( 'In some cases unlocking the license is not possible. Therefore, you can reset the license key. If you can not reactivate after resetting the license, %1$s of the plugin to manually unlock the license.', 'wphave-admin' ) ), $author_mail ); ?>	
			</p>
			<div id="btn_reset_license" class="button">
				<?php echo '(!) ' . esc_html__( 'Reset license', 'wphave-admin' ); ?>
			</div>
		</div>
		
	<?php }

endif;


/*
 *******************
 * PLUGIN ACTIVATION SUBPAGE CONTENT
 *******************
 *
 *	Output the content for plugin activation subpage.
 *
 *  @type	filter
 *  @date	06/18/19
 *  @since	3.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_purchase_code_page' ) ) :

	function wphave_admin_purchase_code_page() { 

		// Deny page access for sub sites	
		if( ! wphave_admin_deny_access() ) {
			return wphave_admin_no_access();
		}
		
		// Get purchase data from the users purchase code
		$purchase_data = wphave_admin_get_purchase_theme_details();
		
		// Get activation status
		$is_activated = wphave_admin_activation_status();

		// Get the purchase code
		$purchase_code = get_option( wphave_admin_envato_purchase_code() );

		$activation_label = '<span style="color:#d63316">(' . esc_html__( 'Deactivated', 'wphave-admin' ) . ')</span>';
		if( $is_activated ) {
			$activation_label = '<span style="color:#8db51e">(' . esc_html__( 'Activated', 'wphave-admin' ) . ')</span>';							
		} ?>
	
		<div class="wrap about-wrap wpat-plugin-welcome">
			<div id="poststuff">
				<div id="post-body" class="metabox-holder columns-2">
					<div id="post-body-content">
						<div class="settings-wrapper">
							<div class="inside">
								
								<h1>
									<?php echo wphave_admin_title(); ?>
								</h1> 

								<br><br>
								
								<?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'activation'; 
								echo wphave_admin_tab_menu( $active_tab ); ?>

								<h3>
									<?php echo esc_html__( 'Plugin Activation', 'wphave-admin' ) . ' ' . wp_kses_post( $activation_label ); ?>
								</h3>

								<?php 
		
								$show_license_box = (  wphave_admin_plugin_with_theme() );
								if( is_multisite() ) {
									$blog_id = 1; // <-- Option from main site
									$show_license_box = ( ! wphave_admin_plugin_with_theme() && get_current_blog_id() == $blog_id );
								}
		
								if( $show_license_box ) { ?>

								
									<?php 
											
						
									/****************
									* UNLOCK PURCHASE CODE BY YOURSELF - API
									****************/

									//$unlock_link = home_url() . '?wphave_license_api=access';
									$unlock_link = 'https://wphave.com?wphave_license_api=access';
									$nonced_link = wp_nonce_url( $unlock_link, 'unlock-license', '_wphave_nonce' );

									
									?>
									
									
								<?php 
														 
								/****************
								* ACTIVATION - NOTICE
								****************/	 
														 
								} ?>

							</div>
						</div>
					</div>		

				</div>
			</div>

		</div>
		
	<?php }

endif;