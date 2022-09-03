<?php
get_header();
?>
<main>
    <div class="cs-container pt-29">
        <?php ds_back_link(); ?>
        <h1 class="reg-h1"><?php echo single_cat_title(); ?></h1>

        <?php get_search_form(); ?>

        <div class="uk-flex uk-flex-wrap uk-flex-between news-wrap">
            <?php
            if (have_posts()) {
                while (have_posts()) {
                    the_post(); ?>

                    <div class="news__item">
                        <div class="news__img">
                            <?php
                            if (has_post_thumbnail()) {
                                echo get_the_post_thumbnail(null, array(330, 225));
                            }
                            ?>
                        </div>
                        <div class="news__content">
                            <div class="news__date"><?php the_date("d.m.Y в h:i"); ?></div>
                            <p><strong><?php the_title(); ?></strong></p>
                            <p><?php echo get_excerpt(300); ?></p>
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
            <?php
            } ?>

        </div>
        <?php if (function_exists('wp_corenavi')) wp_corenavi(); ?>



    </div>
</main>
<?php get_footer(); ?>