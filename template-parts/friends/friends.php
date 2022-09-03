<?php
global $user_info, $user_info_meta;
if (isset($_GET['search'])) {
    get_template_part('template-parts/friends/search_friends');
} else {
    $friends = get_field('friends',  'user_' . $user_info->ID);
    $friends_request = get_field('friends_request',  'user_' . $user_info->ID);
?>
    <h1 class="friends__h1"><?php the_title(); ?></h1>

    <?php get_template_part('template-parts/friends/search_friends_block', null, array('use_filter' => false)); ?>

    <div class="friends__tabs">
        <ul class="uk-subnav" uk-switcher="animation: uk-animation-fade;">
            <li><a href="#">Мой список друзей</a></li>
            <li class="uk-position-relative">
                <a href="#">Заявки в друзья</a>
                <?php if (!empty($friends_request)) : ?>
                    <span class="cs-badge cs-badge-right-top-out cs-badge-mini"></span>
                <?php endif; ?>
            </li>
        </ul>
        <ul class="uk-switcher uk-margin">
            <li>
                <?php

                if (!empty($friends)) :
                    $users = get_users([
                        'include'    => get_field('friends',  'user_' . $user_info->ID),
                        'fields'       => array('ID', 'display_name', 'user_email', 'user_login'),
                    ]);
                    foreach ($users as $user) {
                        $user_meta = get_user_meta($user->ID);
                ?>
                        <div class="friends__my remove-flex  friends-user-block">
                            <div class="uk-flex uk-flex-middle uk-flex-between">
                                <div class="friends__my_ls">
                                    <div class="friends__my_img"><a href="/<?php echo URL_NETWORK ?>/user/<?php echo $user->user_login; ?>/"><?php echo get_avatar($user->ID); ?></a></div>
                                    <div>
                                        <div class="friends__my_name"><?php echo $user->display_name; ?></div>
                                        <button class="ghost-btn friends__btn-more friends__my_pos">Подробная информация</button>
                                    </div>
                                </div>
                                <div class="friends__my_rs">
                                    <i style="margin-right: 10px"></i>
                                    <a href="/<?php echo URL_NETWORK ?>/messages/?new-message&to=<?php echo $user->user_login; ?>" class="cs-btn-border btn btn-5 ico-message-right">
                                        Написать
                                    </a>

                                    <a href="#" data-user="<?php echo $user->ID; ?>" title="Удалить из друзей" class="ghost-btn ico-remove remove_friend">
                                    </a>
                                </div>
                            </div>
                            <div class="soc-other-user__content friends-soc-other-user__content">
                                <?php if (!empty($user_meta["user_phone"][0]) and ds_check_accsess('access_phone', 'user_' . $user->ID)) : ?>
                                    <p><b>Телефон:</b> <?php echo $user_meta["user_phone"][0]; ?></p>
                                <?php endif; ?>
                                <?php if (!empty($user->user_email) and ds_check_accsess('access_email', 'user_' . $user->ID)) : ?>
                                    <p><b>E-mail:</b> <?php echo $user->user_email; ?></p>
                                <?php endif; ?>
                                <?php if (!empty($user_meta["user_organization"][0])) : ?>
                                    <p><b>Организация:</b> <?php echo $user_meta["user_organization"][0]; ?></p>
                                <?php endif; ?>
                                <?php if (!empty($user_meta["user_role_blog"][0])) : ?>
                                    <p><b>Статус:</b> <?php echo $user_meta["user_role_blog"][0]; ?></p>
                                <?php endif; ?>
                                <?php if (isset($user_meta["ds_user_interest"]) and !empty($user_meta["ds_user_interest"])) : ?>
                                    <p><b>Сфера интересов:</b> <?php echo implode(',', $user_meta["ds_user_interest"]) ?></p>
                                <?php endif; ?>
                                <?php if (isset($user_meta["user_interest_note"][0]) and !empty($user_meta["user_interest_note"][0])) : ?>
                                    <p><b>Примечание к сфере интересов:</b> <?php echo $user_meta["user_interest_note"][0] ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php
                    }
                else :
                    ?>
                    <div class="friends__my remove-flex">
                        Друзей не найдено!
                    </div>
                <?php endif; ?>
            </li>
            <li>
                <?php
                if (!empty($friends_request)) :
                    $users = get_users([
                        //            'role'         => 'authors',
                        'include'    => get_field('friends_request',  'user_' . $user_info->ID),
                        'fields'       => array('ID', 'display_name', 'user_email', 'user_login'),
                    ]);
                    foreach ($users as $user) {
                        $user_meta = get_user_meta($user->ID);
                ?>
                        <div class="friends__my remove-flex friends-user-block">
                            <div class="uk-flex uk-flex-middle uk-flex-between">
                                <div class="friends__my_ls">
                                    <div class="friends__my_img"><?php echo get_avatar($user->ID); ?></div>
                                    <div>
                                        <div class="friends__my_name"><?php echo $user->display_name; ?></div>
                                        <button class="ghost-btn friends__btn-more friends__my_pos">Подробная информация</button>
                                    </div>
                                </div>
                                <div class="friends__my_rs">
                                    <i style="margin-right: 10px"></i>
                                    <a href="#" data-user="<?php echo $user->ID; ?>" class="cs-btn-border btn btn-5 ico-plus-right add_friend">
                                        принять
                                    </a>
                                    <div class="uk-flex">
                                        <a href="/<?php echo URL_NETWORK ?>/messages/?new-message&to=<?php echo $user->user_login; ?>" class="btn-search bg-reset uk-flex uk-flex-center uk-flex-middle ico-message" title="Отправить сообщение">
                                        </a>
                                        <a href="#" data-user="<?php echo $user->ID; ?>" title="Отказаться" class="ghost-btn ico-remove request_remove_friend">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="soc-other-user__content friends-soc-other-user__content">
                                <?php if (!empty($user_meta["user_phone"][0]) and ds_check_accsess('access_phone', 'user_' . $user->ID)) : ?>
                                    <p><b>Телефон:</b> <?php echo $user_meta["user_phone"][0]; ?></p>
                                <?php endif; ?>
                                <?php if (!empty($user->user_email) and ds_check_accsess('access_email', 'user_' . $user->ID)) : ?>
                                    <p><b>E-mail:</b> <?php echo $user->user_email; ?></p>
                                <?php endif; ?>
                                <?php if (!empty($user_meta["user_organization"][0])) : ?>
                                    <p><b>Организация:</b> <?php echo $user_meta["user_organization"][0]; ?></p>
                                <?php endif; ?>
                                <?php if (!empty($user_meta["user_role_blog"][0])) : ?>
                                    <p><b>Статус:</b> <?php echo $user_meta["user_role_blog"][0]; ?></p>
                                <?php endif; ?>
                                <?php if (isset($user_meta["ds_user_interest"]) and !empty($user_meta["ds_user_interest"])) : ?>
                                    <p><b>Сфера интересов:</b> <?php echo implode(',', $user_meta["ds_user_interest"]) ?></p>
                                <?php endif; ?>
                                <?php if (isset($user_meta["user_interest_note"][0]) and !empty($user_meta["user_interest_note"][0])) : ?>
                                    <p><b>Примечание к сфере интересов:</b> <?php echo $user_meta["user_interest_note"][0] ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php
                    }
                else :
                    ?>
                    <div class="friends__my remove-flex">
                        Заявок пока нет!
                    </div>
                <?php endif; ?>
            </li>
        </ul>
    </div>
    <script>
        $(document).ready(function($) {
            $(".add_friend").on('click', function() {
                var resPlace = $(this).parent().find('i');
                update_field('friends', $(this).data('user'), 'user_<?php echo wp_get_current_user()->ID ?>', resPlace, true);
                update_field('friends', <?php echo wp_get_current_user()->ID ?>, 'user_' + $(this).data('user'), resPlace, true);
                update_field('friends_request', $(this).data('user'), 'user_<?php echo wp_get_current_user()->ID ?>', resPlace, false, true);
                $(this).parents('.friends-user-block').fadeOut(2000, function() {
                    $(this).remove();
                });
                return false;
            });
            $(".request_remove_friend").on('click', function() {
                var resPlace = $(this).parent().find('i');
                update_field('friends_request', $(this).data('user'), 'user_<?php echo wp_get_current_user()->ID ?>', resPlace, false, true);
                $(this).parents('.friends-user-block').fadeOut(2000, function() {
                    $(this).remove();
                });
                return false;
            });
            $(".remove_friend").on('click', function() {
                var resPlace = $(this).parent().find('i');
                update_field('friends', $(this).data('user'), 'user_<?php echo wp_get_current_user()->ID ?>', resPlace, false, true);
                update_field('friends', <?php echo wp_get_current_user()->ID ?>, 'user_' + $(this).data('user'), resPlace, false, true);
                $(this).parents('.friends-user-block').fadeOut(2000, function() {
                    $(this).remove();
                });
                return false;
            });
        })
    </script>
<?php
}
?>