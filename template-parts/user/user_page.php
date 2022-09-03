<?php
global $user_info, $user_info_meta;
// m_p($user_info_meta);

if (!$user_info) :
?>
    <div class="soc-other-user">
        Такой пользователь не найден
    </div>
<?php
else :
?>
    <div class="soc-other-user">
        <?php if (ds_check_accsess('access_messanger', 'user_' . $user_info->ID)) : ?>
            <div class="soc-other-user__soc footer-soc uk-flex uk-flex-middle">
                <?php if (isset($user_info_meta["user_vk"][0])) : ?>
                    <a href="<?php echo $user_info_meta["user_vk"][0] ?>">
                        <picture>
                            <source srcset="<?php echo get_template_directory_uri() ?>/assets/img/vk.svg" type="image/webp"><img src="<?php echo get_template_directory_uri() ?>/assets/img/vk.svg" alt="">
                        </picture>
                    </a>
                <?php endif; ?>
                <?php if (isset($user_info_meta["user_fb"][0])) : ?>
                    <a href="<?php echo $user_info_meta["user_fb"][0] ?>">
                        <picture>
                            <source srcset="<?php echo get_template_directory_uri() ?>/assets/img/fb.svg" type="image/webp"><img src="<?php echo get_template_directory_uri() ?>/assets/img/fb.svg" alt="">
                        </picture>
                    </a>
                <?php endif; ?>
                <?php if (isset($user_info_meta["user_google"][0])) : ?>
                    <a href="<?php echo $user_info_meta["user_google"][0] ?>">
                        <picture>
                            <source srcset="<?php echo get_template_directory_uri() ?>/assets/img/google.svg" type="image/webp"><img src="<?php echo get_template_directory_uri() ?>/assets/img/vk.google" alt="">
                        </picture>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="soc-other-user__header">
            <div class="soc-other-user__img">
                <?php echo get_avatar($user_info->ID); ?>
            </div>
            <div>
                <div class="soc-other-user__name"><?php echo isset($user_info->data->display_name) ? $user_info->data->display_name : ""; ?></div>
                <?php if (isset($user_info_meta["user_role_blog"][0])) : ?>
                    <div class="soc-other-user__pos"><?php echo $user_info_meta["user_role_blog"][0]; ?></div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (wp_get_current_user()->ID !== $user_info->ID) { ?>
            <div class="soc-other-user__btn-group">
                <a href="/<?php echo URL_NETWORK ?>/messages/?new-message&to=<?php echo $user_info->user_login; ?>" class="cs-btn-border btn btn-5 ico-message-right">
                    Написать
                </a>
                <a href="" class="cs-btn-border btn btn-5 ico-add-right request_add_friends">
                    добавить в друзья
                </a>
                <i></i>
            </div>
        <?php } else { ?>
            <div class="soc-other-user__btn-group">
                <a href="?edit=Y" class="cs-btn-border btn btn-5 ico-edit-right">редактировать профиль</a>
            </div>
        <?php } ?>


        <div class="soc-other-user__content">
            <?php if (!empty($user_info_meta["user_phone"][0]) and ds_check_accsess('access_phone', 'user_' . $user_info->ID)) : ?>
                <p><b>Телефон:</b> <?php echo $user_info_meta["user_phone"][0]; ?></p>
            <?php endif; ?>
            <?php if (!empty($user_info->data->user_email) and ds_check_accsess('access_email', 'user_' . $user_info->ID)) : ?>
                <p><b>E-mail:</b> <?php echo $user_info->data->user_email; ?></p>
            <?php endif; ?>
            <?php if (!empty($user_info_meta["user_organization"][0])) : ?>
                <p><b>Организация:</b> <?php echo $user_info_meta["user_organization"][0]; ?></p>
            <?php endif; ?>
            <?php if (!empty($user_info_meta["user_rate"][0])) : ?>
                <p><b>Научная степень:</b> <?php echo $user_info_meta["user_rate"][0]; ?></p>
            <?php endif; ?>
            <?php if (isset($user_info_meta["ds_user_interest"]) and !empty($user_info_meta["ds_user_interest"])) : ?>
                <p><b>Сфера интересов:</b> <?php echo implode(',', $user_info_meta["ds_user_interest"]) ?></p>
            <?php endif; ?>
            <?php if (isset($user_info_meta["user_interest_note"][0]) and !empty($user_info_meta["user_interest_note"][0])) : ?>
                <p><b>Примечание к сфере интересов:</b> <?php echo $user_info_meta["user_interest_note"][0] ?></p>
            <?php endif; ?>
        </div>
    </div>

    <?php if (ds_check_accsess('access_list_blogs', 'user_' . $user_info->ID)) : ?>
        <?php
        $meta_query_blogs = array(
            'relation'        => 'OR',
            array(
                'key'        => 'access_read',
                'value'        => 'all',
                'compare'    => '='
            ),
            array(
                'relation'        => 'AND',
                array(
                    'key'        => 'access_read',
                    'value'        => 'users',
                    'compare'    => '='
                ),
                array(
                    'key'     => 'access_read_users',
                    'value'   => '"' . $user_info->ID . '"',
                    'compare' => 'LIKE',
                )
            )
        );
        $blogsRes = get_terms(array(
            'hide_empty'  => 0,
            'taxonomy'    => 'ds_blogs',
            'meta_query' => $meta_query_blogs
        ));
        if (!empty($blogsRes)) {
        ?>
            <h2 class="soc-other-user__label">Авторские блоги, доступные пользователю</h2>
            <div class="blogs">
                <?php
                foreach ($blogsRes as $blog) {
                    $getObject = get_field('subjet', 'ds_blogs_' . $blog->term_id);
                    $getObject = get_term($getObject);
                ?>
                    <div class="blogs__item">
                        <div>
                            <a href="<?php echo esc_url(get_term_link($blog)) ?>" class="link-underline"><?php echo $blog->name; ?></a>
                            <?php
                            if (!empty($getObject)) {
                            ?>
                                в тематическом разделе <a href="<?php echo esc_url(get_term_link($getObject)) ?>" class="link-underline"><?php echo $getObject->name ?></a>
                            <?php } ?>

                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        }
        ?>
    <?php endif; ?>


    <?php
    if (current_user_can('administrator')) {
        $subjRes = get_terms(array(
            'hide_empty'  => 0,
            'taxonomy'    => 'ds_objects',
        ));
        if (!empty($subjRes)) {
    ?>
            <div class="mb-25">
                <h2 class="soc-other-user__label">Модерация тематических разделов</h2>
                <?php
                foreach ($subjRes as $subj) {
                    $access_request = get_field('access_request', 'ds_objects_' . $subj->term_id);
                ?>
                    <div class="cs-accordion">
                        <div class="cs-accordion__label">
                            <h3><?php echo $subj->name; ?></h3>
                            <div class="uk-flex uk-flex-middle">
                                <button class="cs-accordion__btn ico-bell ghost-btn uk-position-relative cs-accordion-trigger"><?php if (!empty($access_request)) : ?><span class="cs-badge cs-badge-right-top-out"></span><?php endif; ?></button>
                                <button onclick="location.href='/<?php echo URL_NETWORK ?>/blog/?action=subject_settings&subject_id=<?php echo $subj->term_id; ?>';" class="cs-accordion__btn ico-settings ghost-btn uk-position-relative"></button>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (!empty($access_request)) {
                    ?>
                        <div class="cs-accordion__content uk-hidden">
                            <?php foreach ($access_request as $req) :
                                $req_user = get_userdata($req["req_user"]);
                                //                            m_p($req_user);
                            ?>
                                <div class="friends__my remove-flex">
                                    <div class="uk-flex uk-flex-middle uk-flex-between">
                                        <div class="friends__my_ls">
                                            <div class="friends__my_img">
                                                <picture>
                                                    <?php echo get_avatar($req_user); ?>
                                                </picture>
                                            </div>
                                            <div>
                                                <div class="friends__my_name"><?php echo $req_user->data->display_name; ?></div>
                                                <div>
                                                    <a href="#" class="soc-tags__item uk-margin-small-right">Чтение</a>
                                                </div>
                                                <button class="ghost-btn friends__btn-more friends__my_pos">Подробная информация</button>
                                            </div>
                                        </div>
                                        <div class="friends__my_rs">
                                            <a href="article.html" class="cs-btn-border btn btn-5 ico-plus-right">
                                                одобрить
                                            </a>
                                            <div>
                                                <button class="ghost-btn ico-message"></button>
                                                <button class="ghost-btn ico-remove"></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="soc-other-user__content friends-soc-other-user__content">
                                        <p>
                                            <b>Статус:</b>Профессор
                                        </p>
                                        <p>
                                            <b>Сфера интересов:</b> Международная юриспруденция
                                        </p>
                                        <p>
                                            <b>Обоснование заявки: </b> <?php echo $req["text_access"] ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
    <?php
        }
    }
    ?>


    <?php
    $myPostsArgs = array(
        'post_type' => 'ds_network',
        'posts_per_page' => 10,
        'author'   => '"' . $user_info->ID . '"',
        'ds_title' => 'Публикации пользователя'
    );
    ds_show_post_blog($myPostsArgs);
    ?>
    <script>
        $(document).ready(function($) {
            $(".request_add_friends").on('click', function() {
                var resPlace = $(this).next('i');
                update_field('friends_request', <?php echo wp_get_current_user()->ID ?>, 'user_<?php echo $user_info->ID ?>', resPlace, true);
                $(this).fadeOut(1000, function() {
                    $(this).remove();
                });
                return false;
            });
        })
    </script>

<?php
endif;
?>