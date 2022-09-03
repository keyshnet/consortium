<?php
$argsCalendar = array(
    'posts_per_page' => 20,
    'post_type' => 'post',
    'cat' => '90'
);
$mainCalendar = new \WP_Query($argsCalendar);
if ($mainCalendar->have_posts()) {
?>
    <section class="events">
        <h2 class="h2">Календарь мероприятий</h2>
        <div class="events__slider-wrap">
            <div uk-slider>
                <div class="uk-position-relative" tabindex="-1">
                    <div class="uk-slider-container">

                        <ul class="uk-slider-items uk-grid">
                            <?php
                            while ($mainCalendar->have_posts()) {
                                $mainCalendar->the_post();
                            ?>
                                <li class="events__slider-li">
                                    <div>
                                        <div class="events__date-label"><?php the_field('start_date');
                                                                        if (get_field('end_date')) { ?> - <?php the_field('end_date');
                                                                                                                                    } ?></div>
                                        <p class="events__label"><?php the_title(); ?></p>
                                        <p class="events__text">
                                            <?php echo get_excerpt(250); ?>
                                        </p>
                                    </div>
                                    <a href="<?php the_permalink(); ?>" class="link">Подробнее</a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>

                    <a class="uk-position-center-left-out uk-position-small" href="#" uk-slider-item="previous">
                        <picture>
                            <source srcset="<?php echo get_template_directory_uri() ?>/assets/img/index/sl-arr-right.svg" type="image/webp"><img src="<?php echo get_template_directory_uri() ?>/assets/img/index/sl-arr-right.svg" alt="">
                        </picture>
                    </a>
                    <a class="uk-position-center-right-out uk-position-small" href="#" uk-slider-item="next"></a>

                </div>
            </div>
        </div>
    </section>
<?php
} ?>