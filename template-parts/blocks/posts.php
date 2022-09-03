<?php
if (isset($_GET["orderby"]) && !empty($_GET["orderby"])) {
    $args['orderby']   = esc_sql($_GET["orderby"]);
} else {
    $args['orderby']   = 'date';
}
if (isset($_GET["order"]) && !empty($_GET["order"])) {
    $args['order']   = esc_sql($_GET["order"]);
} else {
    $args['order']   = 'DESC';
}
if (isset($_GET["subj"]) && !empty($_GET["subj"])) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'ds_objects',
            'terms'    => esc_sql($_GET["subj"])
        )
    );
}
if (isset($_GET["search"]) && !empty($_GET["search"])) {
    $args['s'] = esc_sql($_GET["search"]);
}
if (isset($_GET["interest"]) && !empty($_GET["interest"])) {
    $meta_query = array(
        array(
            'key' => 'interest',
            'value' => esc_sql($_GET["interest"]),
            'compare' => 'LIKE'
        )
    );
    $args['meta_query'] = $meta_query;
}

$myPosts = new WP_Query($args);
//m_p($args);
if ($myPosts->have_posts()) :
    $getInterestValue = get_field_object('user_interest');
    $postFavorites = (array)get_field('favorites_posts', 'user_' . wp_get_current_user()->ID);
    $editPost = (isset($args['ds_edit']) && $args['ds_edit'] == "Y") ? true : false;


    echo $args['ds_title'] ? '<h2 class="soc-other-user__label">' . $args['ds_title'] . '</h2>' : '';

    while ($myPosts->have_posts()) :
        $myPosts->the_post();
        $getTermsBlog = get_the_terms(get_the_ID(), 'ds_blogs');
        $getTermsObject = get_the_terms(get_the_ID(), 'ds_objects');
        $getInterestValue = get_field_object('interest');
        $interests = $getInterestValue['value'] ?? '';
        $post_views = (int)get_post_meta(get_the_ID(), 'views', true);
        $accessRead = check_accsess_blog('blog', $getTermsBlog[0]->term_id);

        $show_post = ((isset($_GET["show_hidden"]) && $_GET["show_hidden"] == "Y") or $accessRead) ? true : false;
        if (!$show_post)
            continue;

        $countFavs = ds_count_favorites(get_the_ID());
?>
        <div class="soc-content__item">
            <div class="soc-content__item_header">
                <div class="soc-content__item_avatar">
                    <a href="/<?php echo URL_NETWORK ?>/user/<?php echo get_the_author_meta("login"); ?>/"><?php echo get_avatar(get_the_author_meta("ID")); ?></a>
                </div>
                <div class="uk-flex-1">
                    <div class="uk-flex uk-flex-between uk-flex-middle soc-content__item_wrap">
                        <div class="soc-content__item_name"><?php the_author(); ?></div>
                        <div class="soc-content__item_date"><?php the_date("d.m.Y в h:i"); ?></div>
                    </div>
                    <?php
                    if (!empty($getTermsBlog)) {
                    ?>
                        <div class="soc-content__item_sub">
                            добавил публикацию в <?php echo (!$accessRead) ? 'закрытый' : ''; ?> авторский блог <a href="<?php echo get_term_link($getTermsBlog[0]->slug, 'ds_blogs'); ?>"><?php echo $getTermsBlog[0]->name ?></a>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="soc-content__banner">
                <?php
                if (!empty($getTermsObject)) {
                ?>
                    <div class="soc-content__banner_label">Раздел “<?php echo $getTermsObject[0]->name ?>”</div>
                <?php } ?>
                <button class="bookmark-btn soc-content__banner_btn <?php echo (in_array(get_the_ID(), $postFavorites) ? 'bookmark-btn-active' : '') ?> ajax_add_fav_post" data-postid="<?php echo get_the_ID(); ?>" data-user="user_<?php echo wp_get_current_user()->ID ?>"></button>
                <!--            <button class="bookmark-btn bookmark-btn-active soc-content__banner_btn"></button>-->
                <div class="soc-content__banner_img">
                    <picture><img src="<?php echo get_image_post(get_the_ID()); ?>" alt="<?php echo the_title(); ?>"></picture>
                </div>
                <?php if (!$accessRead) : ?><div class="soc-banner-blocked"></div><?php endif; ?>
            </div>
            <div class="soc-tags uk-flex uk-flex-wrap">
                <?php if (!empty($interests)) : ?>
                    <?php foreach ($interests as $interest) : ?>
                        <a href="<?php echo add_query_arg(['interest' => $interest]) ?>" class="soc-tags__item uk-margin-small-right"><?php echo $interest; ?></a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>


            <div class="soc-content__title"><?php echo the_title(); ?></div>
            <p class="soc-content__p">
                <?php echo strip_tags(get_the_excerpt()); ?>
            </p>

            <div class="uk-flex uk-flex-between uk-flex-middle soc-panel">
                <?php if (!$accessRead) : ?>
                    <a href="#" class="cs-btn-border btn btn-5" uk-toggle="target: #access">Запросить доступ</a>
                <?php else : ?>
                    <?php if ($editPost) : ?>
                        <a href="/<?php echo URL_NETWORK ?>/blog/?action=post_edit&post_id=<?php echo get_the_ID(); ?>" class="cs-btn-border btn btn-5 ico-edit1-right">Редактировать</a>
                    <?php else : ?>
                        <a href="<?php the_permalink(); ?>" class="cs-btn-border btn btn-5">Перейти</a>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="uk-flex uk-flex-between uk-flex-middle">
                    <div class="uk-flex uk-flex-middle soc-info__item">
                        <picture>
                            <source srcset="<?php echo get_template_directory_uri() ?>/assets/img/soc/eye1.svg" type="image/webp"><img src="<?php echo get_template_directory_uri() ?>/assets/img/soc/eye1.svg" alt="">
                        </picture>
                        <span><?php echo $post_views; ?></span>
                    </div>

                    <div class="uk-flex uk-flex-middle soc-info__item">
                        <picture>
                            <source srcset="<?php echo get_template_directory_uri() ?>/assets/img/soc/comment1.svg" type="image/webp"><img src="<?php echo get_template_directory_uri() ?>/assets/img/soc/comment1.svg" alt="">
                        </picture>
                        <span><?php echo get_comments_number(); ?></span>
                    </div>

                    <div class="uk-flex uk-flex-middle soc-info__item">
                        <picture>
                            <source srcset="<?php echo get_template_directory_uri() ?>/assets/img/soc/zak.svg" type="image/webp"><img src="<?php echo get_template_directory_uri() ?>/assets/img/soc/zak.svg" alt="">
                        </picture>
                        <span><?php echo $countFavs; ?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php
    endwhile;
else :
    ?>
    <div class="friends__my remove-flex">
        Публикаций не найдено!
    </div>
<?php endif;
wp_reset_query();
