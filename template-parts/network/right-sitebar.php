<?php
$lastNewsArgs = array(
    'post_type' => 'ds_network',
    'posts_per_page' => 10,
);

$lastNews = new WP_Query($lastNewsArgs);

if ($lastNews->have_posts()) :
?>
    <section class="soc-rs">
        <h3>Читают сейчас:</h3>
        <?php
        while ($lastNews->have_posts()) :
            $lastNews->the_post();
            $post_views = (int)get_post_meta(get_the_ID(), 'views', true);
        ?>
            <div class="read-now-item">
                <div class="read-now-item__date"><?php echo get_the_date("d.m.Y в h:i"); ?></div>
                <a href="<?php the_permalink(); ?>" class="read-now-item__title"><?php echo the_title(); ?></a>
                <div class="uk-flex uk-flex-middle">
                    <div class="uk-flex uk-flex-middle">
                        <picture>
                            <source srcset="<?php echo get_template_directory_uri() ?>/assets/img/soc/eye.svg" type="image/webp"><img src="<?php echo get_template_directory_uri() ?>/assets/img/soc/eye.svg" alt="">
                        </picture>
                        <span class="sub-info"><?php echo $post_views; ?></span>
                    </div>
                    <div class="uk-flex uk-flex-middle uk-margin-small-left">
                        <picture>
                            <source srcset="<?php echo get_template_directory_uri() ?>/assets/img/soc/comment.svg" type="image/webp"><img src="<?php echo get_template_directory_uri() ?>/assets/img/soc/comment.svg" alt="">
                        </picture>
                        <span class="sub-info"><?php echo $post_views; ?></span>
                    </div>
                </div>
            </div>

        <?php
        endwhile;
        ?>
    </section>
<?php
endif;
wp_reset_query();
?>