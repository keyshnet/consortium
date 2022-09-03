<section class="doubles doubles-second">
    <?php
    $network = get_post(1503);
    ?>
    <div class="doubles__item doubles__flex-end pr-40">
        <div class="doubles__content" uk-scrollspy="cls:uk-animation-slide-left-medium;">
            <div class="doubles__name"><?php echo $network->post_title ?></div>
            <div class="doubles__p">
                <?php echo $network->post_excerpt ?>
            </div>
            <a href="<?php the_permalink($network) ?>" class="cs-btn btn btn-5 mt-78">Подробнее</a>
        </div>
        <div class="red-line" uk-scrollspy="cls:uk-animation-slide-left-medium;">
            <div class="doubles__img doubles__img_d4">
                <picture>
                    <?php if (has_post_thumbnail($network->ID)) {
                        echo get_the_post_thumbnail($network->ID, 'full', array('alt' => $network->post_title));
                    } else {
                        echo '<img src="' . get_stylesheet_directory_uri() . '/img/no_image_news.png">';
                    }
                    ?>
                </picture>
            </div>
        </div>
    </div>

    <div class="doubles__item cs-gray-bg doubles__right-align">
        <div class="mt-32 hor-line" uk-scrollspy="cls:uk-animation-slide-left-medium; offset-top: -300">
            <?php
            $fumo = get_post(47);
            ?>
            <div class="doubles__img doubles__img_d5">
                <picture>
                    <?php if (has_post_thumbnail($fumo->ID)) {
                        echo get_the_post_thumbnail($fumo->ID, 'full', array('alt' => $fumo->post_title));
                    } else {
                        echo '<img src="' . get_stylesheet_directory_uri() . '/img/no_image_news.png">';
                    }
                    ?>
                </picture>
            </div>
        </div>
        <div class="doubles__content" uk-scrollspy="cls:uk-animation-slide-right-medium; offset-top: -300">
            <div class="doubles__name"><?php echo $fumo->post_title ?></div>
            <div class="doubles__p">
                <?php echo $fumo->post_excerpt ?>
            </div>
            <a href="<?php the_permalink($fumo) ?>" class="cs-btn btn btn-5 mt-50">подробнее</a>
        </div>
    </div>

    <?php
    $teacher = get_post(49);
    ?>
    <div class="doubles__item doubles__flex-end">
        <div class="doubles__content" uk-scrollspy="cls:uk-animation-slide-left-medium; offset-top: -300">
            <div class="doubles__name"><?php echo $teacher->post_title ?>‎</div>
            <div class="doubles__p">
                <?php echo $teacher->post_excerpt ?>
            </div>
            <a href="<?php the_permalink($teacher) ?>" class="cs-btn btn btn-5 mt-78">Подробнее</a>
        </div>
        <div class="mob-w-100" uk-scrollspy="cls:uk-animation-slide-right-medium; offset-top: -300">
            <div class="doubles__img doubles__img_d6">
                <picture>
                    <?php if (has_post_thumbnail($teacher->ID)) {
                        echo get_the_post_thumbnail($teacher->ID, 'full', array('alt' => $teacher->post_title));
                    } else {
                        echo '<img src="' . get_stylesheet_directory_uri() . '/img/no_image_news.png">';
                    }
                    ?>
                </picture>
            </div>
        </div>
    </div>

    <?php
    $interaction = get_post(41);
    ?>
    <div class="doubles__item cs-gray-bg doubles__right-align">
        <div class="mob-w-100" uk-scrollspy="cls:uk-animation-slide-left-medium; offset-top: -300">
            <div class="doubles__img doubles__img_d7">
                <picture>
                    <?php if (has_post_thumbnail($interaction->ID)) {
                        echo get_the_post_thumbnail($interaction->ID, 'full', array('alt' => $interaction->post_title));
                    } else {
                        echo '<img src="' . get_stylesheet_directory_uri() . '/img/no_image_news.png">';
                    }
                    ?>
                </picture>
            </div>
        </div>
        <div class="doubles__content" uk-scrollspy="cls:uk-animation-slide-right-medium; offset-top: -300">
            <div class="doubles__name"><?php echo $interaction->post_title ?></div>
            <div class="doubles__p">
                <?php echo $interaction->post_excerpt ?>
            </div>
            <a href="<?php the_permalink($interaction) ?>" class="cs-btn btn btn-5 mt-50">подробнее</a>
        </div>
    </div>

</section>