<?php
get_header();
?>
<main>
    <div class="cs-container pt-29">
        <?php ds_back_link(); ?>
        <div class="news-more__wrap">
            <div class="news-more__content">
                <div class="soc-content__item soc-art__item  default-tags">
                    <div class="soc-date-art">
                        <?php the_date("d.m.Y h:m"); ?>
                    </div>
                    <h1 class="soc-art-h1"><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </div>
            </div>
            <?php get_template_part('template-parts/blocks/last-news'); ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>