<?php
$argsProjects = array(
    'posts_per_page' => 8,
    'post_type' => 'post',
    'order' => 'ASC',
    'orderby' => 'date',
    'cat' => '91'
);
$mainProjects = new \WP_Query($argsProjects);
if ($mainProjects->have_posts()) {
?>
    <section class="projects cs-gray-bg">
        <div class="cs-container">
            <h2 class="h2">Проекты консорциума</h2>
            <div class="projects__container uk-flex uk-flex-wrap uk-flex-between" uk-scrollspy="cls:uk-animation-fade; offset-top: -200">
                <?php
                while ($mainProjects->have_posts()) {
                    $mainProjects->the_post();
                    $bg_img = '';
                    if (has_post_thumbnail()) {
                        $bg_img = get_the_post_thumbnail_url();
                    } else {
                        $bg_img = get_stylesheet_directory_uri() . '/img/no_image_news.png';
                    }

                ?>
                    <div class="projects__item" style="background: url(<?php echo $bg_img ?>)">
                        <a href="<?php the_permalink(); ?>" class="projects__link"><span><?php the_title(); ?></span></a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
<?php
} ?>