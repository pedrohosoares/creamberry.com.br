<footer class="main-footer" style="background-image: url(<?php bloginfo('url'); ?>/wp-content/themes/creamberry/assets/images/background/footer-1.jpg);">
    <div class="auto-container">
        <div class="subscribe-inner clearfix">
            <div class="text pull-left">
                <h2><?php bloginfo('name') ?></h2>
            </div>
            <div class="form-inner pull-right">
                <form action="/" method="post" class="subscribe-form">
                    <div class="form-group">
                        <input type="email" name="email" placeholder="E-mail" required="">
                        <button type="submit" class="theme-btn-one">Me Inscrever</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="footer-top">
            <div class="widget-section">
                <div class="row clearfix">
                    <div class="col-lg-3 col-md-6 col-sm-12 footer-column">
                        <?php if (is_active_sidebar('sidebar-img')) : ?>
                            <div class="footer-widget logo-widget">
                                <?php dynamic_sidebar('sidebar-img'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 footer-column">
                        <?php if (is_active_sidebar('sidebar-1')) : ?>
                            <div class="footer-widget contact-widget">
                                <?php dynamic_sidebar('sidebar-1'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-12 footer-column">
                        <?php if (is_active_sidebar('sidebar-2')) : ?>
                            <div class="footer-widget links-widget">
                            <?php dynamic_sidebar('sidebar-2'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 footer-column">
                        <?php if (is_active_sidebar('sidebar-3')) : ?>
                            <?php dynamic_sidebar('sidebar-3'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="auto-container clearfix">
            <div class="copyright pull-left">
                <p>
                    CreamBerry © 2021 Todos direitos reservados
                </p>
            </div>
            <ul class="footer-nav pull-right">
                <li>
                    <a href="https://br.linkedin.com/public-profile/in/pedro-soares-27657756">Tema wordress programado por Pedro Soares</a>
                </li>
            </ul>
        </div>
    </div>
</footer>
<!-- main-footer end -->

</div>
<?php
wp_footer();
?>
</body>
<!-- End of .page_wrapper -->

</html>