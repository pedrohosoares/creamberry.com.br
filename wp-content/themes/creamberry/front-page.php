<?php
get_header();
?>

<!-- main header -->
<?php
get_template_part('theme-parts/theme', 'menu');
?>
<!-- main-header end -->

<?php
$html = get_option('soares_editable');
echo stripslashes($html);
?>
<script>
    let soares_transictions = {

        all: document.querySelectorAll('div.testimonial-block-one'),
        change() {
            let int = this.all.length;
            let number = 0;
            setInterval(() => {
                if (number == int) {
                    number = 0;
                }
                if (number != 0) {
                    soares_transictions.all[(number - 1)].style.display = "none";
                }
                soares_transictions.all[number].style.display = "block";
                number++
                
            }, 6000);

        },
        init() {
            this.change();
        }

    }
    soares_transictions.init();
</script>
<!-- news-section -->
<section class="news-section sec-pad" style="background-image: url(<?php bloginfo('url'); ?>/wp-content/themes/creamberry/assets/images/background/news-bg-1.jpg);">
    <div class="auto-container">
        <div class="sec-title centred">
            <p>Tudo sobre açaí</p>
            <h2>Nosso blog de receitas, sugestões e notícias</h2>
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
                                        <a href="<?php the_permalink(); ?>" rel="<?php the_title(); ?>" class="theme-btn-two"><?php echo __('Ler matéria', 'encontreseusite') ?></a>
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
