<?php
get_header();
?>

<!-- main header -->
<?php
get_template_part('theme-parts/theme', 'menu');
?>
<!-- main-header end -->

<section class="news-section sec-pad pulltop-mobile" style="margin-top:100px;background-image: url(<?php bloginfo('url'); ?>/wp-content/themes/creamberry/assets/images/background/2.png);">
    <div class="auto-container">
        <div class="sec-title centred">
            <p><?php echo __('CreamBerry', 'encontreseusite');  ?></p>
            <h2><?php echo __('Nossos produtos', 'encontreseusite');  ?></h2>
            <?php
            $posts = get_terms(
                array(
                    'taxonomy' => 'soares_show_servicos',
                    'hide_empty' => false,
                    'parent' => 0
                )
            );
            ?>
        </div>
        <div class="row clearfix">

            <?php
            if (!empty($posts)) :
                foreach ($posts as $post) :
            ?>
                    <article class="col-lg-4 col-md-6 col-sm-12 news-block" style="margin:-6px;">
                        <div class="news-block-one wow fadeInUp animated animated">
                            <div class="inner-box" style="background:#f8f1e4;height:200px;margin-bottom:30px;">
                                <div class="lower-content">
                                    <?php 
                                    //$img = get_field('imagem_produto', 'soares_show_servicos_'.$post->term_id);
                                    if(!empty($img)):
                                    ?>
                                    <figure>
                                        <img src="<?php echo $img; ?>" />
                                    </figure>
                                    <?php 
                                    endif;
                                    ?>
                                    <h3>
                                        <?php echo $post->name; ?>
                                    </h3>
                                    <p><?php echo $post->description; ?>
                                    </p>
                                </div>
                                <figure class="image-box">
                                    <a href="<?php bloginfo('url'); ?>/franquias" rel="<?php echo $post->name; ?>">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo $post->name; ?>" />
                                        <?php endif; ?>
                                    </a>
                                </figure>
                            </div>
                        </div>
                    </article>
            <?php
                endforeach;
            endif;
            ?>
        </div>
        <?php
        ?>


    </div>
</section>

<!-- news-section -->
<section class="news-section sec-pad" style="background-image: url(<?php bloginfo('url'); ?>/wp-content/themes/creamberry/assets/images/background/1.png);">
    <div class="auto-container">
        <div class="sec-title centred">
            <p><?php echo __('Tudo sobre açaí', 'encontreseusite');  ?></p>
            <h2><?php echo __('Nosso blog de receitas', 'encontreseusite');  ?> <br> <?php echo __('sugestões e notícias', 'encontreseusite');  ?></h2>
        </div>
        <div class="row clearfix">

            <?php
            $posts = get_posts(array(
                'post_type' => 'post',
                'numberposts' => 3,
                'order' => 'DESC',
                'orderby' => 'date',
                'post_status' => 'publish'
            ));
            if ($posts) :
                foreach ($posts as $post) :
                    setup_postdata($post);
            ?>

                    <article class="col-lg-4 col-md-6 col-sm-12 news-block">
                        <div class="news-block-one wow fadeInUp animated animated">
                            <div class="inner-box">
                                <figure class="image-box">
                                    <a href="<?php the_permalink(); ?>" rel="<?php the_title(); ?>">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" />
                                        <?php endif; ?>
                                    </a>
                                </figure>
                                <div class="lower-content">
                                    <ul class="post-info clearfix">
                                        <li><?php the_date(); ?></li>
                                    </ul>
                                    <h3>
                                        <a href="<?php the_permalink(); ?>" rel="<?php the_title(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <p><?php the_excerpt(); ?>
                                    </p>
                                    <div class="btn-box">
                                        <a href="<?php the_permalink(); ?>" rel="<?php the_title(); ?>" class="theme-btn-two"><?php echo __('Ver receita', 'encontreseusite') ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>

            <?php
                endforeach;
                wp_reset_postdata();
            endif;
            ?>
        </div>
        <?php
        ?>


    </div>
</section>
<!-- news-section end -->


<?php
get_template_part('theme-parts/theme', 'contact');
?>


<!-- main-footer -->
<?php
get_footer();
