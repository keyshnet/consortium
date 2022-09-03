<?php
$argsNews = array(
    'posts_per_page' => 6,
    'post_type' => 'post',
    'cat' => '89'
);
$mainNews = new \WP_Query($argsNews);
if ($mainNews->have_posts()) {
?>
    <section class="news">
        <div class="cs-container">
            <h2 class="h2 news__h2">Новости</h2>
            <div class="uk-flex uk-flex-wrap uk-flex-between" uk-scrollspy="target: > div; cls: uk-animation-fade; delay: 100">
                <?php
                while ($mainNews->have_posts()) {
                    $mainNews->the_post();
                ?>
                    <div class="news__item">

                        <div class="news__img">
                            <picture>
                                <?php if (has_post_thumbnail()) {
                                    the_post_thumbnail();
                                } else {
                                    echo '<img src="' . get_stylesheet_directory_uri() . '/img/no_image_news.png">';
                                }
                                ?>
                            </picture>
                        </div>
                        <div class="news__content">
                            <div class="news__date"><?php the_time('d.m.Y'); ?></div>
                            <?php echo get_excerpt(140); ?>
                            <div class="news__tags uk-flex uk-flex-wrap">
                                <?php
                                if (get_the_tag_list()) {
                                    echo get_the_tag_list('<div class="news__tag-item">', '</div><div class="news__tag-item">', '</div>');
                                }
                                ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="link">Подробнее</a>
                        </div>
                    </div>
                <?php
                }
                ?>
                <div class="news__item" style="background: transparent"></div>
            </div>
            <div class="uk-text-center">
                <a href="<?php echo get_category_link(CAT_NEWS_ID) ?>" class="link-underline news__link-underline uk-text-center">Все новости</a>
            </div>
        </div>
    </section>
<?php
} ?>