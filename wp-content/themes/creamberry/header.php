<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head itemtype="https://schema.org/WebSite">

    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <?php
    if (is_front_page()) :
        $option = get_option('soares_meta_socials');
        $option = !empty($option) ? unserialize($option) : array();
    ?>
        <meta name="description" content="<?php echo isset($option['meta_description']) ? $option['meta_description'] : ""; ?>" />
        <meta property="og:url" content="<?php echo bloginfo('url') ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="<?php echo bloginfo('name'); ?>" />
        <meta property="og:description" content="<?php echo isset($option['meta_description']) ? $option['meta_description'] : ""; ?>" />
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:site" content="<?php echo bloginfo('url') ?>" />
        <meta name="twitter:creator" content="<?php echo bloginfo('url') ?>" />
        <?php
        $custom_logo_id = get_theme_mod('custom_logo');
        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
        if (has_custom_logo()) :
        ?>
            <meta property="og:image" content="<?php echo esc_url($logo[0]); ?>" />
        <?php
        endif;
        ?>
    <?php
    endif;
    ?>
    <title>
        <?php
        if (is_single() or is_page()) :
            echo the_title();
        elseif (is_tax() or is_category() or is_tag()) :
            echo "CreamBerry " . get_queried_object()->name;
        elseif (is_front_page()) :
            echo bloginfo('name');
        endif;
        ?>
    </title>

    <!-- Fav Icon -->
    <link rel="icon" href="./assets/images/icons/favicon.gif" type="image/x-icon">

    <style>
        .main-header.style-one .header-lower {
            background: #3f1e4c;
        }
    </style>
    <?php wp_head(); ?>
</head>


<!-- page wrapper -->

<body itemtype="https://schema.org/WebPage" <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div class="boxed_wrapper">
