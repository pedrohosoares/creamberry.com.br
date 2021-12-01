<?php

if (!function_exists('creamberry_setup')) :
	function creamberry_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Twenty Nineteen, use a find and replace
		 * to change 'creamberry' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('creamberry', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');
		set_post_thumbnail_size(1568, 9999);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
				'navigation-widgets',
			)
		);

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 197,
				'width'       => 81,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		// Add support for Block Styles.
		add_theme_support('wp-block-styles');

		// Add support for full and wide align images.
		add_theme_support('align-wide');

		// Add support for editor styles.
		add_theme_support('editor-styles');

		// Enqueue editor styles.
		add_editor_style('style-editor.css');

		// Add custom editor font sizes.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => __('Small', 'creamberry'),
					'shortName' => __('S', 'creamberry'),
					'slug'      => 'small',
				),
				array(
					'name'      => __('Normal', 'creamberry'),
					'shortName' => __('M', 'creamberry'),
					'slug'      => 'normal',
				),
				array(
					'name'      => __('Large', 'creamberry'),
					'shortName' => __('L', 'creamberry'),
					'slug'      => 'large',
				),
				array(
					'name'      => __('Huge', 'creamberry'),
					'shortName' => __('XL', 'creamberry'),
					'slug'      => 'huge',
				),
			)
		);

		// Editor color palette.
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => 'default' === get_theme_mod('primary_color') ? __('Blue', 'creamberry') : null,
					'slug'  => 'primary',
					'color' => '#FFFF',
				),
				array(
					'name'  => 'default' === get_theme_mod('primary_color') ? __('Dark Blue', 'creamberry') : null,
					'slug'  => 'secondary',
					'color' => '#FFFF',
				),
				array(
					'name'  => __('Dark Gray', 'creamberry'),
					'slug'  => 'dark-gray',
					'color' => '#111',
				),
				array(
					'name'  => __('Light Gray', 'creamberry'),
					'slug'  => 'light-gray',
					'color' => '#767676',
				),
				array(
					'name'  => __('White', 'creamberry'),
					'slug'  => 'white',
					'color' => '#FFF',
				),
			)
		);

		// Add support for responsive embedded content.
		add_theme_support('responsive-embeds');

		// Add support for custom line height.
		add_theme_support('custom-line-height');
	}
endif;
add_action('after_setup_theme', 'creamberry_setup');

if (!function_exists('creamberry_show_logo')) :

	function creamberry_show_logo()
	{
		$custom_logo_id = get_theme_mod('custom_logo');
		$logo = wp_get_attachment_image_src($custom_logo_id, 'full');
		if (has_custom_logo()) {
			echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" rel="' . get_bloginfo('name') . '" />';
		} else {
			echo '<h1>' . get_bloginfo('name') . '</h1>';
		}
	}

endif;

if (!function_exists('creamberry_widgets_init')) :
	function creamberry_widgets_init()
	{

		register_sidebar(
			array(
				'name'          => __('Aside (Menu Lateral)', 'creamberry'),
				'id'            => 'aside',
				'description'   => __('Put here your widgets for show in lateral menu.', 'creamberry'),
				'before_widget' => '<section id="%1$s" class="widget %2$s sidebar-widget">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => __('Footer IMG', 'creamberry'),
				'id'            => 'sidebar-img',
				'description'   => __('Add widgets here to appear in your footer img.', 'creamberry'),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
		register_sidebar(
			array(
				'name'          => __('Footer Left', 'creamberry'),
				'id'            => 'sidebar-1',
				'description'   => __('Add widgets here to appear in your footer left.', 'creamberry'),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
		register_sidebar(
			array(
				'name'          => __('Footer Center', 'creamberry'),
				'id'            => 'sidebar-2',
				'description'   => __('Add widgets here to appear in your footer center.', 'creamberry'),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
		register_sidebar(
			array(
				'name'          => __('Footer Right', 'creamberry'),
				'id'            => 'sidebar-3',
				'description'   => __('Add widgets here to appear in your footer right.', 'creamberry'),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}
endif;
add_action('widgets_init', 'creamberry_widgets_init');

if (!function_exists('creamberry_scripts')) :
	function creamberry_scripts()
	{
		wp_enqueue_style('creamberry-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));
		wp_style_add_data('creamberry-style', 'rtl', 'replace');
		wp_enqueue_style('creamberry-bootstrap-style', get_template_directory_uri() . '/assets/css/bootstrap.css', array(), wp_get_theme()->get('Version'));
		wp_enqueue_style('creamberry-global-style', get_template_directory_uri() . '/assets/css/global.css', array(), wp_get_theme()->get('Version'));
		wp_enqueue_style('creamberry-style-style', get_template_directory_uri() . '/assets/css/style.css', array(), wp_get_theme()->get('Version'));
		wp_enqueue_style('creamberry-responsive-style', get_template_directory_uri() . '/assets/css/responsive.css', array(), wp_get_theme()->get('Version'), 'only screen and (max-width: 1449px)');

		wp_register_script('creamberry-script', get_template_directory_uri() . '/assets/js/script.js', array(), null, true);
		wp_enqueue_script('creamberry-script');
		wp_localize_script('creamberry-script', 'creamberry_ajax', array('ajax' => admin_url('admin-ajax.php')));
	}
endif;
add_action('wp_enqueue_scripts', 'creamberry_scripts');

if (!function_exists('creamberry_menus')) :
	function creamberry_menus()
	{

		$locations = array(
			'primary'  => __('Primary Menu', 'creamberry'),
		);

		register_nav_menus($locations);
	}
endif;
add_action('init', 'creamberry_menus');

if (!function_exists('soares_update_page')) :

	function soares_update_page()
	{

		add_menu_page('Update Content', 'Soares Update content', 'manage_options', 'soares_update_page', 'soares_update_page_page');
		add_submenu_page('soares_update_page', 'Tags SEO e Contato', 'Tags Seo e Contato', 'manage_options', 'soares_update_config', 'soares_update_config');
	}

endif;
add_action('admin_menu', 'soares_update_page');

if (!function_exists('soares_update_config')) :

	function soares_update_config()
	{

		if (isset($_POST) and !empty($_POST)) {

			update_option('soares_meta_socials', serialize($_POST));
			echo "<script>window.location.href = '/wp-admin/admin.php?page=soares_update_config';</script>";
			exit;
		}

		ob_start();

		$option = get_option('soares_meta_socials');
		$option = !empty($option) ? unserialize($option) : array();
?>
		<h1><?php echo __('Meta da Home, contato e redes sociais', 'encontreseusite'); ?></h1>
		<form method="POST" action="<?php echo bloginfo('url') . '/wp-admin/admin.php?page=soares_update_config' ?>">

			<label>Meta description</label>
			<input type="text" style="width:100%;" value="<?php echo isset($option['meta_description']) ? $option['meta_description'] : ""; ?>" name="meta_description" id="" />
			<br />
			<label>Facebook</label>
			<input type="text" style="width:100%;" value="<?php echo isset($option['facebook']) ? $option['facebook'] : ""; ?>" name="facebook" id="" />
			<br />
			<label>Instagram</label>
			<input type="text" style="width:100%;" value="<?php echo isset($option['instagram']) ? $option['instagram'] : ""; ?>" name="instagram" id="" />
			<br />
			<label>Twitter</label>
			<input type="text" style="width:100%;" value="<?php echo isset($option['twitter']) ? $option['twitter'] : ""; ?>" name="twitter" id="" />
			<br />
			<label>Pinterest</label>
			<input type="text" style="width:100%;" value="<?php echo isset($option['pinterest']) ? $option['pinterest'] : ""; ?>" name="pinterest" id="" />
			<br />
			<label>WhatsApp</label>
			<input type="text" style="width:100%;" name="whatsapp" value="<?php echo isset($option['whatsapp']) ? $option['whatsapp'] : ""; ?>" id="" />
			<br />
			<label>Telegram</label>
			<input type="text" style="width:100%;" name="telegram" value="<?php echo isset($option['telegram']) ? $option['telegram'] : ""; ?>" id="" />
			<br />
			<label>E-mail</label>
			<input type="text" style="width:100%;" name="email" value="<?php echo isset($option['email']) ? $option['email'] : ""; ?>" id="" />
			<br />
			<label>Telefone</label>
			<input type="text" style="width:100%;" name="telefone" value="<?php echo isset($option['telefone']) ? $option['telefone'] : ""; ?>" id="" />
			<br /><br />
			<button class="button button-primary">Salvar</button>
		</form>
	<?php
		echo ob_get_clean();
	}

endif;

if (!function_exists('soares_editable')) :
	function soares_editable()
	{
		if (!empty($_POST['data'])) {

			update_option('soares_editable', $_POST['data']);
		}
		exit;
	}
endif;
add_action('wp_ajax_nopriv_soares_editable', 'soares_editable');
add_action('wp_ajax_soares_editable', 'soares_editable');

if (!function_exists('soares_update_page_page')) :

	function soares_update_page_page()
	{
		ob_start();
		wp_enqueue_style('creamberry-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));
		wp_style_add_data('creamberry-style', 'rtl', 'replace');
		wp_enqueue_style('creamberry-bootstrap-style', get_template_directory_uri() . '/assets/css/bootstrap.css', array(), wp_get_theme()->get('Version'));
		wp_enqueue_style('creamberry-global-style', get_template_directory_uri() . '/assets/css/global.css', array(), wp_get_theme()->get('Version'));
		wp_enqueue_style('creamberry-style-style', get_template_directory_uri() . '/assets/css/style.css', array(), wp_get_theme()->get('Version'));
		wp_enqueue_style('creamberry-responsive-style', get_template_directory_uri() . '/assets/css/responsive.css', array(), wp_get_theme()->get('Version'), 'only screen and (max-width: 1449px)');
		wp_enqueue_media();

		$content = get_option('soares_editable');
	?>
		<h1><?php echo __('Soares Content Update', 'encontreseuplugin'); ?></h1>
		<button class="btn btn-primary" id="save_soares"><?php echo __('Salvar', 'encontreseuplugin'); ?></button>
		<hr />
		<div id="soares-content-update">
			<?php
			if (empty($content)) :
			?>
				<section class="banner-section style-one" style="background-image:url(<?php bloginfo('url'); ?>/wp-content/themes/creamberry/assets/images/banner/creamberry-1.png)">
					<div class="banner-carousel owl-loaded">

						<div class="anim-icon">
							<div class="icon icon-1" style="background-image: url(assets/images/icons/anim-icon-1.png);">
							</div>
							<div class="icon icon-2" style="background-image: url(assets/images/icons/anim-icon-2.png);">
							</div>
							<div class="icon icon-3" style="background-image: url(assets/images/icons/anim-icon-3.png);">
							</div>
							<div class="icon icon-4" style="background-image: url(assets/images/shape/shape-1.png);">
							</div>
							<div class="icon icon-5" style="background-image: url(assets/images/shape/shape-2.png);">
							</div>
						</div>
						<div class="auto-container">
							<div class="content-inner" style="margin-top:-34px;">
								<div class="content-box">
									<h1>Açai para todos os momentos.</h1>
									<p>Comemore seu Happy Hour com o nosso açaí</p>
									<div class="btn-box">
										<a href="/" class="banner-btn">Faça seu pedido</a>
									</div>
								</div>
								<figure class="image-box style-one">
									<img src="<?php bloginfo('url'); ?>/wp-content/themes/creamberry/files/banner-image-1.png" alt="">
								</figure>
							</div>
						</div>

					</div>
				</section>

				<section class="feature-section">
					<div class="auto-container">
						<div class="row clearfix">
							<div class="col-lg-4 col-md-6 col-sm-12 feature-block">
								<div class="feature-block-one wow fadeInUp animated animated animated" data-wow-delay="00ms" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInUp;">
									<div class="inner-box">
										<div class="count-box counted" style="background-image: url(assets/images/icons/icon-bg-2.png);">
											<h4>01</h4>
										</div>
										<div class="inner">
											<h4>Açaí Cremoso</h4>
											<p>Nosso açai é cremoso, com a melhor textura do mercado.</p>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-sm-12 feature-block">
								<div class="feature-block-one wow fadeInUp animated animated animated" data-wow-delay="00ms" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInUp;">
									<div class="inner-box">
										<div class="count-box counted" style="background-image: url(assets/images/icons/icon-bg-2.png);">
											<h4>02</h4>
										</div>
										<div class="inner">
											<h4>Açai 100% natural</h4>
											<p>Nosso produto é 100% feito de açaí, não usamos aditivos.</p>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-sm-12 feature-block">
								<div class="feature-block-one wow fadeInUp animated animated animated" data-wow-delay="00ms" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInUp;">
									<div class="inner-box">
										<div class="count-box counted" style="background-image: url(assets/images/icons/icon-bg-2.png);">
											<h4>03</h4>
										</div>
										<div class="inner">
											<h4>Sorvetes naturais</h4>
											<p>Possuimos sorvetes 100% naturais.</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>

				<section class="ourstory-section sec-pad" style="background-image: url(<?php bloginfo('url'); ?>/wp-content/themes/creamberry/assets/images/background/mission-1.jpg);">
					<div class="auto-container">
						<div class="sec-title centred">
							<p>Açai puro</p>
							<h2>O açaí é uma ótima forma de confraternizar com a família e amigos.</h2>
						</div>
						<div class="row align-items-center clearfix">
							<div class="col-lg-4 col-md-6 col-sm-12 content-column">
								<div id="content_block_1">
									<div class="content-box">
										<h3>O que é açai</h3>
										<p>O açaí é uma palmeira comum na região da Amazônia, seu fruto na cor roxa é consumido
											de diversas maneiras, podendo ser consumido quente ou frio. Atualmente é consumido
											na forma de sorvete ou pastoso. Seu consumo combina com cupuaçu, granola e frutas.
											Além de ser fontes de vitaminas, possui um sabor único. O açaí é considerado uma
											ótima forma de confraternizar com os amigos e família.</p>

									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-sm-12 image-column">
								<figure class="image-box wow slideInUp animated animated animated" data-wow-delay="00ms" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: slideInUp;">
									<img src="<?php bloginfo('url'); ?>/wp-content/themes/creamberry/files/ice-cream-1.png" alt="">
								</figure>
							</div>
							<div class="col-lg-4 col-md-6 col-sm-12 content-column">
								<div id="content_block_2">
									<div class="content-box">
										<h3>CreamBerry</h3>
										<p>A CreamBerry é uma empresa de açai Accusan enim ipsam voluptam quia voluptas sit
											aspern odit aut sed quia consequnt magni dolores eos qui ratione voluptatem.sequi
											nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet.</p>
										<ul class="list clearfix">
											<li>
												<i class="icon-Check-mark">
												</i>Açai 100% natural.
											</li>
											<li>
												<i class="icon-Check-mark">
												</i>Açai pasteurizado a frio.
											</li>
											<li>
												<i class="icon-Check-mark">
												</i>Açai cremoso.
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="more-btn centred">
							<a href="/" class="theme-btn-one">Conheça nossas
								franquias</a>
						</div>
					</div>
				</section>

				<section class="promotion-section sec-pad" style="background-image: url(<?php bloginfo('url'); ?>/wp-content/themes/creamberry/assets/images/background/promotion-1.jpg);">
					<div class="auto-container">
						<div class="sec-title centred">
							<p>Sobre nosso açai</p>
							<h2>Informação nutricional</h2>
						</div>
						<div class="inner-box mb-50 wow slideInRight animated animated animated">
							<div class="row clearfix">
								<div class="col-lg-6 col-md-12 col-sm-12 image-column">
									<div class="image-box clearfix mr-10">
										<figure class="image pull-left mr-10">
											<img src="<?php bloginfo('url'); ?>/wp-content/themes/creamberry/files/promotion-1.jpg" alt="">
										</figure>
										<figure class="image pull-left">
											<img src="<?php bloginfo('url'); ?>/wp-content/themes/creamberry/files/promotion-2.jpg" alt="">
										</figure>
									</div>
								</div>
								<div class="col-lg-6 col-md-12 col-sm-12 content-column">
									<div class="content-box ml-10">
										<h3>Nossa tabela nutricional</h3>
										<p>Gostamos de deixar claro para nossos <i>"CreamBerrys"</i>, sobre o açaí que eles
											estão consumindo.
											Proteínas 0,8 g Vitamina E 14,8 mg
											Gorduras 3,9 g
											Cálcio

											35 mg
											Carboidratos 6,2 g Ferro 11,8 mg
											Fibras 2,6 g Vitamina C 9 mg
											Potássio 125 mg Fósforo 0,5 mg
											Magnésio 17 mg Manganésio 6,16 mg <br>
											Ácido cítrico

											É um ácido orgânico encontrado nas frutas cítricas como a laranja e o limão.
											Ele tem a função de neutralizar o sabor doce.
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>

				<section class="testimonial-section sec-pad" style="background-image: url(<?php bloginfo('url'); ?>/wp-content/themes/creamberry/assets/images/background/testimonial-1.jpg);">

					<div class="auto-container">
						<figure class="image-layer wow slideInUp animated animated">
							<img src="<?php bloginfo('url'); ?>/wp-content/themes/creamberry/files/testimonial-1.png" alt="">
						</figure>
						<div class="inner-box">
							<div class="sec-title">
								<p>Franqueados</p>
								<h2>O que nossos franqueados dizem sobre nós</h2>
							</div>
							<div class="testimonial-block-one">
								<div class="icon-box" style="background-image: url(assets/images/icons/icon-bg-5.png);">
									<i class="icon-Quote">
									</i>
								</div>
								<div class="text">
									<p>Somos muito felizes com a CreamBerry. O Açai é excelente, sem pedras de
										gelo, cremoso e o sabor bastante agradável. Nossos clientes são
										fidelizados de maneira muito rápida.</p>
								</div>
								<div class="author-info">
									<h4>Pedro Soares</h4>
									<span class="designation">Programador</span>
								</div>
							</div>
						</div>
					</div>
				</section>
			<?php
			else :
				echo stripslashes($content);
			endif;
			?>

		</div>
		<?php echo __("Editor criado por <a href='https://br.linkedin.com/public-profile/in/pedro-soares-27657756'>Pedro Soares</a>", 'encontreseusite'); ?>
		<script>
			window.onload = () => {
				let soares_content_editable = {
					content: document.querySelector('#soares-content-update'),
					save_soares: document.querySelector('#save_soares'),
					currentImg: null,
					media: null,
					tags: document.querySelector('#soares-content-update').querySelectorAll('p,a,span,i,h1,h2,h3,h4,h5,h6'),
					section: document.querySelector('#soares-content-update').querySelectorAll('section'),
					button: document.querySelector('#soares-content-update').querySelectorAll('button,a'),
					imgs: document.querySelector('#soares-content-update').querySelectorAll('img'),
					saveElement() {

						this.save_soares.onclick = (e) => {

							soares_content_editable.tags.forEach((v, i) => {

								v.removeAttribute('contenteditable');
								v.style.border = "";
								v.style.minHeight = "";

							});

							soares_content_editable.content.querySelectorAll('.changebackground').forEach((v, i) => {

								v.remove();

							});

							let content_edit = soares_content_editable.content.innerHTML;
							e.target.innerText = "Salvando..";
							e.target.setAttribute('disabled', 'disabled');

							jQuery.ajax({
								url: ajaxurl,
								type: "POST",
								dataType: "JSON",
								data: {
									action: 'soares_editable',
									data: content_edit
								},
								complete: () => {
									let self_url = window.location.href;
									window.location.href = self_url;
								}
							});

						};


					},
					changeImg() {
						this.imgs.forEach((v, i) => {

							if (soares_content_editable.media == null) {
								soares_content_editable.media = wp.media({
									title: 'Select or Upload Media Of Your Chosen Persuasion',
									button: {
										text: 'Use this media'
									},
									multiple: false // Set to true to allow multiple files to be selected
								})
							}
							v.style.cursor = "pointer";
							v.onclick = (img) => {

								soares_content_editable.currentImg = img.target;
								soares_content_editable.media.open();

							};
							soares_content_editable.media.on('select', function() {

								// Get media attachment details from the frame state
								let url = soares_content_editable.media.state().get('selection').first().toJSON().url;
								soares_content_editable.currentImg.setAttribute("src", url);

							});

						});
					},
					putButton() {

						this.button.forEach((v, i) => {

							v.onclick = (e) => {
								e.preventDefault();
								let exits = e.target.parentNode.querySelector('input');
								if (exits != null) {
									return;
								}
								let div = document.createElement('div');
								let input = document.createElement('input');
								input.setAttribute('type', 'text');
								input.style.border = "1px solid #666";
								input.style.padding = "5px";
								input.value = v.getAttribute('href');
								div.appendChild(input);
								div.style.position = "absolute";
								div.style.top = "70px";
								div.style.marginLeft = "-47px";
								v.appendChild(div);
								input.onfocusout = (e) => {
									console.log(e);
									v.setAttribute('href', input.value);
									input.remove();
								}

							}


						});

					},
					putBackground() {

						this.section.forEach((v, i) => {

							let changeBackground = document.createElement('button');
							changeBackground.innerText = "IMG BG";
							changeBackground.setAttribute('class', 'changebackground');
							changeBackground.style.position = "absolute";
							changeBackground.style.height = "50px";
							changeBackground.style.background = "#FFF";
							changeBackground.style.borderRadius = "8px";
							changeBackground.style.marginTop = "5px";
							changeBackground.style.padding = "10px";
							changeBackground.style.boxShadow = "0px 0px 15px 5px #333";
							changeBackground.style.cursor = "pointer";
							changeBackground.style.zIndex = "9999999999999999";
							changeBackground.style.marginLeft = "55px";


							changeBackground.onclick = (e) => {

								if (e.target.tagName == 'H1' || e.target.tagName == 'H2' || e.target.tagName == 'H3' || e.target.tagName == 'H4' || e.target.tagName == 'H5' || e.target.tagName == 'H6') {

									return;

								}

								if (soares_content_editable.media == null) {
									soares_content_editable.media = wp.media({
										title: 'Select or Upload Media Of Your Chosen Persuasion',
										button: {
											text: 'Use this media'
										},
										multiple: false // Set to true to allow multiple files to be selected
									})
								}
								v.onclick = (img) => {
									soares_content_editable.currentImg = e.target.parentNode;
									soares_content_editable.media.open();

								};
								soares_content_editable.media.on('select', function() {

									// Get media attachment details from the frame state
									let url = soares_content_editable.media.state().get('selection').first().toJSON().url;
									soares_content_editable.currentImg.style.backgroundImage = 'url(' + url + ')';
									console.log(soares_content_editable.currentImg.style.backgroundImage, url);

								});

							}

							v.prepend(changeBackground);

						});

					},
					putColor() {

						this.section.forEach((v, i) => {

							let changeBackground = document.createElement('input');
							changeBackground.setAttribute('type', 'color');
							changeBackground.setAttribute('class', 'changebackground');
							changeBackground.style.position = "absolute";
							changeBackground.style.height = "50px";
							changeBackground.style.background = "#FFF";
							changeBackground.style.borderRadius = "8px";
							changeBackground.style.marginTop = "5px";
							changeBackground.style.marginLeft = "5px";
							changeBackground.style.padding = "10px";
							changeBackground.style.boxShadow = "0px 0px 15px 5px #333";
							changeBackground.style.cursor = "pointer";
							changeBackground.style.zIndex = "9999999999999999";



							changeBackground.onchange = (e) => {

								e.target.parentNode.style.background = e.target.value;

							}

							v.prepend(changeBackground);

						});

					},
					editContent() {

						this.tags.forEach((v, i) => {

							v.style.border = "1px dotted #333";
							v.style.minHeight = "20px";
							v.setAttribute('contenteditable', true);

							v.onclick = (e) => {

								let este = e.target;
								if (este.getAttribute('class') == 'changebackground' || este.parentNode.getAttribute('class') == 'changebackground') {
									return;
								}
								if (este.getAttribute('click') == 'yes') {
									return;
								}
								este.setAttribute('click', 'yes');


								let changeBackground = document.createElement('div');
								changeBackground.setAttribute('class', 'changebackground');
								changeBackground.style.position = "absolute";
								changeBackground.style.height = "50px";
								changeBackground.style.background = "#FFF";
								changeBackground.style.borderRadius = "8px";
								changeBackground.style.marginTop = "5px";
								changeBackground.style.marginLeft = "5px";
								changeBackground.style.padding = "10px";
								changeBackground.style.boxShadow = "0px 0px 15px 5px #333";
								changeBackground.style.cursor = "pointer";
								changeBackground.style.zIndex = "9999999999999999";
								changeBackground.style.top = "-65px";
								changeBackground.style.minWidth = "337px";
								changeBackground.style.lineHeight = "0px";


								let strong = document.createElement('button');
								strong.innerText = "strong";
								strong.style.marginLeft = "10px";
								let italic = document.createElement('button');
								italic.innerText = "Italic";
								italic.style.marginLeft = "10px";
								let fontSize = document.createElement('input');
								fontSize.setAttribute('placeholder', 'Size');
								fontSize.style.marginLeft = "10px";
								fontSize.style.width = "65px";
								fontSize.setAttribute('type', 'number');
								fontSize.setAttribute('min', '1');
								let color = document.createElement('input');
								color.style.marginLeft = "10px";
								color.setAttribute('type', 'color');
								let close = document.createElement('button');
								close.style.marginLeft = "20px";
								close.innerText = "X";


								changeBackground.appendChild(strong);
								changeBackground.appendChild(italic);
								changeBackground.appendChild(fontSize);
								changeBackground.appendChild(color);
								changeBackground.appendChild(close);


								fontSize.onchange = (estrong) => {
									este.style.fontSize = estrong.target.value + "px";
								}

								close.onclick = (estrong) => {
									este.removeAttribute('click');
									changeBackground.remove();
								}

								strong.onclick = (estrong) => {
									if (estrong.target.getAttribute('click') == 'yes') {
										estrong.target.setAttribute('click', 'no');
										estrong.target.style.background = "";
										este.style.fontWeight = "";

									} else {
										estrong.target.setAttribute('click', 'yes');
										estrong.target.style.background = "#CCC";
										este.style.fontWeight = "bold";
									}
								}

								italic.onclick = (estrong) => {
									if (estrong.target.getAttribute('click') == 'yes') {
										estrong.target.setAttribute('click', 'no');
										estrong.target.style.background = "";
										este.style.fontStyle = "";

									} else {
										estrong.target.setAttribute('click', 'yes');
										estrong.target.style.background = "#CCC";
										este.style.fontStyle = "italic";
									}
								}

								color.onchange = (estrong) => {

									este.style.color = estrong.target.value;

								}


								e.target.appendChild(changeBackground);




							};

						});

					},
					init() {

						this.editContent();
						this.putButton();
						this.putColor();
						this.changeImg();
						this.saveElement();
						this.putBackground();

					}
				};
				soares_content_editable.init();
			}
		</script>
		<?php
		echo ob_get_clean();
	}

endif;

if (!function_exists('soares_get_locations')) :
	function soares_get_locations($parent)
	{

		return get_terms(
			array(
				'taxonomy' => 'soares_show_localizacao',
				'hide_empty' => false,
				'parent' => $parent
			)
		);
		exit;
	}
endif;

if (!function_exists('soares_show_locations')) :
	function soares_show_locations()
	{
		$parent = !isset($_REQUEST["parent"]) ? 0 : $_REQUEST["parent"];

		echo json_encode(soares_get_locations($parent));
		exit;
	}
endif;
add_action('wp_ajax_nopriv_soares_show_locations', 'soares_show_locations');
add_action('wp_ajax_soares_show_locations', 'soares_show_locations');

if (!function_exists('soares_show_posts_locations')) :
	function soares_show_posts_locations()
	{
		if (!isset($_REQUEST['term_id']) or empty($_REQUEST['term_id'])) {
			exit;
		}
		$franquias = get_posts(array(

			'post_type' => 'soaresshow',
			'numberposts' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => 'soares_show_localizacao',
					'field' => 'term_id',
					'terms' => $_REQUEST['term_id'],
					'include_children' => false
				)
			)
		));
		foreach ($franquias as $i => $franquia) :
		the_post();
		?>
			<article class="col-lg-4 col-md-6 col-sm-12 news-block">
				<div class="news-block-one wow fadeInUp animated animated">
					<div class="inner-box" style=" height: 293px; ">
						<div class="lower-content">
							<h2 style="font-size: 35px;">
                                <?php echo $franquia->post_title;?>
							</h2>
							<?php 
								$titleEmBreve = strtolower($franquia->post_title);
								$titleEmBreve = strpos($titleEmBreve,'em breve');
							?>
							<h3 style="font-size:17px;">
								<?php
								$terms = get_the_terms($franquia->ID, 'soares_show_localizacao');
								$maps = array();
								$terms = json_decode(json_encode($terms), true);
								usort($terms, function ($a, $b) {
									return $a['parent'] > $b['parent'];
								});
								foreach ($terms as $i => $term) :
									array_push($maps, $term['name']);
								endforeach;
								$endereco = implode(', ', $maps);
								$maps = str_replace(' ', '+', $endereco);
								if($titleEmBreve !== false){
								?>
								<a href="<?php the_permalink($franquia->ID); ?>" rel="<?php echo $franquia->post_title; ?>">
									<?php echo $endereco; ?>
								</a>
								<?php
								}else{
									echo $endereco;
								}
								?>
							</h3>
							
							<div class="btn-box">
								<?php 
								if($titleEmBreve !== false){
								?>
									<a href="<?php the_permalink($franquia->ID); ?>" rel="<?php echo $franquia->post_title; ?>" class="theme-btn-two"><?php echo __('Ver Unidade', 'encontreseusite'); ?></a>
								<?php 
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</article>
<?php
			
		endforeach;
		wp_reset_postdata();
		exit;
	}
endif;
add_action('wp_ajax_nopriv_soares_show_posts_locations', 'soares_show_posts_locations');
add_action('wp_ajax_soares_show_posts_locations', 'soares_show_posts_locations');


if (!function_exists('soares_send_mail')) :
	function soares_send_mail()
	{

		$url = explode('/', $_REQUEST['url']);
		$message = "Assunto: " . $_REQUEST['assunto'] . "\r\n";
		$message .= "Nome: " . $_REQUEST['nome'] . "\r\n";
		$message .= "E-mail: " . $_REQUEST['email'] . "\r\n";
		$message .= "Celular: " . $_REQUEST['celular'] . "\r\n";
		$message .= "Mensagem: " . $_REQUEST['mensagem'] . "\r\n";
		if (isset($url[4]) and !empty($url)) :
			global $wpdb;
			$post = $wpdb->get_results("SELECT {$wpdb->prefix}postmeta.meta_value FROM {$wpdb->prefix}posts LEFT JOIN {$wpdb->prefix}postmeta ON ({$wpdb->prefix}posts.ID = {$wpdb->prefix}postmeta.post_id) WHERE {$wpdb->prefix}posts.post_name='{$url[4]}' AND {$wpdb->prefix}postmeta.meta_key='email_soares'");
			if (!empty($post)) :
				wp_mail($post[0]->meta_value, 'Contato - CreamBerry', $message);
				exit;
			endif;
		endif;
		wp_mail('contato@creamberry.com.br', 'Contato - CreamBerry', $message);
		exit;
	}
endif;
add_action('wp_ajax_nopriv_soares_send_mail', 'soares_send_mail');
add_action('wp_ajax_soares_send_mail', 'soares_send_mail');
