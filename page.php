<?php
get_header();
?>
<main>
    <div class="cs-container pt-29">
        <?php ds_back_link(); ?>

        <div class="news-more__wrap event">
            <div class="news-more__content">
                <div class="soc-content__item soc-art__item  default-tags">
                    <h1 class="soc-art-h1"><?php the_title() ?></h1>
                    <?php
                    the_content();
                    ?>
                </div>
            </div>


        </div>
    </div>
</main>

<?php
get_footer();
