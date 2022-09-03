<?php
$confs = get_posts($args);
//m_p($myPosts);
if ($confs) :

    echo $args['ds_title'] ? '<h2 class="settings__h1 mb-20 mt-40">' . $args['ds_title'] . '</h2>' : '';

    foreach ($confs as $post) :
        setup_postdata($post);
        $users = (array)get_field('conf_users', get_the_ID());
        $userArrInfo = array();
        foreach ($users as $user) {
            $userArr = get_userdata($user);
            $userArrInfo[] = '<a href="/' . URL_NETWORK . '/user/' . $userArr->data->user_login . '/">' . $userArr->data->display_name . '</a>';
        }

        $conf_time = (array)get_field('conf_time', get_the_ID());
?>
        <div class="conferention__plan">
            <div class="soc-content__item_header">
                <div class="soc-content__item_avatar">
                    <a href="/<?php echo URL_NETWORK ?>/user/<?php echo get_the_author_meta("login"); ?>/"><?php echo get_avatar(get_the_author_meta("ID")); ?></a>
                </div>
                <div class="uk-flex-1">
                    <div class="uk-flex uk-flex-between uk-flex-middle soc-content__item_wrap">
                        <div class="soc-content__item_name"><?php the_author(); ?></div>
                        <div class="soc-content__item_date"><?php the_date("d.m.Y в h:i"); ?></div>
                    </div>
                    <div class="soc-content__item_sub">
                        создал видеоконференцию
                    </div>
                </div>
            </div>
            <div class="soc-conf">
                <?php if (!empty($userArrInfo)) : ?>
                    <p class="soc-p"><b>Участники: </b> <?php echo implode(', ', $userArrInfo) ?></p>
                <?php endif; ?>
                <?php if (!empty($conf_time)) : ?>
                    <p class="soc-p"><b>Запланировано на: </b> <?php echo $conf_time[0]; ?></p>
                <?php endif; ?>
                <p class="soc-p"><b>Тематика: </b> <?php echo the_title(); ?></p>
                <?php if (!empty(get_the_content())) : ?>
                    <p class="soc-p"><b>Краткое описание: </b> <?php echo strip_tags(get_the_content()); ?></p>
                <?php endif; ?>
                <?php if (!empty(get_the_excerpt())) : ?>
                    <p class="soc-p"><b>Ссылка: </b><a target="_blank" href="<?php echo strip_tags(get_the_excerpt()); ?>"><?php echo strip_tags(get_the_excerpt()); ?></a></p>
                <?php endif; ?>
            </div>
        </div>
    <?php
    endforeach;
else :
    ?>
    <div class="friends__my remove-flex">
        Пока нет онференций!
    </div>
<?php endif;
wp_reset_postdata();
