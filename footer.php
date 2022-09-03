<?php

/**
 * The template for displaying the footer
 *
 */
global $user_ID, $user_identity, $user_level;
?>
<footer class="footer">
    <section class="cs-container uk-flex uk-flex-between">
        <div class="footer-ls">
            <a href="<?php echo home_url('/') ?>">
                <picture>
                    <source srcset="<?php echo get_template_directory_uri() ?>/assets/img/index/logo.svg" type="image/webp"><img src="<?php echo get_template_directory_uri() ?>/assets/img/index/logo.svg" alt="">
                </picture>
            </a>

            <div class="footer-contacts">
                <a href="mailto:pochta@mail.ru">pochta@mail.com</a>
                <a href="tel:+14955883545">+1 (111) 111-35-45</a>
            </div>

            <div class="footer-soc uk-flex uk-flex-middle">
                <a href="#">
                    <picture>
                        <source srcset="<?php echo get_template_directory_uri() ?>/assets/img/vk.svg" type="image/webp"><img src="<?php echo get_template_directory_uri() ?>/assets/img/vk.svg" alt="">
                    </picture>
                </a>
                <a href="#">
                    <picture>
                        <source srcset="<?php echo get_template_directory_uri() ?>/assets/img/fb.svg" type="image/webp"><img src="<?php echo get_template_directory_uri() ?>/assets/img/fb.svg" alt="">
                    </picture>
                </a>
                <a href="">
                    <picture>
                        <source srcset="<?php echo get_template_directory_uri() ?>/assets/img/google.svg" type="image/webp"><img src="<?php echo get_template_directory_uri() ?>/assets/img/google.svg" alt="">
                    </picture>
                </a>
            </div>
        </div>
        <div class="footer-rs uk-flex">
            <?php
            wp_nav_menu(
                array(
                    'container' => false,
                    'menu' => '11',
                    'menu_class' => 'footer__col',
                )
            );
            ?>
            <?php
            wp_nav_menu(
                array(
                    'container' => false,
                    'menu' => '10',
                    'menu_class' => 'footer__col',
                )
            );
            ?>
        </div>
    </section>
</footer>

<?php if (!is_user_logged_in()) { ?>
    <!-- This is the modal with the default close button -->
    <div id="auth-modal" uk-modal>
        <div class="uk-modal-dialog uk-modal-body cs-modal login_box">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <h2>Авторизоваться</h2>
            <form action="/wp-login.php" method="post">
                <div class="uk-form-controls">
                    <input class="uk-input cs-inpit" placeholder="Логин" type="text" name="log">
                </div>
                <div class="uk-form-controls">
                    <input class="uk-input cs-inpit" placeholder="Пароль" type="password" name="pwd">
                </div>
                <a href="/wp-login.php?action=lostpassword" class="red-link cs-mt-minus">Забыли пароль?</a>

                <button type="submit" name="wp-submit" class="ghost-btn cs-btn btn btn-5 uk-width-1-1 cs-auth-btn">Авторизоваться</button>
                <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI'] ?>">
                <input type="hidden" name="testcookie" value="1">
            </form>
            <div class="uk-text-center">
                <a href="/register/" class="red-underline-link">Зарегистрироваться</a>
            </div>
        </div>
    </div>
<?php } ?>

<div id="access" uk-modal>
    <div class="uk-modal-dialog uk-modal-body cs-modal-access">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <h2 class="soc-h1 mb-23">Доступ к закрытому тематическому разделу</h2>
        <form action="">
            <h4 class="settings__title">Вид доступа</h4>
            <div class="uk-flex cs-radiobar uk-margin-medium-bottom">
                <input type="radio" name="rb3" id="rb21" checked> <label for="rb21" class="label-radio">Чтение</label>
                <input type="radio" name="rb3" id="rb22"> <label for="rb22" class="label-radio">Редактирование</label>
            </div>

            <div class="soc-art__textarea-wrap">
                <label class="uk-form-label cs-mb-9 uk-display-block">Обоснование заявки</label>
                <textarea name="" class="soc-art__textarea"></textarea>
            </div>


            <div class="uk-flex cs-flex-end mt-30">
                <div class="uk-flex uk-flex-middle">
                    <button type="button" class="ghost-btn btn-text-red mr-40">отменить</button>
                    <button type="button" class="ghost-btn cs-btn btn btn-5 conferention__btn">отправить</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script defer src="<?php echo get_template_directory_uri() ?>/assets/js/script.js"></script>
<?php wp_footer(); ?>

</body>

</html>