<?php
get_header();
?>

<!-- main header -->
<?php 
get_template_part('theme-parts/theme','menu');
?>
<!-- main-header end -->

<section class="vs-cta-wrapper vs-cta-layout1 space-top">
    <div class="container">
        <hr />
        <div class="row">
            <div class="col-md-12">
                <?php

                $unidades = get_posts(array(
                    'post_type' => 'soaresshow',
                    'tax_query' => array(
                        array(
                            'taxonomy' => get_queried_object()->taxonomy,
                            'field'    => 'term_id',
                            'terms'    => get_queried_object()->term_id
                        )
                    )

                ));

                echo empty($unidades) ? "<p class='sec-text-style1 mb-0'>Nenhuma unidade encontrada</p>" : "";

                foreach ($unidades as $i => $unidade) :

                ?>

                    <div class="col-lg-3 borderRadius">
                        <div class="vs-service">
                            <div class="service-icon">
                                <a href="<?php echo get_the_permalink($unidade->ID); ?>" rel="<?php echo  $unidade->post_title; ?>">
                                    <img src="<?php echo get_the_post_thumbnail_url($unidade->ID); ?>" alt="<?php echo  $unidade->post_title; ?>" />
                                </a>
                            </div>
                            <div class="service-content">
                                <h3 class="service-title h4">
                                    Unidade
                                    <a href="<?php echo get_the_permalink($unidade->ID); ?>" rel="<?php echo  $unidade->post_title; ?>"><?php echo  $unidade->post_title; ?></a>
                                </h3>
                                <p><?php echo $unidade->post_excerpt; ?></p>
                            </div>
                        </div>
                    </div>

                <?php
                endforeach;
                unset($unidades);
                ?>
            </div>
        </div>
    </div>
</section>

<!-- main-footer -->
<?php
get_footer();
