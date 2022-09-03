<?php

/**
 * Index template.
 *
 * Template name: Главная страница
 */

?>
<?php
get_header();
?>
<section class="cs-top-banner">
    <div class="cs-top-border">
        <div class="cs-top-banner__img uk-animation-slide-right-medium">
            <picture>
                <?php if (has_post_thumbnail()) {
                    echo get_the_post_thumbnail(false, 'full', array('alt' => get_the_title()));
                } else {
                    echo '<img src="' . get_stylesheet_directory_uri() . '/img/no_image_news.png">';
                }
                ?>
            </picture>
        </div>
        <div class="cs-top-banner__content uk-animation-slide-left">
            <?php the_content(); ?>
            <a href="<?php the_permalink(1007) ?>" class="cs-btn cs-top-banner__btn btn btn-5">подробнее</a>
        </div>
    </div>
</section>

<?php get_template_part('template-parts/main/news'); ?>
<?php get_template_part('template-parts/main/calendar'); ?>
<?php get_template_part('template-parts/main/projects'); ?>
<?php get_template_part('template-parts/main/members'); ?>
<?php get_template_part('template-parts/main/form-enter'); ?>
<?php get_template_part('template-parts/main/courses'); ?>
<?php get_template_part('template-parts/main/article'); ?>
<?php get_template_part('template-parts/main/tehnology'); ?>
<?php get_template_part('template-parts/main/article-bot'); ?>


<?php
get_footer();
