<?php
get_header();
?>



<!-- main header -->
<?php
get_template_part('theme-parts/theme', 'menu');
?>
<!-- main-header end -->

<section class="sidebar-page-container sec-pad-2 blog-details">
    <div class="auto-container">
        <div class="row clearfix">
            <?php
            while (have_posts()) :
                the_post();
            ?>
                <article class="col-lg-12 col-md-12 col-sm-12 content-side" id="post-<?php the_ID(); ?>" style=" border: 1px solid #dfdbd3; padding: 10px; ">
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
                                            /
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
                                    /
                                </div>
                                <div>
                                    <span><?php echo get_the_title(); ?></span>
                                </div>
                            </div>
                            <header>
                                <h1><?php echo get_the_title(); ?></h1>
                            </header>
                            <br>
                            <?php
                            the_content();
                            ?>
                        </div>
                        <div class="post-share-option clearfix">
                            <div class="text pull-left">
                                <h3>Compartilhe nas suas redes:</h3>
                            </div>
                            <ul class="social-links pull-right clearfix">
                                <li>
                                    <a href="blog-details.html">
                                        <i class="fab fa-facebook-f">
                                        </i>
                                    </a>
                                </li>
                                <li>
                                    <a href="blog-details.html">
                                        <i class="fab fa-twitter">
                                        </i>
                                    </a>
                                </li>
                                <li>
                                    <a href="blog-details.html">
                                        <i class="fab fa-google-plus-g">
                                        </i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </article>
            <?php
            endwhile;
            wp_reset_postdata();

            ?>


        </div>
    </div>
</section>


</div><!-- #primary -->

<?php


get_footer();
