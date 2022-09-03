<?php
global $user_info, $user_info_meta;
$friends = get_field('friends',  'user_' . $user_info->ID);
?>
<section class="soc-rs friends">
    <h3>Друзья пользователя</h3>
    <?php

    if (!empty($friends)) :
        $users = get_users([
            'include'    => get_field('friends',  'user_' . $user_info->ID),
            'fields'       => array('ID', 'display_name', 'user_login'),
        ]);
        foreach ($users as $user) {
    ?>
            <div class="read-now-item">
                <div class="friends__img"><a href="/<?php echo URL_NETWORK ?>/user/<?php echo $user->user_login; ?>/"><?php echo get_avatar($user->ID); ?></a></div>
                <div class="friends__name"><?php echo $user->display_name; ?></div>
            </div>
        <?php
        }
    else :
        ?>
        <div class="read-now-item">
            Тут пока нет друзей!
        </div>
    <?php endif; ?>
</section>