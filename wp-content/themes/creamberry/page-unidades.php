<?php
get_header();
?>

<!-- main header -->
<?php
get_template_part('theme-parts/theme', 'menu');
?>
<!-- main-header end -->
<section class="news-section sec-pad pulltop-mobile" style="margin-top:100px;background-image: url(<?php bloginfo('url');?>/wp-content/themes/creamberry/assets/images/background/1.png);">
    <div class="auto-container">
        <div class="sec-title centred">
            <p><?php echo __('CreamBerry pelo Brasil', 'encontreseusite'); ?></p>
            <h2><?php echo __('Encontre a loja mais perto de você', 'encontreseusite'); ?></h2>
        </div>
        <div class="row clearfix">

            <div class="col-lg-12 col-md-12 col-sm-12 news-block text-center">
                <form id="form-search-franquias">

                    <select name="pais" id="pais">
                        <?php
$country = soares_get_locations(0);
foreach ($country as $i => $v):
?>
                            <option value="<?php echo $v->term_id ?>"><?php echo $v->name ?></option>
                        <?php
endforeach;
?>
                    </select>
                    <select name="estado" id="estado">
                        <option value=""><?php echo __('Estado', 'encontreseusite'); ?></option>
                    </select>
                    <select name="cidade" id="cidade">
                        <option value=""><?php echo __('Cidade', 'encontreseusite'); ?></option>
                    </select>
                    <select name="bairro" id="bairro">
                        <option value=""><?php echo __('Bairro', 'encontreseusite'); ?></option>
                    </select>
                    <select name="rua" id="rua">
                        <option value=""><?php echo __('Rua', 'encontreseusite'); ?></option>
                    </select>

                </form>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 news-block text-center row" id="lojas"></div>


        </div>


    </div>
</section>

<!-- news-section -->
<section class="news-section sec-pad" style="background-image: url(<?php bloginfo('url');?>/wp-content/themes/creamberry/assets/images/background/2.png);">
    <div class="auto-container">
        <div class="sec-title centred">
            <p><?php echo __('Tudo sobre açaí', 'encontreseusite'); ?></p>
            <h2><?php echo __('Nosso blog de receitas', 'encontreseusite'); ?> <br> <?php echo __('sugestões e notícias', 'encontreseusite'); ?></h2>
        </div>
        <div class="row clearfix">

            <?php
$posts = get_posts(array(
    'post_type' => 'post',
    'numberposts' => 3,
    'order' => 'DESC',
    'orderby' => 'date',
    'post_status' => 'publish',
));
if ($posts):
    foreach ($posts as $post):
        setup_postdata($post);
        ?>

		                    <article class="col-lg-4 col-md-6 col-sm-12 news-block" style="background:#FFF;">
		                        <div class="news-block-one wow fadeInUp animated animated">
		                            <div class="inner-box">
		                                <figure class="image-box">
		                                    <a href="<?php the_permalink();?>" rel="<?php the_title();?>">
		                                        <?php if (has_post_thumbnail()): ?>
		                                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title();?>" />
		                                        <?php endif;?>
	                                    </a>
	                                </figure>
	                                <div class="lower-content" style="height: 451px;">
	                                    <ul class="post-info clearfix">
	                                        <li><?php the_date();?></li>
	                                    </ul>
	                                    <h3>
	                                        <a href="<?php the_permalink();?>" rel="<?php the_title();?>"><?php the_title();?></a>
	                                    </h3>
	                                    <p>
	                                        <?php echo substr(get_the_excerpt(), 0, 260) . '...'; ?>
	                                    </p>
	                                    <div class="btn-box" style="position: absolute; bottom: -63px;">
	                                        <a href="<?php the_permalink();?>" rel="<?php the_title();?>" class="theme-btn-two"><?php echo __('Ver receita', 'encontreseusite') ?></a>
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

<script>
    let soares_location = {

        typeSelect:'country',
        lojas: document.querySelector("div#lojas"),
        parent: null,
        pais: document.querySelector('select[name="pais"]'),
        estado: document.querySelector('select[name="estado"]'),
        cidade: document.querySelector('select[name="cidade"]'),
        bairro: document.querySelector('select[name="bairro"]'),
        rua: document.querySelector('select[name="rua"]'),
        ultimaLocalizacao:'',

        ajax_data(term_id) {

            let xhr = new XMLHttpRequest();
            xhr.open('GET', '<?php echo admin_url('admin-ajax.php'); ?>?action=soares_show_posts_locations&term_id=' + term_id, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8')
            xhr.onreadystatechange = (state) => {

                soares_location.lojas.innerHTML = "";
                if (state.target.readyState == 4) {

                    if (state.target.response.length > 0) {

                        soares_location.lojas.innerHTML = state.target.response;

                    }

                }

            }
            xhr.send();

        },
        insertFieldsInput(json,fieldLocation){
            fieldLocation.innerHTML = "<option value=''>Selecione</option>";
            json.forEach((v, i) => {
                let option = document.createElement('option');
                option.innerText = v.name;
                option.value = v.term_id;
                fieldLocation.appendChild(option);
            });
        },
        ajax(data) {

            let xhr = new XMLHttpRequest();
            xhr.open('GET', '<?php echo admin_url('admin-ajax.php'); ?>?' + data, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8')
            xhr.onreadystatechange = (state) => {
                if (state.target.readyState == 4 && state.target.response.length > 0) {

                        let json = JSON.parse(state.target.response);

                        if (this.typeSelect == 'country') {

                            this.insertFieldsInput(json,soares_location.estado);

                        } else if (this.typeSelect == 'state') {

                            this.insertFieldsInput(json,soares_location.cidade);

                        } else if (this.typeSelect == 'city') {

                            this.insertFieldsInput(json,soares_location.bairro);

                        } else if (this.typeSelect == 'neighboor') {

                            this.insertFieldsInput(json,soares_location.rua);

                        }

                }

            }
            xhr.send();

        },

        changePais() {

            this.pais.onchange = (e) => {
                this.typeSelect = 'country';
                let pais = e.target.value;
                let data = "parent=" + pais + "&action=soares_show_locations";
                this.estado.value = "";
                this.cidade.value = "";
                this.bairro.value = "";
                this.rua.value = "";
                this.ajax(data);
                this.ajax_data(pais);

            }

        },



        changeEstado() {

            this.estado.onchange = (e) => {
                this.typeSelect = 'state';
                let estado = e.target.value.length > 0 ? e.target.value : this.pais.value;
                let data = "parent=" + estado + "&action=soares_show_locations";
                this.cidade.value = "";
                this.bairro.value = "";
                this.rua.value = "";
                this.ajax(data);
                this.ajax_data(estado);

            }

        },

        changeCidade() {

            this.cidade.onchange = (e) => {
                this.typeSelect = 'city';
                let cidade = e.target.value.length > 0 ? e.target.value : this.estado.value;
                let data = "parent=" + cidade + "&action=soares_show_locations";
                this.bairro.value = "";
                this.rua.value = "";
                this.ajax(data);
                this.ajax_data(cidade);

            }

        },

        changeBairro() {

            this.bairro.onchange = (e) => {
                this.typeSelect = 'neighboor';
                let bairro = e.target.value.length > 0 ? e.target.value : this.cidade.value;
                let data = "parent=" + bairro + "&action=soares_show_locations";
                this.rua.value = "";
                this.ajax(data);
                this.ajax_data(bairro);

            }

        },

        changeRua() {

            this.rua.onchange = (e) => {
                this.typeSelect = 'street';
                let rua = e.target.value;
                let data = "parent=" + rua + "&action=soares_show_locations";
                this.ajax(data);
                this.ajax_data(rua);

            }

        },

        init() {

            this.changePais();
            this.changeEstado();
            this.changeCidade();
            this.changeBairro();
            this.changeRua();
            this.typeSelect = 'country';
            let pais = this.pais.value;
            let data = "parent=" + pais + "&action=soares_show_locations";
            soares_location.ajax(data);
            soares_location.ajax_data(pais);

        }

    };

    soares_location.init();
</script>

<!-- main-footer -->
<?php
get_footer();
