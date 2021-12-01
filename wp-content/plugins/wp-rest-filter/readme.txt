=== WP REST Filter ===
Contributors: jack50n9, sk8tech
Donate link: https://sk8.tech/donate?utm_source=plugin&utm_medium=forum&utm_campaign=wp-rest-filter
Tags: wp, rest, api, rest api, filter, acf, cpt, json, taxonomy, meta
Requires at least: 4.7.0
Tested up to: 5.1
Requires PHP: 5.2.4
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 
WP REST Filter restores the `filter` argument for any post endpoint on WordPress websites, since its removal in WordPress 4.7.
 
== Description ==
 
The `filter` argument in WP REST API allows the posts to be filtered using `WP_Query` public query vars. 

Since WordPress 4.7 the `filter` argument for any post endpoint was removed. 

This plugin restores the `filter` parameter for websites that were previously using it.

= Usage =

Use the `filter` parameter on any Post, or Custom Post Type endpoint such as `/wp/v2/posts` or `/wp/v2/cpt` as an array of `WP_Query`
argument. ACF values are also supported. 

== Default Post Type ==

`
fetch( 'https://domain.com/wp-json/wp/v2/posts?filter[meta_key]=acfkey&filter[meta_value]=acfvalue');
`

== Filter Users ==

`
fetch( 'https://domain.com/wp-json/wp/v2/users?filter[meta_key]=acfkey&filter[meta_value]=acfvalue');
`

== Custom Post Type ==

`
fetch( 'https://domain.com/wp-json/wp/v2/cars?filter[meta_key]=currency&filter[meta_value]=AUD'); // here 'cars' is the endpoint for CPT
`

== Advanced Custom Field ==

`
fetch( 'https://domain.com/wp-json/wp/v2/cars?filter[meta_key]=price&filter[meta_compare]=<&filter[meta_value]=200000'); // Query for car 'less' than '200000' in 'price'
`

== Advanced Custom Field - By Date (before, equal & after) ==

`
fetch( 'https://domain.com/wp-json/wp/v2/cars?filter[meta_key]=expiry_date&filter[meta_value]=2018-12-27T23:59:59&filter[meta_compare]=< // 'Expiry' Before '2018 Boxing Day ends'
`

== Advanced Custom Field - Value in Array (Single Value) ==

`
fetch( 'https://domain.com/wp-json/wp/v2/cars?filter[meta_key]=features&filter[meta_compare]=LIKE&filter[meta_value]=electric
`

== Advanced Custom Field - Search ==

`
fetch( 'https://domain.com/wp-json/wp/v2/cars?filter[meta_key]=brands&filter[meta_compare]=LIKE&filter[meta_value]=tesla
`

== Multiple Meta Queries ==

`
fetch( 'https://domain.com/wp-json/wp/v2/cars?filter[meta_query][0][key]=currency&filter[meta_query][0][value]&filter[meta_query][1][key]=country&filter[meta_query][1][value]=Australia'); // here 'cars' is the endpoint for CPT
`

= Technical Support =

**SK8Tech - Customer Success Specialist** offers **Technical Support** to configure or install ***WP REST Filter***.

= Our Services =
 * [SK8Tech Sydney Web Design](https://sk8.tech/web-design/?utm_source=plugin&utm_medium=forum&utm_campaign=wp-rest-filter)
 * [SK8Tech Enterprise Email Hosting](https://sk8.tech/services/enterprise/email-hosting/?utm_source=plugin&utm_medium=forum&utm_campaign=wp-rest-filter)
 * [SK8Tech Emergency IT Support](https://sk8.tech/services/enterprise/it-support/emergency-support/?utm_source=plugin&utm_medium=forum&utm_campaign=wp-rest-filter)
 * [SK8Tech WeChat Advertising](https://sk8.tech/services/wechat/?utm_source=plugin&utm_medium=forum&utm_campaign=wp-rest-filter)
 
== Installation ==
  
1. Upload `wp-rest-filter` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
 
== Frequently Asked Questions ==
 
= Why do I need WP REST Filter? =
 
If you're planning on using your WordPress website as a Backend, and you're consuming RESTful api, you'll most probably need to filter results on your GET request. This is precisely what this plugin does.

= Can I filter for multiple meta queries? =

YES! See Description.

= Can I Use this plugin to find posts by tags/categories? =

Yes, however this is natively supported by WordPress 4.7+. This plugin is not necessary if you¡¯re looking to find posts by tags/categories.

For more info, please [see this topic](https://wordpress.org/support/topic/empty-response-2/).
 
= Does this work with Custom Post Type? =
 
Yes! This plugin is designed to work with CPT types too!
 
= Does this work with Taxonomy? =
 
Yes! This plugin filters Taxonomy as well. Thanks to [pull request by bplaa-yai](https://github.com/SK8-PTY-LTD/wp-rest-filter/pull/2).
 
= Does this work with Advanced Custom Field? =
 
Yes! This plugin is designed to work with ACF values too!

= I've received a 403 page upon activation = 

This is likely due to [AJAX is disabled on your wp-admin/plugins.php](https://css-javascript-toolbox.com/ticket/bulletproof-security-ajax-issue-and-resolution/) page. If you are using BulletProof Security Plugin, here's how to fix it.

Go to htaccess Core -> Custom Code -> wp-admin htaccess File Custom Code , paste the following code to '3. CUSTOM CODE WPADMIN PLUGIN/FILE SKIP RULES' section.

`
# post.php skip/bypass rule
RewriteCond %{REQUEST_URI} (post\.php) [NC]
RewriteRule . - [S=2]
# plugins.php skip/bypass rule
RewriteCond %{REQUEST_URI} (plugins\.php) [NC]
RewriteRule . - [S=2]
`

Click 'Save wp-admin Custom Code', then go to htaccess Core -> Security Modes, click 'Activate' under 'wp-admin Folder BulletProof Mode (WBM)'

Now you should be able to activate plugin without any issue.
 
= There's a bug, what do I do? =

Please email us at wp-rest-filter@sk8.tech. 
 
== Screenshots ==
 
1. An sample REST API GET request using [WP REST Filter](https://wordpress.org/plugins/wp-rest-filter/).
 
== Changelog ==

= 1.4.3 = 

* Security Fix.
* Safe to Update.

= 1.4.2 = 

* Added Features: Search & Filter Array value.

= 1.3.0 = 

* Added Filter support for 'User' type.

= 1.2.4 =

* Fixed another critical issue relating to custom post type

= 1.2.2 (breaking) =

* Fixed a critical issue relating to custom post type

= 1.2.0 (Breaking) =

* Added support for filtering by Taxonomy
* Restructured Project for further development

= 1.1.4 =

* Added support for filtering by custom filed date

= 1.1.2 =

* Added support for Multiple Meta Queries
 
= 1.0.3 =
* Minor README fixes.
 
= 1.0.2 =
* Minor README fixes.
 
= 1.0.1 =
* Minor README fixes.
 
= 1.0.0 =
* Initial Release.

== Upgrade Notice ==

Nothing to worry! Install away!
 
== Contact Us ==

Based in Sydney, [SK8Tech](https://sk8.tech?utm_source=plugin&utm_medium=forum&utm_campaign=wp-rest-filter) is a innovative company providing IT services to SMEs, including [Web Design](https://sk8.tech/web-design?utm_source=plugin&utm_medium=forum&utm_campaign=wp-rest-filter), App Development and more.