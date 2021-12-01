<?php 

/*
 *******************
 * CREATE PLUGIN PATHS
 *******************
 *
 *	By adding custom wp filter, this plugin can be called from theme folder without installing it manually.
 *
 *  @type	filter
 *  @date	06/18/19
 *  @since	3.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_path' ) ) :

    function wphave_admin_path( $path ) {
        
		// Get custom filter path	
        if( has_filter( 'wphave_admin_path' ) ) {
			return apply_filters( 'wphave_admin_path', $path );
		}
        
		// Get plugin path
		return plugins_url( $path, __DIR__ );
        
    }

endif;


if ( ! function_exists( 'wphave_admin_dir' ) ) :

    function wphave_admin_dir( $path ) {

		// Get custom filter dir path
        if( has_filter( 'wphave_admin_dir' ) ) {
			return apply_filters( 'wphave_admin_dir', $path );	
		}
        
		// Get plugin dir path
		return plugin_dir_path( __DIR__ ) . $path;
        
    }

endif;


/*
 *******************
 * GET THE CURRENT PLUGIN VERSION
 *******************
 *
 *	Function to return the current version of this plugin. You can change the version number of the plugin in the related base file.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	2.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_get_plugin_version' ) ) :

	function wphave_admin_get_plugin_version() {

		if( ! is_admin() ) {
			return;
		}

		if( ! function_exists('get_plugin_data') ){
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		$plugin = get_plugin_data( WPHAVE_ADMIN_FILE_PATH ); // <-- Absolute path to the plugin base file
		$plugin = $plugin['Version'];

		// Return the version number of the plugin base file
		return $plugin;		

	}

endif;

// Define a plugin version constant
define( 'WPHAVE_ADMIN_VERSION', wphave_admin_get_plugin_version() );


/*
 *******************
 * HEX TO RGBA
 *******************
 *
 *	Switch a hex color code to a rgba color code.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	3.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_hex2rgba' ) ) :

	function wphave_admin_hex2rgba( $color, $opacity = false, $raw = false ) {

		$default = 'rgb(0,0,0)';

		// Return default if no color provided
		if( empty( $color ) ) {
			return $default;
		}

		// Sanitize $color if "#" is provided 
		if( $color[0] == '#' ) {
			$color = substr( $color, 1 );
		}

		// Check if color has 6 or 3 characters and get values
		if( strlen( $color ) == 6 ) {
			$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) == 3 ) {
			$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
			return $default;
		}

		// Convert hexadec to rgb
		$rgb = array_map( 'hexdec', $hex );

		// Check if opacity is set(rgba or rgb)
		if( $opacity ) {
			if( abs( $opacity ) > 1 ) $opacity = 1.0;
			$output = 'rgba(' . implode( ",", $rgb ) . ',' . $opacity . ')';
			if( $raw ) {
				$output = implode( ",", $rgb ) . ',' . $opacity;
			}
		} else {
			$output = 'rgb(' . implode( ",", $rgb ) . ')';
			if( $raw ) {
				$output = implode( ",", $rgb );
			}
		}

		// Return rgb(a) color string
		return $output;

		/* Usage example:

		$color = '#ffa226';
		$rgb = hex2rgba($color);
		$rgba = hex2rgba($color, 0.7);

		*/

	}

endif;


/*
 *******************
 * HEX LIGHTEN  / DARKEN
 *******************
 *
 *	Function to lighten or darken a hex color code.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	3.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_color_luminance' ) ) :

	function wphave_admin_color_luminance( $hexcolor, $percent ) {

		if( strlen( $hexcolor ) < 6 ) {
			$hexcolor = $hexcolor[0] . $hexcolor[0] . $hexcolor[1] . $hexcolor[1] . $hexcolor[2] . $hexcolor[2];
		}

		$hexcolor = array_map( 'hexdec', str_split( str_pad( str_replace('#', '', $hexcolor), 6, '0' ), 2 ) );

		foreach( $hexcolor as $i => $color ) {

			$from = $percent < 0 ? 0 : $color;
			$to = $percent < 0 ? $color : 255;
			$pvalue = ceil( ( $to - $from ) * $percent );
			$hexcolor[$i] = str_pad( dechex( $color + $pvalue ), 2, '0', STR_PAD_LEFT );

		}

		return '#' . implode( $hexcolor );

	}

endif;


/*
 *******************
 * CSS MINIFY
 *******************
 *
 *	A simple version to compress stylesheet code to reduce the file site.
 * 	Notice: Very helpful to create regex
 * 	@ https://www.phpliveregex.com/#tab-preg-match-all
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	2.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_minify_css' ) ) :

	function wphave_admin_minify_css( $css ) {
		
		// Remove comments
		$css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
		
		// Backup values within single or double quotes
		preg_match_all('/(\'[^\']*?\'|"[^"]*?")/ims', $css, $hit, PREG_PATTERN_ORDER);
		for( $i=0; $i < count($hit[1]); $i++ ) {
			$css = str_replace($hit[1][$i], '##########' . $i . '##########', $css);
		}
		
		// Remove traling semicolon of selector's last property
		$css = preg_replace('/;[\s\r\n\t]*?}[\s\r\n\t]*/ims', "}\r\n", $css);
		
		// Remove any whitespace between semicolon and property-name
		$css = preg_replace('/;[\s\r\n\t]*?([\r\n]?[^\s\r\n\t])/ims', ';$1', $css);
		
		// Remove any whitespace surrounding property-colon
		$css = preg_replace('/[\s\r\n\t]*:[\s\r\n\t]*?([^\s\r\n\t])/ims', ':$1', $css);
		
		// Remove any whitespace surrounding selector-comma
		$css = preg_replace('/[\s\r\n\t]*,[\s\r\n\t]*?([^\s\r\n\t])/ims', ',$1', $css);
		
		// Remove any whitespace surrounding opening parenthesis
		$css = preg_replace('/[\s\r\n\t]*{[\s\r\n\t]*?([^\s\r\n\t])/ims', '{$1', $css);
		
		// Remove any whitespace between numbers and units
		$css = preg_replace('/([\d\.]+)[\s\r\n\t]+(px|em|pt|%)/ims', '$1$2', $css);
	
		// Shorten zero-values
		if( ! preg_match('/(0%{|0% {)/', $css) ) { // <-- Do not shorten "@keyframes animationName { 0% {...} }" to avoid breaking CSS animations
			$css = preg_replace('/([^\d\.]0)(px|em|pt|%)/ims', '$1', $css);
		}
		
		// Constrain multiple whitespaces
		$css = preg_replace('/\p{Zs}+/ims',' ', $css);
		
		// Remove newlines
		$css = str_replace(array("\r\n", "\r", "\n"), '', $css);
		
		// Remove a tab
		$css = str_replace("\t", " ", $css);
		
		// Restore backupped values within single or double quotes
		for( $i=0; $i < count($hit[1]); $i++ ) {
			$css = str_replace('##########' . $i . '##########', $hit[1][$i], $css);
		}
		
  		return $css;
		
	}

endif;


/*
 *******************
 * GET THE CURRENT POST TYPE
 *******************
 *
 *	Function to return the current post type.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	3.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_get_current_post_type' ) ) :

	function wphave_admin_get_current_post_type() {

		if( ! is_admin() ) {
			return;
		}
		
		global $post, $typenow, $current_screen, $pagenow;

		// We have a post so we can just get the post type from that
		if( $post && isset( $post->post_type ) ) {
			return $post->post_type;
			
		// Check the global $typenow - set in admin.php
		} elseif( $typenow ) {
			return $typenow;
			
		// Check the global $current_screen object - set in sceen.php
		} elseif( $current_screen && isset( $current_screen->post_type ) ) {
			return $current_screen->post_type;
			
		// Check the post_type querystring
		} elseif( isset( $_REQUEST['post_type'] ) ) {
			return sanitize_key( $_REQUEST['post_type'] );
			
		// Lastly check if post ID is in query string
		} elseif( isset( $_REQUEST['post'] ) ) {
    		return get_post_type( $_REQUEST['post'] );
  		}

		return null;

	}

endif;


/*
 *******************
 * SSL FIRENDLY WP_UPLOAD_DIR
 *******************
 *
 *	By default the wp_upload_dir() function dosen't support SSL urls.
 *	Therefore we use a wrapper function to output the urls with "https" in the case SSL is used.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	3.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_upload_dir' ) ) : 

	function wphave_admin_upload_dir() {

		// Get the upload dir
		$upload_dir = wp_upload_dir();
		
		// Check if SSL is used
		if( ! is_ssl() ) {
			// If not, return the default wp_upload_dir() function
			return $upload_dir;
		} 
		
		// Create a new array
		$upload_dir_ssl = array();
		
		foreach( $upload_dir as $dir => $value ) {
			
			// Check for "url" and "baseurl"
			if( $dir === 'url' || $dir === 'baseurl' ) {
				// Replace "http://" with "https://" to get SSL firendly urls
				$value = str_replace( 'http://', 'https://', $value );
			}
				
			// Add to the new array
			$upload_dir_ssl[$dir] = $value;
			
		}
		
		// Return the new upload dir array
		return $upload_dir_ssl;

	}

endif;


/*
 *******************
 * ACCESS WP FILE SYSTEM
 *******************
 *
 *	If we use "$wp_filesystem" on frontend, we have to include an additional admin function.
 *	This function can be used with the included admin function without having to re-integrate it for each case.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	3.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_file_system' ) ) : 

	function wphave_admin_file_system() {

		if( ! function_exists('WP_Filesystem') ) {
			// We have to include this WordPress file, if "WP_Filesystem()" is called outside of wp admin.
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}
		
		// Initial WP file system
		global $wp_filesystem;
		WP_Filesystem();
		
		return $wp_filesystem;

	}

endif;


/*
 *******************
 * GET INSTALLATION URL
 *******************
 *
 *	Function to return the root url.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	3.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_root_url' ) ) : 

	function wphave_admin_root_url() {

		// Get the full WordPress installation path (included subfolders)
		if( is_multisite() ) {
			return get_site_url( get_current_blog_id() );
		}
		
		return get_site_url();

	}

endif;


/*
 *******************
 * MYSQLI CONNECTION
 *******************
 *
 *	Create a connection to the WordPress MySQL database.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	3.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_mysqli_connect' ) ) : 

	function wphave_admin_mysqli_connect() {

		$mysqli = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

		// Check for MySQL connection error
		if( ! $mysqli || $mysqli->connect_error ) {
			
			// Close MySQL connection
			mysqli_close( $mysqli );
			
			// Stop connection
			return false;
		}
		
		// Connection successful
		return $mysqli;

	}

endif;


/*
 *******************
 * EXTERNAL FILE EXIST CHECK
 *******************
 *
 *	Function to check if a remote / external file exists.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	2.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_external_file_exists' ) ) : 

	function wphave_admin_external_file_exists( $file_path, $args = '' ) {

		$authorization = isset( $args['auth'] ) && $args['auth'] ? true : '';
		$content_type = isset( $args['content_type'] ) && $args['content_type'] ? $args['content_type'] : 'application/json';
		$username = isset( $args['username'] ) && $args['username'] ? $args['username'] : '';
		$password = isset( $args['password'] ) && $args['password'] ? $args['password'] : '';
		
		// Remote file url
		$remoteFile = $file_path;

		// Initialize cURL
		$ch = curl_init( $remoteFile );
		curl_setopt( $ch, CURLOPT_NOBODY, true );
		
		// Optional authorization for .htpasswd protected directories
		if( $authorization && $username && $password ) {
			$headers = array(
				'Content-Type: ' . $content_type,
				'Authorization: Basic ' . base64_encode( $username . ':' . $password ),
			);
			curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
		}
		
		curl_exec( $ch );
		$responseCode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
		curl_close( $ch );

		// Check the response code
		if( $responseCode == 200 ) {
			return true;
		}
		
		return false;

	}

endif;


/*
 *******************
 * PLUGIN USAGE
 *******************
 *
 *	Using the "wphave_admin_license_accepted" filter inside a "wphave" theme, allow us to use the "wphave - admin" plugin for free.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	3.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

function wphave_admin_plugin_with_theme() {
	
	$permission = 'denied';	
	
	// Current filter for "wphave - Admin"
	if( has_filter('wphave_admin_license_accepted') ) {
		$apply = apply_filters('wphave_admin_license_accepted', $permission);
		if( $apply === 'accepted_by_theme' || $apply === 'accepted' ) {
			return true;
		}
	}
	
	// Old filter for deprecated "WP Admin Theme CD" version
	if( has_filter('wp_admin_theme_cd_accepted') ) {
		$apply = apply_filters('wp_admin_theme_cd_accepted', $permission);
		if( $apply === 'accepted_by_theme' || $apply === 'accepted' ) {
			return true;
		}
	}
	
	return false;
	
}

add_action('admin_init', 'wphave_admin_plugin_with_theme');


/*
 *******************
 * PLUGIN ACTIVATION REDIRECT
 *******************
 *
 *	Redirect for unlicensed users, who visit the main page of the plugin.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	3.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/
		
function wphave_admin_activation_redirect() {

	// Stop here, if the license is activated
	return;
	

	// Check current page is "wphave-admin"
	if( isset( $_GET['page'] ) && $_GET['page'] == 'wphave-admin' ) {
		// Redirect to plugin "wphave-admin-purchase-code&tab=activation" page to verify the plugin
		wp_redirect( admin_url('tools.php?page=wphave-admin-purchase-code&tab=activation') );
		exit();
	}

}

add_action('admin_init', 'wphave_admin_activation_redirect', 1);


/*
 *******************
 * RESTRICT PLUGIN OPTIONS ACCESS
 *******************
 *
 *	Restrict the access to update options for sub sites only.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	3.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/
		
function wphave_admin_option_access() {

	$access = true;
	
	if( is_multisite() ) {
		$parent_blog_id = '1';
		$blog_option = get_blog_option( $parent_blog_id, 'wp_admin_theme_settings_options');
		
		// Get pre options
		$pre_option = new wphave_admin_settings();
		
		$resctrict_options = isset( $blog_option['disable_theme_options'] ) ? $blog_option['disable_theme_options'] : $pre_option->pre_options['disable_theme_options'];
		$deny_full_access = isset( $blog_option['disable_plugin_subsite'] ) ? $blog_option['disable_plugin_subsite'] : $pre_option->pre_options['disable_plugin_subsite'];
		
		if( $resctrict_options || $deny_full_access ) { // <-- Only the option of the blog ID 1 is essential here
			$access = ( get_current_blog_id() == $parent_blog_id );
		}
	}
	
	return $access;

}


/*
 *******************
 * DENY FULL PLUGIN OPTIONS ACCESS
 *******************
 *
 *	Deny the full access to for sub sites only.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	3.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/
		
function wphave_admin_deny_access() {

	$access = true;
	
	if( is_multisite() ) {
		$parent_blog_id = '1';
		$blog_option = get_blog_option( $parent_blog_id, 'wp_admin_theme_settings_options');
		
		// Get pre options
		$pre_option = new wphave_admin_settings();
		
		$deny_full_access = isset( $blog_option['disable_plugin_subsite'] ) ? $blog_option['disable_plugin_subsite'] : $pre_option->pre_options['disable_plugin_subsite'];
		
		if( $deny_full_access ) { // <-- Only the option of the blog ID 1 is essential here
			$access = ( get_current_blog_id() == $parent_blog_id );
		}
	}
	
	return $access;

}


/*
 *******************
 * NO ACCESS TEMPLATE PART
 *******************
 *
 *	Output the no access template part with message.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	3.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/
		
function wphave_admin_no_access() { ?>

	<div class="wrap">
		<?php echo esc_html__( 'You have no permissions to access this page!', 'wphave-admin' ); ?>
	</div>

<?php }


/*
 *******************
 * CLEAR GOOGLE FONT OPTION VALUE
 *******************
 *
 *	Strip districted characters from the google font value.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	2.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_clear_google_font_string' ) ) : 

	function wphave_admin_clear_google_font_string( $string ) {
		
		// Remove all characters from the string with exception of letters and numbers [^a-zA-Z0-9]
		// --> "\s," means the character "," (comma) is an exception of a valid character
		// --> Add more valid characters by adding "\s;", "\s_" or "\s@" to the pattern.
		return preg_replace("/[^a-zA-Z0-9\s,]/", "", $string);
		
	}

endif;