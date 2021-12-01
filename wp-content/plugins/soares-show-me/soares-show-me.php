<?php

/**
 * Plugin Name:       Soares show me
 * Plugin URI:        mailto:pedrohosoares@gmail.com
 * Description:       Organize profiles, enterprise, franchise, unities and service
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Pedro Soares
 * Author URI:        https://br.linkedin.com/in/pedro-soares-27657756
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       soares-show-me
 * Domain Path:       /languages
 */


if (!function_exists('soares_show_me_menu')) :

    function soares_show_me_menu()
    {

        $labels = array(
            'name'                  => _x('Soares Show', 'Post type general name', 'textdomain'),
            'singular_name'         => _x('Soares Show', 'Post type singular name', 'textdomain'),
            'menu_name'             => _x('Soares Shows', 'Admin Menu text', 'textdomain'),
            'name_admin_bar'        => _x('Soares Show', 'Add New on Toolbar', 'textdomain'),
            'add_new'               => __('Add New', 'textdomain'),
            'add_new_item'          => __('Add New Soares Show', 'textdomain'),
            'new_item'              => __('New Soares Show', 'textdomain'),
            'edit_item'             => __('Edit Soares Show', 'textdomain'),
            'view_item'             => __('View Soares Show', 'textdomain'),
            'all_items'             => __('All Soares Shows', 'textdomain'),
            'search_items'          => __('Search Soares Shows', 'textdomain'),
            'parent_item_colon'     => __('Parent Soares Shows:', 'textdomain'),
            'not_found'             => __('No Soares Shows found.', 'textdomain'),
            'not_found_in_trash'    => __('No Soares Shows found in Trash.', 'textdomain'),
            'featured_image'        => _x('Soares Show Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain'),
            'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain'),
            'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain'),
            'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain'),
            'archives'              => _x('Soares Show archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain'),
            'insert_into_item'      => _x('Insert into Soares Show', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain'),
            'uploaded_to_this_item' => _x('Uploaded to this Soares Show', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain'),
            'filter_items_list'     => _x('Filter Soares Shows list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain'),
            'items_list_navigation' => _x('Soares Shows list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain'),
            'items_list'            => _x('Soares Shows list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain'),
        );

        $args = array(

            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'franquia'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'show_in_rest'       => true,
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),

        );

        register_post_type('Soares Show', $args);


        register_taxonomy(
            'soares_show_tipos',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
            'soaresshow',             // post type name
            array(
                'hierarchical' => true,
                'label' => 'Tipos', // display name
                'query_var' => true,
                'rewrite' => array(
                    'slug' => 'tipos',    // This controls the base slug that will display before each term
                    'with_front' => true  // Don't display the category base before
                ),
                'show_in_rest' => true
            )
        );

        register_taxonomy(
            'soares_show_servicos',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
            'soaresshow',             // post type name
            array(
                'hierarchical' => true,
                'label' => 'Produtos', // display name
                'query_var' => true,
                'rewrite' => array(
                    'slug' => 'produtos',    // This controls the base slug that will display before each term
                    'with_front' => true  // Don't display the category base before
                ),
                'show_in_rest' => true
            )
        );

        register_taxonomy(
            'soares_show_localizacao',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
            'soaresshow',             // post type name
            array(
                'hierarchical' => true,
                'label' => 'Localização', // display name
                'query_var' => true,
                'rewrite' => array(
                    'slug' => 'localizacao',    // This controls the base slug that will display before each term
                    'with_front' => true  // Don't display the category base before
                ),
                'show_in_rest' => true
            )
        );
    }



endif;

add_action('init', 'soares_show_me_menu');

if (!function_exists('soares_add_metabox')) :
    function soares_add_metabox()
    {

        add_meta_box('telefone_soares', 'Telefone / WhatsApp', 'telefone_soares', 'soaresshow', 'side');
        add_meta_box('numero_soares', 'Número', 'numero_soares', 'soaresshow', 'side');
        add_meta_box('email_soares', 'E-mail', 'email_soares', 'soaresshow', 'side');
        add_meta_box('hour_open_soares', 'Horário de abertura', 'hour_open_soares', 'soaresshow', 'side');
    }
endif;
add_action('add_meta_boxes', 'soares_add_metabox');

if (!function_exists('telefone_soares')) :
    function telefone_soares($post)
    {

        ob_start();
        $telefone_soares = get_post_meta($post->ID, 'telefone_soares');
?>
        <input type="text" value="<?php echo isset($telefone_soares[0]) ? $telefone_soares[0] : ""; ?>" name="telefone_soares" id="telefone_soares" />
    <?php
        echo ob_get_clean();
    }
endif;

if (!function_exists('numero_soares')) :
    function numero_soares($post)
    {

        ob_start();
        $numero_soares = get_post_meta($post->ID, 'numero_soares');
    ?>
        <input type="text" value="<?php echo isset($numero_soares[0]) ? $numero_soares[0] : ""; ?>" name="numero_soares" id="numero_soares" />
    <?php
        echo ob_get_clean();
    }
endif;

if (!function_exists('email_soares')) :
    function email_soares($post)
    {
        ob_start();
        $email_soares = get_post_meta($post->ID, 'email_soares');
    ?>
        <input type="text" value="<?php echo isset($email_soares[0]) ? $email_soares[0] : ""; ?>" name="email_soares" id="email_soares" />
    <?php
        echo ob_get_clean();
    }
endif;

if (!function_exists('hour_open_soares')) :
    function hour_open_soares($post)
    {
        ob_start();
        $hour_open_soares = get_post_meta($post->ID, 'hour_open_soares');
    ?>
        <input type="text" value="<?php echo isset($hour_open_soares[0]) ? $hour_open_soares[0] : ""; ?>" name="hour_open_soares" id="hour_open_soares" />
        <?php
        echo ob_get_clean();
    }
endif;

if (!function_exists('soares_fields_show_me')) :
    function soares_fields_show_me($post_id)
    {
        if (isset($_POST['telefone_soares'])) :
            update_post_meta($post_id, 'telefone_soares', $_POST['telefone_soares']);
        endif;
        if (isset($_POST['numero_soares'])) :
            update_post_meta($post_id, 'numero_soares', $_POST['numero_soares']);
        endif;
        if (isset($_POST['email_soares'])) :
            update_post_meta($post_id, 'email_soares', $_POST['email_soares']);
        endif;
        if (isset($_POST['hour_open_soares'])) :
            update_post_meta($post_id, 'hour_open_soares', $_POST['hour_open_soares']);
        endif;
        return $post_id;
    }
endif;
add_action('save_post', 'soares_fields_show_me');

if (!function_exists('soares_show_services')) :

    function soares_show_services()
    {

        $get_services = get_terms(array(
            'post_type' => 'soaresshow',
            'taxonomy' => 'soares_show_servicos'
        ));
        ob_start();
        foreach ($get_services as $index => $service) :


        ?>

            <div class="col-lg-3" style="background:#FEF5F3;">
                <div class="vs-service">
                    <div class="service-icon">
                        <span class="icon text-theme bg-white">
                            <a rel="<?php echo 'Produto CreamBerry ' . $service->name; ?>" href="<?php echo get_term_link($service, 'soares_show_servicos'); ?>">
                                <img style="width: 100px;" src="<?php echo get_field('imagem', 'soares_show_servicos_' . $service->term_id); ?>" alt="<?php echo 'Produto CreamBerry ' . $service->name; ?>" />
                            </a>
                        </span>
                    </div>
                    <div class="service-content">
                        <h3 class="service-title h4">
                            <a href="<?php echo get_term_link($service, 'soares_show_servicos'); ?>" rel="<?php echo 'Produto CreamBerry ' . $service->name; ?>"><?php echo $service->name; ?></a>
                        </h3>
                        <p><?php echo $service->description; ?></p>
                    </div>
                </div>
            </div>

<?php

        endforeach;
        echo ob_get_clean();
        unset($get_services);
    }

endif;

if (!function_exists('soares_show_services_shortcode')) {
    function soares_show_services_shortcode()
    {

        add_shortcode('soares_show_services', 'soares_show_services');
    }
}
add_action('init', 'soares_show_services_shortcode');
