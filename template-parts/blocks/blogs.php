<?php
global $user_info, $user_info_meta;

if (isset($_GET["order"]) && !empty($_GET["order"])) {
    $args['order']   = esc_sql($_GET["order"]);
} else {
    $args['order']   = 'DESC';
}

$blogs = get_terms($args);
if ($blogs) :
    foreach ($blogs as $blog) {
        //m_p($blog);
        $author = get_field('blog_author', 'ds_blogs_' . $blog->term_id);
        $getTermsObject = get_the_terms($blog->term_id, 'ds_objects');
        $accessRead = check_accsess_blog('blog', $blog->term_id);
        //    m_p($author);
?>
        <div class="soc-content__item">
            <div class="soc-content__item_header">
                <div class="soc-content__item_avatar">
                    <picture><?php echo get_avatar($author["ID"]); ?></picture>
                </div>
                <div class="uk-flex-1">
                    <div class="uk-flex uk-flex-between uk-flex-middle soc-content__item_wrap">
                        <div class="soc-content__item_name"><?php echo $author["display_name"]; ?></div>
                    </div>
                    <div class="soc-content__item_sub">
                        создал <?php echo (!$accessRead) ? 'закрытый' : ''; ?> авторский блог
                    </div>
                </div>
            </div>

            <div class="soc-content__banner">
                <?php
                if (!empty($getTermsObject)) {
                ?>
                    <div class="soc-content__banner_label">Раздел “<?php echo $getTermsObject[0]->name ?>”</div>
                <?php } ?>
                <div class="soc-content__banner_img">
                    <picture><img src="<?php echo get_image_post($blog->term_id); ?>" alt="<?php echo $blog->name; ?>"></picture>
                </div>
                <?php if (!$accessRead) : ?><div class="soc-banner-blocked"></div><?php endif; ?>
            </div>
            <div class="soc-tags uk-flex uk-flex-wrap">
            </div>
            <div class="soc-content__title"><?php echo $blog->name; ?></div>
            <p class="soc-content__p">
                <?php echo $blog->description; ?>
            </p>

            <div class="uk-flex uk-flex-between uk-flex-middle soc-panel">
                <?php if (!$accessRead) : ?>
                    <a href="#" class="cs-btn-border btn btn-5" uk-toggle="target: #access">Запросить доступ</a>
                <?php else : ?>
                    <a href="<?php echo get_term_link($blog); ?>" class="cs-btn-border btn btn-5">Перейти в блог</a>
                <?php endif; ?>
            </div>
        </div>
    <?php
    }
else :
    ?>
    <div class="soc-content__item soc-content-thematic">
        Блоги не найдены!
    </div>
<?php
endif;
