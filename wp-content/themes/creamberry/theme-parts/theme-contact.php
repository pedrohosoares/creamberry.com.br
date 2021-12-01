<!-- contact-section -->
<section class="contact-section sec-pad" style="background-image: url(<?php bloginfo('url'); ?>/wp-content/themes/creamberry/assets/images/background/5.png);">
    <div class="auto-container">
        <div class="sec-title centred">
            <p><?php echo __('Contato', 'encontreseusite'); ?></p>
            <h2><?php echo __('Fale Conosco', 'encontreseusite'); ?></h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 form-column">
                <div class="form-inner">
                    <h3><?php echo __('Envie um e-mail', 'encontreseusite'); ?></h3>
                    <form method="post" action="silence" id="contact-form" class="default-form" novalidate="novalidate">
                        <div class="row clearfix">
                            <input type="hidden" name="url" value="" />
                            <script>
                                document.querySelector('form#contact-form input[name="url"]').value = window.location.href;
                            </script>
                            <div class="col-lg-6 col-md-6 col-sm-12 form-group"><input type="text" name="nome" placeholder="<?php echo __('Nome *', 'encontreseusite'); ?>" required="" aria-required="true">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 form-group"><input type="email" name="email" placeholder="<?php echo __('E-mail *', 'encontreseusite'); ?>" required="" aria-required="true">
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 form-group"><input type="text" name="celular" required="" placeholder="<?php echo __('Celular', 'encontreseusite'); ?>" aria-required="true">
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 form-group"><input type="text" name="assunto" required="" placeholder="<?php echo __('Assunto', 'encontreseusite'); ?>" aria-required="true">
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group"><textarea name="mensagem" placeholder="<?php echo __('Mensagem ...', 'encontreseusite'); ?>"></textarea>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn"><button class="theme-btn-one" type="submit" name="submit-form"><?php echo __('Enviar!', 'encontreseusite'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    let soares_send = {

        form: document.querySelector('form#contact-form'),
        ajax(data) {

            document.querySelector('button[name="submit-form"]').innerText = "Enviando..";
            document.querySelector('button[name="submit-form"]').setAttribute('disabled', 'disabled');
            let xhr = new XMLHttpRequest();
            xhr.open('POST', "<?php echo admin_url('admin-ajax.php'); ?>?" + data, true);
            xhr.setRequestHeader('Content-type', 'application/json;charset=utf-8');
            xhr.onreadystatechange = (e) => {
                if (e.target.readyState == 4) {

                    document.querySelector('button[name="submit-form"]').innerText = "Enviar!";
                    document.querySelector('button[name="submit-form"]').removeAttribute('disabled');

                }
            };
            xhr.send();

        },
        sendForm() {

            this.form.onsubmit = (e) => {
                e.preventDefault();
                let data = '';
                let total = e.target.querySelectorAll('input,textarea').length;
                let completos = 0;
                e.target.querySelectorAll('input,textarea').forEach((value, index) => {
                    if (value.value.length > 0) {
                        completos++;
                        value.style.border = "";
                    } else {
                        value.style.border = "2px solid red";
                    }
                    data += value.getAttribute('name') + '=' + value.value + '&';

                });
                data += "action=soares_send_mail";
                if (completos == total) {
                    soares_send.ajax(data);
                }

            };

        }

    };
    soares_send.sendForm();
</script>
<!-- contact-section end -->