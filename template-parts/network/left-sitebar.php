<?php
global $wp_query;
$user_info = wp_get_current_user();
?>
<section class="soc-ls">
    <div class="soc-ls-user uk-flex uk-flex-center uk-flex-column uk-flex-middle">
        <div class="soc-ls-user__img">
            <a href="/<?php echo URL_NETWORK ?>/user/"><?php echo get_avatar($user_info->ID); ?></a>
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
</section>