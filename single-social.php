<?php

/**
 * The template for displaying all pages.
 *
 * @package Neve
 * @since   1.0.0
 */

get_header();

$getTermsBlog = get_the_terms(get_the_ID(), 'ds_blogs');
$getTermsObject = get_the_terms(get_the_ID(), 'ds_objects');
$accessRead = check_accsess_blog('blog', $getTermsBlog[0]->term_id);
?>
<div class="milky-bg">
    <div class="uk-flex uk-flex-between cs-container soc-main-container">
        <?php get_template_part('template-parts/network/left-sitebar'); ?>
        <section class="soc-content">
            <?php
            if ($accessRead) :
            ?>
                <div class="soc-content__item soc-art__item ">
                    <?php
                    if (have_posts()) {
                        while (have_posts()) {
                            the_post(); ?>
                            <div class="uk-flex uk-flex-between uk-flex-middle">
                                <a href="#" class="back-link" onClick="history.back(); return false;">назад</a>
                                <div class="soc-date-art">
                                    <?php the_date("d.m.Y h:i"); ?>
                                </div>
                            </div>

                            <div class="soc-content__item_header soc-art-header">
                                <?php
                                $author = get_the_author(); //echo '<a href="'. $url . '">'. $author .'</a>';
                                ?>
                                <div class="soc-art__avatar">
                                    <?php echo get_avatar(get_the_author_meta("ID")); ?>
                                </div>
                                <div class="soc-content__item_name"><?php echo $author; ?></div>

                            </div>

                            <div class="soc-art__info">
                                <?php
                                ?>
                                <?php if (!empty($getTermsBlog)) : ?>
                                    <p>Авторский блог: <a href="<?php echo get_term_link($getTermsBlog[0]->slug, 'ds_blogs'); ?>"><?php echo $getTermsBlog[0]->name ?></a></p>
                                <?php endif ?>
                                <?php if (!empty($getTermsObject)) : ?>
                                    <p>Тематический раздел: <a href="<?php echo get_term_link($getTermsObject[0]->slug, 'ds_objects'); ?>"><?php echo $getTermsObject[0]->name ?></a></p>
                                <?php endif ?>
                            </div>

                            <h1 class="soc-art-h1"><?php the_title(); ?></h1>

                            <?php
                            if (has_post_thumbnail()) {
                            ?>
                                <div class="soc-art-img">
                                    <picture><img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>"></picture>
                                </div>
                            <?php
                            }
                            ?>
                            <div class=" default-tags">
                                <?php the_content(); ?>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>

                <?php
                if (comments_open() || get_comments_number()) {
                    comments_template();
                }
                ?>
            <?php else : ?>
                <?php ds_back_link(); ?>
                <div class="soc-other-user">
                    У вас нет доступа к этому блогу!
                </div>
            <?php endif; ?>
        </section>

        <?php get_template_part('template-parts/network/right-sitebar'); ?>
    </div>
</div>
<?php get_footer(); ?>