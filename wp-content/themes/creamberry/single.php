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
</style>

<!-- main header -->
<?php
get_template_part('theme-parts/theme', 'menu');
?>
<!-- main-header end -->

<section class="sidebar-page-container sec-pad-2 blog-details" style="background-image: url(<?php bloginfo('url'); ?>/wp-content/themes/creamberry/assets/images/background/2.png);">
    <div class="auto-container">
        <div class="row clearfix">
            <?php
            while (have_posts()) :
                the_post();
            ?>
                <article class="col-lg-8 col-md-12 col-sm-12 content-side" id="post-<?php the_ID(); ?>" style=" border: 1px solid #dfdbd3; padding: 30px;    background: #FFF; ">
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
                                <address style="display:inline;" class="author"><?php echo __('Por','encontreseusite'); ?>
                                    <a rel="author" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author_meta('display_name'); ?></a>
                                </address>
                                <span style="display:inline;"><?php echo __('em','encontreseusite'); ?></span> <time style="display:inline;" pubdate datetime="<?php echo get_the_date('c'); ?>" title="<?php echo get_the_date(); ?>" itemprop="datePublished"><?php echo get_the_date(); ?></time>
                            </div>
                            <header>
                                <h1><?php echo get_the_title(); ?></h1>
                            </header>
                            <br>
                            <?php
                            if (has_post_thumbnail()) :

                                the_post_thumbnail('large');

                            endif;
                            ?>
                            <br>
                            <?php
                            the_content();
                            ?>
                        </div>
                        <div class="post-share-option clearfix">
                            <div class="text pull-left">
                                <h3><?php echo __("Compartilhe no facebook:", "encontreseusite"); ?></h3>
                            </div>
                            <ul class="social-links pull-right clearfix">
                                <li>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink(); ?>">
                                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 167.657 167.657" style="enable-background:new 0 0 167.657 167.657;" xml:space="preserve">
                                            <g>
                                                <path style="fill:#010002;" d="M83.829,0.349C37.532,0.349,0,37.881,0,84.178c0,41.523,30.222,75.911,69.848,82.57v-65.081H49.626
		v-23.42h20.222V60.978c0-20.037,12.238-30.956,30.115-30.956c8.562,0,15.92,0.638,18.056,0.919v20.944l-12.399,0.006
		c-9.72,0-11.594,4.618-11.594,11.397v14.947h23.193l-3.025,23.42H94.026v65.653c41.476-5.048,73.631-40.312,73.631-83.154
		C167.657,37.881,130.125,0.349,83.829,0.349z" />
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                        </svg>

                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </article>
            <?php
            endwhile;
            wp_reset_postdata();
            get_template_part('theme-parts/theme', 'sidebar');

            ?>


        </div>
    </div>
</section>


</div><!-- #primary -->

<?php


get_footer();
