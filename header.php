<?php

/**
 * The header.
 */

if (!is_user_logged_in() && strpos($_SERVER['REQUEST_URI'], URL_NETWORK) !== false) {
    auth_redirect();
}
global $user_ID, $user_identity, $user_level;
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
                <?php if (is_user_logged_in()) { ?>
                    <a class="ghost-btn" href="<?php echo '/' . URL_NETWORK . '/' ?>">
                        <picture>
                            <source srcset="<?php echo get_template_directory_uri() ?>/assets/img/index/user.svg" type="image/webp"><img src="<?php echo get_template_directory_uri() ?>/assets/img/index/user.svg" class="cs-user-ico" alt="">
                        </picture>
                    </a>
                <?php } else { ?>
                    <button class="ghost-btn" uk-toggle="target: #auth-modal">
                        <picture>
                            <source srcset="<?php echo get_template_directory_uri() ?>/assets/img/index/user.svg" type="image/webp"><img src="<?php echo get_template_directory_uri() ?>/assets/img/index/user.svg" class="cs-user-ico" alt="">
                        </picture>
                    </button>
                <?php } ?>

                <button class="ghost-btn" id="triggerMenuShow">
                    <picture>
                        <source srcset="<?php echo get_template_directory_uri() ?>/assets/img/index/menu.svg" type="image/webp"><img src="<?php echo get_template_directory_uri() ?>/assets/img/index/menu.svg" class="cs-menu-ico" alt="">
                    </picture>
                </button>
            </div>
            <section class="cs-nav uk-animation-slide-top-medium" id="header-nav">
                <nav class="uk-flex uk-flex-wrap">
                    <?php
                    wp_nav_menu(
                        array(
                            'container' => false,
                            'menu' => '2',
                            'menu_class' => 'cs-nav__col',
                            //                        'container_class'     => 'cs-nav__col',
                        )
                    );
                    ?>
                    <?php
                    wp_nav_menu(
                        array(
                            'container' => false,
                            'menu' => '115',
                            'menu_class' => 'cs-nav__col',
                            //                        'container_class'     => 'cs-nav__col',
                        )
                    );
                    ?>

                    <?php
                    wp_nav_menu(
                        array(
                            'container' => false,
                            'menu' => '116',
                            'menu_class' => 'cs-nav__col',
                            //                        'container_class'     => 'cs-nav__col',
                        )
                    );
                    ?>
                </nav>
            </section>
        </section>
    </header>