<?php
global $post;
$postslist = get_posts([
    'post_type' => 'eb_course',
    'posts_per_page' => 4,
    'order' => 'ASC',
    'orderby' => 'ID'
]);
if (!empty($postslist)) :
?>
    <section class="courses cs-container">
        <h2 class="h2">Курсы ДПО</h2>

        <div class="uk-flex uk-flex-wrap courses__container" uk-scrollspy="target: > div; cls: uk-animation-slide-left-medium; delay: 200; offset-top: -300">
            <?php
            foreach ($postslist as $post) {
                setup_postdata($post);

                if (has_post_thumbnail()) {
                    $image_url = get_the_post_thumbnail_url();
                } else {
                    $image_url = get_stylesheet_directory_uri() . '/img/no_image_news.png';
                }
            ?>
                <div class="courses__item" style="background: url(<?php echo $image_url ?>) center center no-repeat">
                    <div class="courses__item_container">
                        <div>
                            <h3 class="courses__item_name"><?php the_title(); ?></h3>
                            <div class="courses__item_p">
                                <?php echo get_excerpt(140); ?>
                            </div>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="courses__item_a ico-arrRight-right">Подробнее</a>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </section>
<?php
endif;

wp_reset_postdata(); ?>