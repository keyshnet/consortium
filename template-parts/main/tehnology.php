<?php
$tehnologii = 117;
?>
<section class="events cs-slider cs-gray-bg pt-35">
    <div class="cs-slider-banner">
        <div>
            <div class="cs-slider-banner__name">
                <?php echo get_cat_name($tehnologii) ?>
            </div>
            <p class="cs-slider-banner__p">
                <?php echo category_description($tehnologii) ?>
            </p>
        </div>
        <a href="<?php echo get_category_link($tehnologii) ?>" class="cs-btn btn btn-5">Все материалы</a>
    </div>
    <div class="events__slider-wrap">
        <div uk-slider>
            <div class="uk-position-relative" tabindex="-1">
                <div class="uk-slider-container">
                    <?php
                    $argsNews = array(
                        'posts_per_page' => 10,
                        'post_type' => 'post',
                        'cat' => '117'
                    );
                    $mainNews = new \WP_Query($argsNews);
                    if ($mainNews->have_posts()) {
                    ?>
                        <ul class="uk-slider-items uk-grid">
                            <?php
                            while ($mainNews->have_posts()) {
                                $mainNews->the_post();
                            ?>
                                <li class="events__slider-li">
                                    <div>
                                        <div class="events__date-label cs-slider-name">
                                            <?php echo the_title(); ?>
                                        </div>
                                        <p class="events__text">
                                            <?php echo get_excerpt(140); ?>
                                        </p>
                                    </div>
                                    <a href="<?php the_permalink() ?>" class="link">Подробнее</a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    <?php
                    }
                    ?>
                </div>
                <a class="uk-position-center-right uk-position-small" href="#" uk-slider-item="next">
                    <picture>
                        <source srcset="<?php echo get_template_directory_uri() ?>/assets/img/index/arr-right-red.svg" type="image/webp"><img src="<?php echo get_template_directory_uri() ?>/assets/img/index/arr-right-red.svg" alt="">
                    </picture>
                </a>
                </a>

            </div>
        </div>
    </div>
</section>