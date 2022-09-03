<?php
global $user_info, $user_info_meta;
$friends = get_field('friends',  'user_' . $user_info->ID);
$searchArr = array(
    'fields'       => array('ID', 'display_name', 'user_email', 'user_login'),
    'exclude'       => array($user_info->ID)
);
$meta_query = array('relation' => 'OR');
$use_filter = false;

if (isset($_GET["search"]) && !empty($_GET["search"])) {
    $searchArr['search'] = '*' . esc_sql($_GET["search"]) . '*';
    //    $searchArr['meta_key'] = 'user_phone';
    //    $searchArr['meta_value'] = esc_sql($_GET["search"]);
    //    $searchArr['meta_compare'] = 'LIKE';
    //    $meta_query[] = array(
    //        'key' => 'user_phone',
    //        'value'    => esc_sql($_GET["search"]),
    //        'compare'    => 'LIKE'
    //    );
}
if (isset($_GET["user_organization"]) && !empty($_GET["user_organization"])) {
    $meta_query[] = array(
        'key' => 'user_organization',
        'value'    => esc_sql($_GET["user_organization"])
    );
}
if (isset($_GET["user_rate"]) && !empty($_GET["user_rate"])) {
    $meta_query[] = array(
        'key' => 'user_rate',
        'value'    => esc_sql($_GET["user_rate"])
    );
}
if (isset($_GET["user_role_blog"]) && !empty($_GET["user_role_blog"])) {
    $meta_query[] = array(
        'key' => 'user_role_blog',
        'value'    => esc_sql($_GET["user_role_blog"])
    );
}
//if(isset($_GET["user_interest"]) && !empty($_GET["user_interest"])){
//    $meta_query[] = array(
//        'key' => 'user_interest',
//        'value'    => esc_sql($_GET["user_interest"]),
////        'compare'   => 'IN',
//    );
//}

if (!empty($meta_query)) {
    $searchArr['meta_query'] = $meta_query;
}
if (!empty($_GET)) {
    $use_filter = true;
}
?>
<h1 class="friends__h1"><?php the_title(); ?></h1>

<?php get_template_part('template-parts/friends/search_friends_block', null, array('use_filter' => $use_filter)); ?>

<div class="friends__tabs">
    <?php
    if ((isset($_GET["in_friends"]) && $_GET["in_friends"] == "Y") && !empty($friends)) :
        $searchArrFriends['include'] = get_field('friends',  'user_' . $user_info->ID);
        $users = get_users(array_merge($searchArr, $searchArrFriends));
        if (!empty($users)) :
            echo '<h3 class="friends__h3">Среди моих друзей</h3>';
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
        endif;
    endif; ?>
    <h3 class="friends__h3 uk-margin-medium-top">Глобальный поиск</h3>
    <?php
    $searchArr['exclude'] = array_merge($searchArr['exclude'], $friends);
    $users = get_users($searchArr);
    if (!empty($users)) :
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
                        <a href="#" data-user="<?php echo $user->ID; ?>" class="cs-btn-border btn btn-5 ico-add-right request_add_friend">
                            добавить в друзья
                        </a>
                        <div class="uk-flex">
                            <a href="/<?php echo URL_NETWORK ?>/messages/?new-message&to=<?php echo $user->user_login; ?>" class="btn-search bg-reset uk-flex uk-flex-center uk-flex-middle ico-message" title="Отправить сообщение">
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
            Пользователей не найдено!
        </div>
    <?php endif; ?>
</div>
<script>
    $(document).ready(function($) {
        $(".remove_friend").on('click', function() {
            var resPlace = $(this).parent().find('i');
            update_field('friends', $(this).data('user'), 'user_<?php echo wp_get_current_user()->ID ?>', resPlace, false, true);
            update_field('friends', <?php echo wp_get_current_user()->ID ?>, 'user_' + $(this).data('user'), resPlace, false, true);
            $(this).parents('.friends-user-block').fadeOut(2000, function() {
                $(this).remove();
            });
            return false;
        });
        $(".request_add_friend").on('click', function() {
            var resPlace = $(this).parent().find('i');
            update_field('friends_request', <?php echo wp_get_current_user()->ID ?>, 'user_' + $(this).data('user'), resPlace, true);
            $(this).fadeOut(1000, function() {
                $(this).remove();
            });
            return false;
        });
    })
</script>