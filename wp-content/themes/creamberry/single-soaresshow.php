<?php
get_header();
?>

<!-- main header -->
<?php
get_template_part('theme-parts/theme', 'menu');

ob_start();
?>
<!-- main-header end -->

<!-- banner-section -->

<section class="shop-section vs-cta-wrapper vs-cta-layout1 space-top" style="background-image: url(<?php bloginfo('url'); ?>/wp-content/themes/creamberry/assets/images/background/1.png);">
    <div class="container">
        <div class="row" style=" padding-top: 100px; ">
            <article class="col-xl-8 row" style="border:1px solid #dfdbd3;padding:25px;background:#FFF;">
                <div style="width:100%;max-height:55px;" class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#">
                    <div class="root" typeof="v:Breadcrumb">
                        <a href="<?php bloginfo('url'); ?>" rel="v:url" property="v:title">
                            <i class="fa fa-home"></i>
                            <?php
                            bloginfo('name');
                            ?>
                        </a>
                    </div>
                    <div> / </div>
                    <div>
                        <a href="<?php bloginfo('url'); ?>/franquias" rel="v:url" property="v:title">
                            <i class="fa fa-home"></i>
                            <?php echo __('Franquias', 'encontreseusite'); ?>
                        </a>
                    </div>
                    <div> / </div>
                    <div>
                        <?php the_title(); ?>
                    </div>
                </div>

                <header style=" display: block; width: 100%; ">
                    <h1><?php the_title(); ?></h1>
                </header>
                <br />
                <?php
                if (have_posts()) :

                    while (have_posts()) :
                        the_post();
                        the_content();

                    endwhile;
                    wp_reset_postdata();

                endif;
                $terms = get_the_terms(get_the_ID(), 'soares_show_servicos');
                if (!empty($terms)) :
                ?>
                    <h2 style=" margin-top: 15px; "><?php echo __('Produtos vendidos na unidade', 'encontreseusite'); ?> <?php the_title(); ?></h2>
                    <?php
                    foreach ($terms as $i => $value) :
                    ?>

                        <section class="col-lg-4 text-center">
                            <h3 class="service-title h4"><?php echo $value->name; ?>
                            </h3>
                        </section>

                    <?php

                    endforeach;
                    ?>
                <?php
                endif;
                unset($terms);

                ?>
            </article>
            <div class="col-xl-4 sliderBar">
                <aside class="theiaStickySidebar">
                    <div class="blog-sidebar default-sidebar">
                        <section class="widget widget_search sidebar-widget">
                            <?php
                            $data = get_post_meta(get_the_ID(), 'telefone_soares');
                            if (isset($data[0]) and !empty($data[0])) :
                            ?>
                                <p class="text-md">
                                    <a style=" font-size: 20px; " href="<?php echo isset($data[0]) ? "https://api.whatsapp.com/send/?phone=" . $data[0] . "&text=Olá, quero fazer um pedido." : "" ?>" class="whatsApp icon-btn mr-2 bg-theme">
                                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="width: 36px;" xml:space="preserve">
                                            <path style="fill:#4CAF50;" d="M256.064,0h-0.128l0,0C114.784,0,0,114.816,0,256c0,56,18.048,107.904,48.736,150.048l-31.904,95.104
	l98.4-31.456C155.712,496.512,204,512,256.064,512C397.216,512,512,397.152,512,256S397.216,0,256.064,0z" />
                                            <path style="fill:#FAFAFA;" d="M405.024,361.504c-6.176,17.44-30.688,31.904-50.24,36.128c-13.376,2.848-30.848,5.12-89.664-19.264
	C189.888,347.2,141.44,270.752,137.664,265.792c-3.616-4.96-30.4-40.48-30.4-77.216s18.656-54.624,26.176-62.304
	c6.176-6.304,16.384-9.184,26.176-9.184c3.168,0,6.016,0.16,8.576,0.288c7.52,0.32,11.296,0.768,16.256,12.64
	c6.176,14.88,21.216,51.616,23.008,55.392c1.824,3.776,3.648,8.896,1.088,13.856c-2.4,5.12-4.512,7.392-8.288,11.744
	c-3.776,4.352-7.36,7.68-11.136,12.352c-3.456,4.064-7.36,8.416-3.008,15.936c4.352,7.36,19.392,31.904,41.536,51.616
	c28.576,25.44,51.744,33.568,60.032,37.024c6.176,2.56,13.536,1.952,18.048-2.848c5.728-6.176,12.8-16.416,20-26.496
	c5.12-7.232,11.584-8.128,18.368-5.568c6.912,2.4,43.488,20.48,51.008,24.224c7.52,3.776,12.48,5.568,14.304,8.736
	C411.2,329.152,411.2,344.032,405.024,361.504z" />
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                        </svg>
                                        <?php echo __('WhatsApp', 'encontreseusite'); ?>
                                    </a>
                                </p>
                                <p class="text-md">
                                    <a style=" font-size: 20px; " href="tel:<?php echo isset($data[0]) ? $data[0] : "" ?>">
                                        <?php echo __('Tel:', 'encontreseusite'); ?>
                                        <?php echo isset($data[0]) ? $data[0] : "" ?>
                                    </a>

                                </p>
                            <?php
                            endif;
                            ?>
                            <address class="text-md">
                                <?php

                                $terms = get_the_terms(get_the_ID(), 'soares_show_localizacao');
                                $maps = array();
                                $terms = json_decode(json_encode($terms), true);

                                usort($terms, function ($a, $b) {

                                    return $a['parent'] < $b['parent'];
                                });

                                foreach ($terms as $i => $term) :
                                    array_push($maps, $term['name']);
                                    if ($i == 0) :

                                    //$number = get_field('n_endereco', get_the_ID());
                                    //array_push($maps, $number);

                                    endif;

                                endforeach;
                                $endereco = implode(',', $maps);
                                $maps = str_replace(' ', '+', $endereco);
                                ?>
                                <p><?php echo __('Veja onde estamos localizados:', 'encontreseusite'); ?></p>
                                <a href="https://www.google.com/maps/place/<?php echo $maps; ?>" target="_blank">
                                    <?php echo $endereco; ?>
                                </a>
                            </address>
                        </section>
                        <section class="widget widget_search sidebar-widget">
                            <div class="contact-info-inner">
                                <?php
                                $data = get_post_meta(get_the_ID(), 'hour_open_soares');
                                if(!empty($data)):
                                ?>
                                <div class="single-box">
                                    <h3><?php echo __('Horário de funcionamento', 'encontreseusite'); ?></h3>
                                    <ul class="list clearfix">
                                        <li><?php echo isset($data[0]) ? $data[0] : "" ?></li>
                                        <li><?php echo __('Segunda a sexta', 'encontreseusite'); ?></li>
                                    </ul>
                                </div>
                                <?php 
                                endif;
                                $terms = get_the_terms(get_the_ID(), 'soares_show_localizacao');
                                if(!empty($terms)):        
                                ?>
                                <div class="single-box">
                                    <h3><?php echo __('Informações de contato', 'encontreseusite'); ?></h3>
                                    <ul class="list clearfix">
                                        <?php
                                        if ($terms) :
                                            $maps = array();
                                            $terms = json_decode(json_encode($terms), true);

                                            usort($terms, function ($a, $b) {

                                                return $a['parent'] < $b['parent'];
                                            });

                                            foreach ($terms as $i => $term) :
                                                array_push($maps, $term['name']);
                                                if ($i == 0) :

                                                //$number = get_field('n_endereco', get_the_ID());
                                                //array_push($maps, $number);

                                                endif;

                                            endforeach;
                                            $endereco = implode(',', $maps);
                                            $maps = str_replace(' ', '+', $endereco);
                                        ?>
                                            <li><?php echo $endereco; ?></li>
                                            <li><?php $data = get_post_meta(get_the_ID(), 'email_soares'); ?><a href="mailto:<?php echo isset($data[0]) ? $data[0] : "" ?>"><?php echo isset($data[0]) ? $data[0] : "" ?></a>
                                            </li>
                                            <li><?php $data = get_post_meta(get_the_ID(), 'telefone_soares'); ?><a href="tel:<?php echo isset($data[0]) ? $data[0] : "" ?>"><?php echo isset($data[0]) ? $data[0] : "" ?></a>
                                            </li>
                                        <?php
                                        endif;
                                        ?>
                                    </ul>
                                </div>
                                <?php
                                endif;
                                ?>
                            </div>
                        </section>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
<!-- banner-section end -->

<?php
get_template_part('theme-parts/theme', 'contact');

echo ob_get_clean();
unset($terms, $number, $maps, $endereco);
?>
<!-- main-footer -->
<?php
get_footer();
