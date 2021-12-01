<?php
get_header();
?>

<style>
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        margin-top: 15px;
        margin-bottom: 15px;
    }

    article {
        margin-bottom: 15px;
    }
</style>

<!-- main header -->
<?php
get_template_part('theme-parts/theme', 'menu');
?>
<!-- main-header end -->

<section class="sidebar-page-container sec-pad-2 blog-details" style="background-image: url(<?php bloginfo('url'); ?>/wp-content/themes/creamberry/assets/images/background/2.png);">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                <?php
                while (have_posts()) :
                    the_post();
                ?>
                    <article class="content-side" id="post-<?php the_ID(); ?>" style=" border: 1px solid #dfdbd3; padding: 30px;    background: #FFF; ">
                        <div class="blog-details-content">
                            <div class="inner-box">
                                <div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#">
                                    <div class="root" typeof="v:Breadcrumb">
                                        <a href="<?php bloginfo('url'); ?>" rel="v:url" property="v:title">
                                            <i class="fa fa-home">
                                            </i>
                                            <?php
                                            bloginfo('name');
                                            ?>
                                        </a>
                                    </div>
                                    <?php foreach (get_the_category() as $category) :
                                        if ($category->name != 'Sem categoria') :
                                    ?>

                                            <div class="icon-font">
                                                &nbsp;/&nbsp;
                                            </div>
                                            <div typeof="v:Breadcrumb">
                                                <a href="<?php echo get_category_link($category->cat_ID); ?>" rel="v:url" property="v:title">
                                                    <?php echo $category->name; ?>
                                                </a>
                                            </div>
                                    <?php
                                        endif;
                                    endforeach; ?>
                                    <div>
                                        &nbsp;/&nbsp;
                                    </div>
                                    <div>
                                        <span><?php echo get_the_title(); ?></span>
                                    </div>
                                </div>
                                <div>
                                    <address style="display:inline;" class="author"><?php echo __('Por', 'encontreseusite'); ?>
                                        <a rel="author" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author_meta('display_name'); ?></a>
                                    </address>
                                    <span style="display:inline;"><?php echo __('em', 'encontreseusite'); ?></span> <time style="display:inline;" pubdate datetime="<?php echo get_the_date('c'); ?>" title="<?php echo get_the_date(); ?>" itemprop="datePublished"><?php echo get_the_date(); ?></time>
                                </div>
                                <header>
                                    <h1><a href="<?php the_permalink(); ?>" rel="<?php the_title(); ?>"><?php echo get_the_title(); ?></a></h1>
                                </header>
                                <br>
                                <?php
                                if (has_post_thumbnail()) :

                                    the_post_thumbnail('large');

                                endif;
                                ?>
                                <br>
                                <?php
                                the_excerpt();
                                ?>
                            </div>
                        </div>
                    </article>
                <?php
                endwhile;
                wp_reset_postdata();

                ?>
            </div>
            <?php
            get_template_part('theme-parts/theme', 'sidebar');
            ?>
        </div>
    </div>
</section>


</div><!-- #primary -->

<?php


get_footer();
