<?php 

/*
 *******************
 * THEME STYLE OPTIONS
 *******************
 *
 *	Function to save all admin theme style options in a array, useable for CSS.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	2.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/


if ( ! function_exists( 'wphave_admin_theme_style_options' ) ) :

	function wphave_admin_theme_style_options() {
		
		// Get pre options
		$pre_option = new wphave_admin_settings();
		
		$vars = array();
		
		$vars[ 'wpatThemeColor' ] = wphave_option('theme_color');
		if( ! wphave_option('theme_color') ) {
			$vars[ 'wpatThemeColor' ] = $pre_option->pre_options['theme_color'];
		}
		
		$vars[ 'wpatGradientStartColor' ] = wphave_admin_hex2rgba( wphave_option('theme_background') );
		if( ! wphave_option('theme_background') ) {
			$vars[ 'wpatGradientStartColor' ] = wphave_admin_hex2rgba( $pre_option->pre_options['theme_background'] );
		}
		
		$vars[ 'wpatGradientEndColor' ] = wphave_admin_hex2rgba( wphave_option('theme_background_end') );
		if( ! wphave_option('theme_background_end') ) {
			$vars[ 'wpatGradientEndColor' ] = wphave_admin_hex2rgba( $pre_option->pre_options['theme_background_end'] );
		}
		
		$vars[ 'wpatToolbarColor' ] = wphave_option('toolbar_color');
		if( ! wphave_option('toolbar_color') ) {
			$vars[ 'wpatToolbarColor' ] = $pre_option->pre_options['toolbar_color'];
		}
		
		$vars[ 'wpatSpacingMaxWidth' ] = wphave_option('spacing_max_width') . 'px';
		if( ! wphave_option('spacing_max_width') ) {
			$vars[ 'wpatSpacingMaxWidth' ] = $pre_option->pre_options['spacing_max_width'] . 'px';
		}
		
		$vars[ 'wpatMenuLeftWidth' ] = wphave_option('left_menu_width') . 'px';
		if( ! wphave_option('left_menu_width') ) {
			$vars[ 'wpatMenuLeftWidth' ] = $pre_option->pre_options['left_menu_width'] . 'px';
		}
		
		$vars[ 'wpatMenuLeftWidthDiff' ] = wphave_option('left_menu_width') - 40 . 'px';
		if( ! wphave_option('left_menu_width') ) {
			$vars[ 'wpatMenuLeftWidthDiff' ] = $pre_option->pre_options['left_menu_width'] - 40 . 'px';
		}
		
		$vars[ 'wpatLoginLogoSize' ] = wphave_option('logo_size') . 'px';
		if( ! wphave_option('logo_size') ) {
			$vars[ 'wpatLoginLogoSize' ] = $pre_option->pre_options['logo_size'] . 'px';
		}

		$vars[ 'wpatToolbarIcon' ] = 'none';
		if( wphave_option('toolbar_icon') != '' ) {
			$vars[ 'wpatToolbarIcon' ] = 'url(' . wphave_option('toolbar_icon') . ')';
		}

		$vars[ 'wpatWebFont' ] = 'none';
		if( wphave_option('google_webfont') != '' ) {
			$web_font = str_replace( '+', ' ', esc_html( wphave_option('google_webfont') ) );
			$vars[ 'wpatWebFont' ] = '"' . $web_font . '"';
		}

		$vars[ 'wpatLoginBg' ] = 'none';
		if( wphave_option('login_bg') != '' ) {
			$vars[ 'wpatLoginBg' ] = 'url(' . wphave_option('login_bg') . ')';
		}

		$vars[ 'wpatLoginLogo' ] = 'none';
		if( wphave_option('logo_upload') != '' ) {
			$vars[ 'wpatLoginLogo' ] = 'url(' . wphave_option('logo_upload') . ')';
		}

		return $vars;

	}

endif;


/*
 *******************
 * CREATE + UPDATE CSS FILE WITH CUSTOM CSS PROPERTIES
 *******************
 *
 *	To affect style settings like the theme color to the admin view, we use CSS global variables.
 *	Here we generate all variables in the ":root" element saved as an CSS file.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	2.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_css_custom_properties_file' ) ) :

	function wphave_admin_css_custom_properties_file() {
		
		/****************
		* FILE CACHE
		* To provide to update the file content each time on page load, we use a option cache here.
		****************/
		
		// Get all admin theme style options
		$vars = wphave_admin_theme_style_options();
		// Define option name
		$transient_name = WPHAVE_ADMIN_NAMESPACE . '_style_vars';
		
		// Get the cached style vars
		$cached_vars = get_option( $transient_name );
		
		// Check if recombining of the style is necessary
		// In case if the current style vars do not match the cached style vars, we return true
		if( $vars != $cached_vars ) {

			// Delete old cached style vars
			delete_option( $transient_name );
			
			// Option does not exist, so save all current style vars in the option
			if( ! $cached_vars ) {

				// Cache data and save the option
				update_option( $transient_name, $vars, 'yes' );

			}

		}
		
		// Check if the style vars are the same as the cached style vars
		if( $vars === $cached_vars ) {
			// Stop here, we should not regenerate this file, because the style vars were not updated
			//return;
		}
		
		/****************
		* CSS FILE CONTENT
		****************/
		
		// Write the global CSS variables
		ob_start(); ?>

		:root {

			<?php 
			
			/****************
			* THEME COLOR
			****************/
		
			$theme_color = $vars[ 'wpatThemeColor' ];

			?>

		  	--wpatThemeColor: <?php echo esc_html( $theme_color ); ?>;
			
				<?php 

				/* Theme color [lighten] */ 

				?>

				--wpatThemeColor-lighten-10: <?php echo esc_html( wphave_admin_color_luminance( $theme_color, '0.1' ) ); ?>;
				--wpatThemeColor-lighten-20: <?php echo esc_html( wphave_admin_color_luminance( $theme_color, '0.2' ) ); ?>;
				--wpatThemeColor-lighten-30: <?php echo esc_html( wphave_admin_color_luminance( $theme_color, '0.3' ) ); ?>;
				--wpatThemeColor-lighten-40: <?php echo esc_html( wphave_admin_color_luminance( $theme_color, '0.4' ) ); ?>;
				--wpatThemeColor-lighten-50: <?php echo esc_html( wphave_admin_color_luminance( $theme_color, '0.5' ) ); ?>;
				--wpatThemeColor-lighten-60: <?php echo esc_html( wphave_admin_color_luminance( $theme_color, '0.6' ) ); ?>;
				--wpatThemeColor-lighten-70: <?php echo esc_html( wphave_admin_color_luminance( $theme_color, '0.7' ) ); ?>;
				--wpatThemeColor-lighten-80: <?php echo esc_html( wphave_admin_color_luminance( $theme_color, '0.8' ) ); ?>;
				--wpatThemeColor-lighten-90: <?php echo esc_html( wphave_admin_color_luminance( $theme_color, '0.9' ) ); ?>;
			
				<?php 

				/* Theme color [darken] */ 

				?>

				--wpatThemeColor-darken-10: <?php echo esc_html( wphave_admin_color_luminance( $theme_color, '-0.1' ) ); ?>;
				--wpatThemeColor-darken-20: <?php echo esc_html( wphave_admin_color_luminance( $theme_color, '-0.2' ) ); ?>;
				--wpatThemeColor-darken-30: <?php echo esc_html( wphave_admin_color_luminance( $theme_color, '-0.3' ) ); ?>;
				--wpatThemeColor-darken-40: <?php echo esc_html( wphave_admin_color_luminance( $theme_color, '-0.4' ) ); ?>;
				--wpatThemeColor-darken-50: <?php echo esc_html( wphave_admin_color_luminance( $theme_color, '-0.5' ) ); ?>;
				--wpatThemeColor-darken-60: <?php echo esc_html( wphave_admin_color_luminance( $theme_color, '-0.6' ) ); ?>;
				--wpatThemeColor-darken-70: <?php echo esc_html( wphave_admin_color_luminance( $theme_color, '-0.7' ) ); ?>;
				--wpatThemeColor-darken-80: <?php echo esc_html( wphave_admin_color_luminance( $theme_color, '-0.8' ) ); ?>;
				--wpatThemeColor-darken-90: <?php echo esc_html( wphave_admin_color_luminance( $theme_color, '-0.9' ) ); ?>;
			
				<?php 

				/* Theme color [fade] */ 

				?>

				--wpatThemeColor-fade-10: <?php echo esc_html( wphave_admin_hex2rgba( $theme_color, '0.1' ) ); ?>;

			<?php 
			
			/****************
			* TOOLBAR COLOR
			****************/
		
			$toolbar_color = $vars[ 'wpatToolbarColor' ];

			?>

			--wpatToolbarColor: <?php echo esc_html( $toolbar_color ); ?>;
			
				<?php 

				/* Toolbar color [lighten] */ 

				?>

				--wpatToolbarColor-lighten-10: <?php echo esc_html( wphave_admin_color_luminance( $toolbar_color, '0.1' ) ); ?>;
				--wpatToolbarColor-lighten-90: <?php echo esc_html( wphave_admin_color_luminance( $toolbar_color, '0.9' ) ); ?>;

			<?php 
			
			/****************
			* OTHER
			****************/

			?>

			--wpatGradientStartColor: <?php echo esc_html( $vars[ 'wpatGradientStartColor' ] ); ?>;

			--wpatGradientEndColor: <?php echo esc_html( $vars[ 'wpatGradientEndColor' ] ); ?>;

			--wpatSpacingMaxWidth: <?php echo esc_html( $vars[ 'wpatSpacingMaxWidth' ] ); ?>;

			--wpatMenuLeftWidth: <?php echo esc_html( $vars[ 'wpatMenuLeftWidth' ] ); ?>;

			--wpatMenuLeftWidthDiff: <?php echo esc_html( $vars[ 'wpatMenuLeftWidthDiff' ] ); ?>;

			--wpatLoginLogoSize: <?php echo esc_html( $vars[ 'wpatLoginLogoSize' ] ); ?>;

			--wpatToolbarIcon: <?php echo esc_html( $vars[ 'wpatToolbarIcon' ] ); ?>;

			--wpatWebFont: <?php echo esc_html( $vars[ 'wpatWebFont' ] ); ?>;

			--wpatLoginBg: <?php echo esc_html( $vars[ 'wpatLoginBg' ] ); ?>;

			--wpatLoginLogo: <?php echo esc_html( $vars[ 'wpatLoginLogo' ] ); ?>;

		}

		<?php $file_data = ob_get_clean();
		
		/****************
		* FILE GENERAION
		****************/
		
		// Initial WP file system
		$wp_filesystem = wphave_admin_file_system();
		
		// Define the file for global CSS variables
		$css_file = wphave_admin_dir( 'assets/css/custom-properties.css' );
		
		// Create or write the updated content to the file
		$wp_filesystem->put_contents( $css_file, $file_data, 0644 );
				
	}

endif;

add_action( 'admin_init', 'wphave_admin_css_custom_properties_file' );