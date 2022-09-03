<?php

/**
 * The header.
 */

if (!is_user_logged_in() && strpos($_SERVER['REQUEST_URI'], URL_NETWORK) !== false) {
    auth_redirect();
}
global $wp_query;
$user_info = wp_get_current_user();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <header class="fixed-header header-wrap">
        <section class="cs-header" uk-sticky="show-on-up: true; animation: uk-animation-slide-top;">
            <a href="<?php echo home_url('/') ?>">
                <picture>
                    <source srcset="<?php echo get_template_directory_uri() ?>/assets/img/index/logo.svg" type="image/webp"><img src="<?php echo get_template_directory_uri() ?>/assets/img/index/logo.svg" class="cs-desctop-logo" alt="">
                </picture>
                <picture>
                    <source srcset="<?php echo get_template_directory_uri() ?>/assets/img/index/mob-logo.svg" type="image/webp"><img src="<?php echo get_template_directory_uri() ?>/assets/img/index/mob-logo.svg" class="cs-mob-logo" alt="">
                </picture>
            </a>
            <div class="uk-flex uk-flex-between uk-flex-middle header-nav">
                <!--      <a href="#"><picture><source srcset="img/index/user.svg" type="image/webp"><img src="img/index/user.svg" class="cs-user-ico" alt=""></picture></a>-->
                <button class="ghost-btn" id="triggerMenuShow">
                    <picture>
                        <source srcset="<?php echo get_template_directory_uri() ?>/assets/img/index/menu.svg" type="image/webp"><img src="<?php echo get_template_directory_uri() ?>/assets/img/index/menu.svg" class="cs-menu-ico" alt="">
                    </picture>
                </button>
            </div>
        </section>
        <section class="cs-nav uk-animation-slide-top-medium soc-mob-header" id="header-nav">
            <button class="ghost-btn cs-nav-close" id="closeBtn">
                <picture>
                    <source srcset="<?php echo get_template_directory_uri() ?>/assets/img/soc/close.svg" type="image/webp">
                    <img src="<?php echo get_template_directory_uri() ?>/assets/img/soc/close.svg" alt="">
                </picture>
            </button>
            <div class="soc-mob-menu">
                <div class="soc-ls-user uk-flex uk-flex-center uk-flex-column uk-flex-middle">
                    <div class="soc-ls-user__img">
                        <a href="/<?php echo URL_NETWORK ?>/user/">
                            <picture><?php echo get_avatar($user_info->ID); ?></picture>
                        </a>
                    </div>
                    <div class="soc-ls-user__name"><?php echo $user_info->data->display_name; ?></div>
                    <div class="soc-ls-user__pos"><?php echo get_field('user_role_blog', 'user_' . $user_info->data->ID); ?></div>
                </div>

                <nav class="soc-nav">
                    <?php
                    wp_nav_menu(
                        array(
                            'container' => false,
                            'menu' => 'social',
                            'menu_class' => 'soc-nav__ul',
                            'before' => '<div>',
                            'after' => '</div>',
                            //                    'container_class'     => 'soc-nav__item',
                        )
                    );
                    ?>
                </nav>

                <div class="checkout">
                    <a href="<?php echo home_url('/') ?>" class="checkout__item">
                        <picture>
                            <source srcset="<?php echo get_template_directory_uri() ?>/assets/img/soc/cons.svg" type="image/webp"><img src="<?php echo get_template_directory_uri() ?>/assets/img/soc/cons.svg" alt="">
                        </picture>
                        <span>Перейти в Консорциум</span>
                    </a>
                </div>
            </div>
        </section>
    </header>