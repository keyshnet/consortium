<?php
get_header();
?>
<main>
    <div class="cs-container pt-29">
        <?php ds_back_link(); ?>
        <h1 class="reg-h1"><?php echo single_cat_title(); ?></h1>

        <?php get_search_form(); ?>

        <div class="modern-tech__content">
            <?php
            if (have_posts()) {
                while (have_posts()) {
                    the_post(); ?>
                    <div class="events__slider-li modern-tech__item">
                        <div>
                            <div class="events__date-label cs-slider-name">
                                <?php the_title(); ?>
                            </div>
                            <p class="events__text">
                                <?php echo get_excerpt(200); ?>
                            </p>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="link">Подробнее</a>
                    </div>
            <?php
                }
            } ?>

        </div>
        <?php if (function_exists('wp_corenavi')) wp_corenavi(); ?>



    </div>
</main>
<?php get_footer(); ?>