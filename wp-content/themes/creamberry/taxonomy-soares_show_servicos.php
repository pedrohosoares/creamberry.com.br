<?php
get_header();
?>

<!-- main header -->
<?php 
get_template_part('theme-parts/theme','menu');
?>
<!-- main-header end -->


<section class="vs-service-wrapper vs-service-layout1 space-top space-bottom bg-light-theme">
    <div class="container">
        <div class="row">
            <?php
            $terms = get_terms(
                get_queried_object()->taxonomy,
                array(
                    'parent' => get_queried_object()->term_id,
                    'orderby' => 'slug',
                    'hide_empty' => false
                )
            );
            foreach ($terms as $i => $value) :
            ?>

                <div class="col-lg-3">
                    <div class="vs-service">
                        <div class="service-icon">
                            <span class="icon text-theme bg-white">
                                <a rel="<?php echo $value->name; ?>" href="<?php echo get_term_link($value, get_queried_object()->taxonomy); ?>">
                                    <img src="<?php echo get_field('imagem', 'soares_show_servicos_' . $value->term_id); ?>" />
                                </a>
                            </span>
                            <span class=" bg-icon ani-moving icon-6x text-theme">
                                <img src="<?php echo get_field('imagem', 'soares_show_servicos_' . $value->term_id); ?>" />
                            </span>
                        </div>
                        <article class=" service-content">
                            <h3 class="service-title h4">
                                <a rel="<?php echo $value->name; ?>" href="<?php echo get_term_link($value, get_queried_object()->taxonomy); ?>"><?php echo $value->name; ?></a>
                            </h3>
                            <p>
                                <?php echo $value->description; ?>
                            </p>
                        </article>
                    </div>
                </div>

            <?php

            endforeach;
            unset($terms);
            ?>
        </div>
    </div>
</section>

<section class="vs-cta-wrapper vs-cta-layout1 space-top">
    <div class="container">
        <div class="row justify-content-center my-lg-0 my-30">
            <div class="col-xl-8">
                <div class="cta-content text-center link-inherit">

                    <p class="text-md">Unidades que contém os serviços</p>
                    <h2 class="sec-title-style1 mb-3 mb-lg-4">Unidades da Suav</h2>

                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <form method="POST">
                    <div class="col-md-12">
                        <label>Estado</label>
                        <select name="suav_state" class="form-control" id="suav_state">
                            <option value="">MG</option>
                        </select>
                    </div>
                </form>
            </div>
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

    </div>
</section>

<!-- main-footer -->
<?php
get_footer();
