<?php 

/*
 *******************
 * ADD PLUGIN SPECIFIC ASSETS
 *******************
 *
 *	Enqueue assets for plugin page only.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	3.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists('wphave_admin_page_assets') ) :

	function wphave_admin_page_assets( $hook ) {

		// Method to get the page hook
		// wp_die($hook);

		// List all plugin pages
		$plugin_pages = array(
			'tools_page_wphave-admin',
			'tools_page_wphave-admin-server-info',
			'tools_page_wphave-admin-wp',
			'tools_page_wphave-admin-constants',
			'tools_page_wphave-admin-error-log',
			'tools_page_wphave-admin-htaccess',
			'tools_page_wphave-admin-php-ini',
			'tools_page_wphave-admin-robots-txt',
			'tools_page_wphave-admin-transient-manager',
			'tools_page_wphave-admin-export',
			'tools_page_wphave-admin-update-network',
			'tools_page_wphave-admin-purchase-code'
		);		
		
		// Load only on admin_toplevel_page?page=mypluginname
		if( ! in_array( $hook, $plugin_pages ) ) {
			return;
		}
		
		// Add admin page css
		wp_enqueue_style( 
			'wphave-admin-page', wphave_admin_path( 'assets/css/wphave-admin-page.css' ), array(), null, 'all'
		);
		
		// Add color picker css
		wp_enqueue_style( 'wp-color-picker' );

		// Add media upload js
		wp_enqueue_media();

		// Add plugin js		
		wp_enqueue_script( 
			'wphave-admin-plugin-js', wphave_admin_path( 'assets/js/plugin.js' ), array( 'jquery', 'wp-color-picker' ), null, true 
		);

	}

endif;

add_action( 'admin_enqueue_scripts', 'wphave_admin_page_assets' ); 


/*
 *******************
 * ADD ADMIN ASSETS
 *******************
 *
 *	Enqueue global admin assets.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	3.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists('wphave_admin_assets') ) :

	function wphave_admin_assets() {

		// Initial WP file system
		$wp_filesystem = wphave_admin_file_system();
		
		// Define the file path + url at "/wp-content/uploads/"
		$upload_dir = wphave_admin_upload_dir();
		
		$file_path = path_join( $upload_dir['basedir'], 'wp-combined' );
		$file_url = path_join( $upload_dir['baseurl'], 'wp-combined' );
		
		// Create folder "wp-combined" if it doesn't exist yet
		if( ! file_exists( $file_path ) ) {
			wp_mkdir_p( $file_path );
		}		
		
		// Define the file name
		$file_css = 'wphave-admin-combined-css.css';
		
		// Define the file locations
		$css_file = ( $file_path . '/' . $file_css );
		
		// Save style file paths into array
		$compine_css = array();
		
		$compine_css[] = wphave_admin_dir( 'assets/css/custom-properties.css' );
		$compine_css[] = wphave_admin_dir( 'assets/css/buttons.css' );
		$compine_css[] = wphave_admin_dir( 'assets/css/forms.css' );
		$compine_css[] = wphave_admin_dir( 'assets/css/style.css' );
		$compine_css[] = wphave_admin_dir( 'assets/css/pages.css' );
		$compine_css[] = wphave_admin_dir( 'assets/css/plugins.css' );
		$compine_css[] = wphave_admin_dir( 'assets/css/block-editor.css' );
		
		// Add admin rtl css
		if( is_rtl() ) {	
			$compine_css[] = wphave_admin_dir( 'assets/css/rtl.css' );
		}
		
		// Add custom admin css
		if( wphave_option('css_admin') ) {
			$compine_css[] = wphave_admin_dir( 'assets/css/admin.css' );
		}
		
		// Get the filetimes for all files
		$file_times = array();
		foreach( $compine_css as $file ) {
			// Get the filetime
			$file_times[] = filemtime( $file );
		}
		
		// Define transient name
		$transient_name = WPHAVE_ADMIN_NAMESPACE . '_style_file_times';
		
		// Get the cached file times
		$cached_file_times = get_transient( $transient_name );
		
		// Check if recombining of the style is necessary
		// In case if the current file times do not match the cached file times
		if( ! file_exists( $css_file ) || $file_times != $cached_file_times ) {

			// Delete old cached file times
			delete_transient( $transient_name );
			
			// Transient does not exist, so save all current file times in transient
			if( false === ( $data = get_transient( $transient_name ) ) ) {

				// Get the current file times
				$data = $file_times;

				// Cache data and save as transient
				set_transient( $transient_name, $data, 30 * DAY_IN_SECONDS );

			}
			
			// Get file content from all enqueued css files
			$combined_css = '';
			foreach( $compine_css as $css_file_path ) {
				// Get the file content
				$combined_css .= $wp_filesystem->get_contents( $css_file_path );
			}
			
			// MINIFY + COMBINE
			if( ! empty( $combined_css ) ) {

				// Write the merged style into current theme directory
				ob_start();

					$combined_css = wphave_admin_minify_css( $combined_css );
					echo $combined_css;

				$file_data = ob_get_clean();
				$wp_filesystem->put_contents( $css_file, $file_data, 0644 );

			}

		}
		
		// Enqueue the compined and minified style file
		if( file_exists( $css_file ) ) {
			wp_enqueue_style( 
				'wphave-admin-style', $file_url . '/' . $file_css, array(), filemtime( $css_file ), 'all' 
			);
		}
		
		// Add admin js		
		wp_enqueue_script( 
			'wphave-admin-main-js', wphave_admin_path( 'assets/js/main.js' ), array( 'jquery' ), null, true 
		);

		/*
		 *******************
		 * ADMIN STYLE (DUMMY)
		 *******************
		 *
		 *	Handle for using inline styles.
		 *  ! Notice: Adding a dummy handler is required to assign an inline styles (without dependency) when merging styles into a file.
		*/

		wp_register_style( 'wphave-admin-style', false );
		wp_enqueue_style( 'wphave-admin-style' );	
		
		// Avoiding flickering to reorder the first menu item (User Box) for left toolbar
		//$custom_css = "#adminmenu li:first-child { display:none }";
		//wp_add_inline_style( 'wphave-admin-style', $custom_css );

		// Add HTML tag style for toolbar hide view
		if( wphave_option('toolbar') && ! wphave_option('spacing') || wphave_option('toolbar') && wphave_option('spacing') ) {
			$toolbar_hide_css = "@media (min-width: 960px) { html.wp-toolbar { padding:0px } }";
			wp_add_inline_style( 'wphave-admin-style', $toolbar_hide_css );
		}

	}

endif;

add_action( 'admin_enqueue_scripts', 'wphave_admin_assets' );


/*
 *******************
 * GOOGLE FONTS
 *******************
 *
 *	Include Google Fonts to WordPress admin.
 *
 *  @type	filter
 *  @date	06/18/19
 *  @since	3.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_google_fonts_url' ) ) :

	function wphave_admin_google_fonts_url( $font_style = '' ) {

		$fonts = '';

		// Get custom font name
		$fonts .= wphave_option('google_webfont');

		// Check if custom font weight exist
		if( ! empty( wphave_option('google_webfont_weight') ) ) {													
			$fonts .= ':' . wphave_option('google_webfont_weight');
		}

		$subset = 'latin,latin-ext';
		
		$font_style = add_query_arg( array(
			'family' => esc_html( $fonts ), // Font url
			'subset' => $subset, // Font script subset
			'display' => 'swap', // Font display
		), 'https://fonts.googleapis.com/css' );
		
		return esc_url_raw( $font_style );
	}

endif;


if ( ! function_exists( 'wphave_admin_include_google_fonts' ) ) :

	function wphave_admin_include_google_fonts() {

		if( ! wphave_option('google_webfont') ) {
			// Stop here, if no fonts are loaded
			return;
		}
		
		wp_enqueue_style( 'wphave_admin_webfonts', wphave_admin_google_fonts_url(), array(), null, 'all' );

	}

endif;

add_action( 'admin_enqueue_scripts', 'wphave_admin_include_google_fonts', 30 );