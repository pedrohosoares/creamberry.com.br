<?php

/*
 *******************
 * AUTO-UPDATE PLUGIN INFO
 *******************
 *
 *	Function to list important parts for the plugin update process.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	2.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_update_info' ) ) :

	function wphave_admin_update_info() {

		$plugin = array();
		
		$plugin['slug'] = WPHAVE_ADMIN_NAMESPACE;
		$plugin['name'] = WPHAVE_ADMIN_PLUGIN_NAME;
		$plugin['version'] = WPHAVE_ADMIN_VERSION;
		$plugin['path'] = WPHAVE_ADMIN_NAMESPACE . '/' . WPHAVE_ADMIN_NAMESPACE . '.php';
		//$plugin['description'] = __('Designed for all the people, who loves to create websites with WordPress. A clean, beautiful and modern admin theme. This theme plugin is very easy to customize and packed with useful features such as wp memory usage, custom login page, custom theme colors and many more.', 'wphave-admin');
		$plugin['installation'] = __('Visit our website to learn more about the installation and update process: <ul><li>Installation: https://wphave.com/documentation/installation/</li><li>Update: https://wphave.com/documentation/update/</li></ul>', 'wphave-admin');
		$plugin['changelog'] = __('Visit our website to see the version changelog on https://wphave.com/changelog/', 'wphave-admin');
		$plugin['banner_low'] = wphave_admin_path( 'assets/img/banner-772x250.jpg' );
		$plugin['banner_high'] = wphave_admin_path( 'assets/img/banner-1544x500.jpg' );
		$plugin['icon'] = wphave_admin_path( 'assets/img/wphave-icon.svg' );
		
		return $plugin;		

	}

endif;


/*
 *******************
 * AUTHORIZE WORDPRESS TO DOWNLOAD THE PLUGIN FILE
 *******************
 *
 *	We don't allow directly access to the "wphave update" folder [https://wphave.com/wphave-update/], so we use basic authorization.
 *	! Notice: It's important to send the authorization header, to make the download link available for the WordPress plugin update process.
 *
 *  @type	filter
 *  @date	06/18/19
 *  @since	2.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_auto_update_file_authorization' ) ) :

	function wphave_admin_auto_update_file_authorization( $args, $url ) {

		if( class_exists('wphave') ) {
			// We use the same method in the "wphave" plugin. So if this plugin exists, we don't need this filter here.
			return $args;
		}
		
		// Check if the request url contains the "wphave update" folder
		if( strpos( $url, 'https://wphave.com/wphave-update/' ) !== false ) {

			// This simple authorization data we use to get access to the "wphave update" folder
			$username = 'wphave';		
			$password = 'wp_update';

			// Send the authorization header
			$args['headers'] = array( 
				'Authorization' => 'Basic ' . base64_encode( $username . ':' . $password ) 
			);

		}

		return $args;

	}

endif;

add_filter( 'http_request_args', 'wphave_admin_auto_update_file_authorization', 10, 2 );


/*
 *******************
 * AUTO-UPDATE REMOTE ACCESS TO UPDATE SERVER
 *******************
 *
 *	Function to get the update information from the update server via remote access.
 *
 *  @type	function
 *  @date	06/18/19
 *  @since	2.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/


if ( ! function_exists( 'wphave_admin_update_remote' ) ) :

	function wphave_admin_update_remote( $slug ) {
		
		// Trying to get from cache first
		if( false == $remote = get_transient( 'wphave_update_flag' ) ) {
			
			/* !!!!!
			* Notice: The "https://wphave.com/wphave-update/" directory is proteced by .htpasswd / basic authorization
			* We have to send the correct login credentials to access this directory
			!!!!! */
			
			// This simple authorization data we use to get access to the "wphave update" folder
			$username = 'wphave';		
			$password = 'wp_update';

			// Path to the downloadable plugin file [Includes CURL with basic authorization]
			$file_is_available = wphave_admin_external_file_exists( "https://wphave.com/wphave-update/plugins/{$slug}.zip", array(
				'auth' => true,
				'username' => $username,
				'password' => $password,
			) );

			if( ! $file_is_available ) {
				// Stop here, if no file found
				return false;
			}
			
			// {$slug}.json is the file with the actual plugin information on your server
			$remote = wp_remote_request( "https://wphave.com/wphave-update/update.json", array(
				'timeout' => 10,
				'headers' => array(
					'Authorization' => 'Basic ' . base64_encode( $username . ':' . $password ), // <-- We don't allow directly access to the "wphave update" folder, so we use basic authorization
					'Accept' => 'application/json',
				) )
			);
						
			if( ! is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && ! empty( $remote['body'] ) ) {
				set_transient( 'wphave_update_flag', $remote, 24 * HOUR_IN_SECONDS );
			}			

		}
		
		return $remote;

	}

endif;


/*
 *******************
 * GET PLUGIN INFORMATION
 *******************
 *
 *	Connect to the update server to get information like the latest version about this plugin.
 *
 *  @type	filter
 *  @date	06/18/19
 *  @since	2.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_auto_update_plugin_info' ) ) :

	function wphave_admin_auto_update_plugin_info( $res, $action, $args ) {

		// Do nothing if this is not about getting plugin information
		if( 'plugin_information' !== $action ) {
			return $res;
		}
		
		$plugin = wphave_admin_update_info();
		$slug = $plugin['slug'];
		$name = $plugin['name'];
		//$description = $plugin['description'];
		$installation = $plugin['installation'];
		$changelog = $plugin['changelog'];
		$banner_low = $plugin['banner_low'];
		$banner_high = $plugin['banner_high'];
		$icon = $plugin['icon'];

		// Do nothing if it is not our plugin
		if( $slug !== $args->slug ) {
			return $res;
		}

		// Access the update server
		$remote = wphave_admin_update_remote( $slug );

		// Check we have access to the update JSON file from the wphave update server
		if( $remote ) {

			$remote = json_decode( $remote['body'], true );
			$remote = $remote[$slug];
			$res = new stdClass();
			
			// Fix plugin info parts
			$res->name = $name;
			$res->slug = $slug;			
			$res->author = '<a href="' . WPHAVE_AUTHOR_URL . '">' . WPHAVE_AUTHOR_NAME . '</a>';
			$res->author_profile = WPHAVE_AUTHOR_URL;
			$res->requires_php = WPHAVE_PHP_VERSION;
			$res->sections = array(
				//'description' => $description,
				'installation' => $installation,
				'changelog' => $changelog,
				// You can add your custom sections (tabs) here
			);

			// In case you want the screenshots tab, use the following HTML format for its content:
			// <ol><li><a href="IMG_URL" target="_blank"><img src="IMG_URL" alt="CAPTION" /></a><p>CAPTION</p></li></ol>
			if( ! empty( $remote['sections']['screenshots'] ) ) {
				$res->sections['screenshots'] = $remote['sections']['screenshots'];
			}

			$res->banners = array(
				'low' => $banner_low,
				'high' => $banner_high,
			);
			
			$res->icons = array(
				'svg' => $icon,
			);
			
			// Remote plugin info parts
			$res->version = $remote['version'];
			$res->tested = $remote['tested']; // <-- Tested up to WordPress version
			$res->requires = $remote['requires']; // <-- Required WordPress version
			$res->download_link = $remote['download_url'];
			$res->trunk = $remote['download_url'];
			$res->last_updated = $remote['last_updated'];

		}

		return $res;

	}

endif;

add_filter('plugins_api', 'wphave_admin_auto_update_plugin_info', 20, 3);


/*
 *******************
 * AUTO-UPDATE CHECK PROCESS
 *******************
 *
 *	Function to check if there is a new plugin version available for download.
 *
 *  @type	filter
 *  @date	06/18/19
 *  @since	2.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_push_auto_update_process' ) ) :

	function wphave_admin_push_auto_update_process( $transient ) {

		if( empty( $transient->checked ) ) {
			return $transient;
		}
		
		
		
		$plugin = wphave_admin_update_info();
		$slug = $plugin['slug'];
		$current_version = $plugin['version'];
		$path = $plugin['path'];

		// Access the update server
		$remote = wphave_admin_update_remote( $slug );

		// Check we have access to the update JSON file from the wphave update server
		if( $remote ) {

			$remote = json_decode( $remote['body'], true );
			$remote = $remote[$slug];

			// Compare the current / latest plugin version + the current / required WordPress version
			if( $remote && version_compare( $current_version, $remote['version'], '<' ) && version_compare( get_bloginfo('version'), $remote['requires'], '>=' ) ) {

				$res = new stdClass();
				$res->slug = $slug;
				$res->plugin = $path;
				$res->new_version = $remote['version'];
				$res->tested = $remote['tested'];
				$res->package = $remote['download_url'];
				$transient->response[$res->plugin] = $res;
				//$transient->checked[$res->plugin] = $remote->version;

			}

		}

		return $transient;
		
	}

endif;

add_filter('site_transient_update_plugins', 'wphave_admin_push_auto_update_process', 99 ); // <-- ! Notice: Priority should be higher than the priority of the wphave_admin_disable_plugin_update_notice() update process.
add_filter('transient_update_plugins', 'wphave_admin_push_auto_update_process' );


/*
 *******************
 * CLEAR CACHE AFTER AUTO-UPDATE PROCESS
 *******************
 *
 *	Function to clear the WordPress transient cache after the new plugin version is successfully installed.
 *
 *  @type	filter
 *  @date	06/18/19
 *  @since	2.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_after_auto_update_process' ) ) :

	function wphave_admin_after_auto_update_process( $upgrader_object, $options ) {
		
		if( $options['action'] === 'update' && $options['type'] === 'plugin' ) {
			
			// Clean the cache if a new plugin version is installed
			delete_transient( "wphave_update_flag" );
			
		}
		
	}

endif;

add_action( 'upgrader_process_complete', 'wphave_admin_after_auto_update_process', 10, 2 );


/*
 *******************
 * DISABLE WORDPRESS PLUGIN UPDATE NOTICES
 *******************
 *
 *  In case the official WordPress repo lists a plugin with the same name as the assigned plugin. 
 *	This filter prevents false update notices about another plugin from being displayed and thus falsely overwriting the plugin.
 *
 *  @type	filter
 *  @date	06/18/19
 *  @since	2.0
 *
 *  @param	N/A
 *  @return	N/A
 *
*/

if ( ! function_exists( 'wphave_admin_disable_plugin_update_notice' ) ) :

	function wphave_admin_disable_plugin_update_notice( $value ) { 

		// Disable the update notice for the following theme assigned plugins
		$pluginsToDisable = array(
			'wphave-admin/wphave-admin.php',
		);
		
		if( isset( $value ) && is_object( $value ) ) {
			foreach( $pluginsToDisable as $plugin ) {
				if( isset( $value->response[$plugin] ) ) {
					unset( $value->response[$plugin] );
				}
			}
		}
		
		return $value;

	}

endif;

add_filter( 'site_transient_update_plugins', 'wphave_admin_disable_plugin_update_notice', 12 ); // <-- ! Notice: Priority should be less than the priority of the wphave_admin_push_auto_update_process() update process.