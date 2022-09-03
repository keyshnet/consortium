<section class="doubles">
    <?php
    $courses = get_post(104);
    ?>
    <div class="doubles__item cs-gray-bg cs-bg-square-mini">
        <div class="doubles__content" uk-scrollspy="cls:uk-animation-slide-left-medium; offset-top: -300">
            <div class="doubles__name">Все курсы ДПО</div>
            <div class="doubles__p">
                <?php echo $courses->post_excerpt ?>
            </div>
            <a href="<?php the_permalink($courses) ?>" class="cs-btn btn btn-5 mt-78">все курсы</a>
        </div>
        <div class="cs-bg-square" uk-scrollspy="cls:uk-animation-slide-right-medium; offset-top: -300">
            <div class="doubles__img doubles__img_d1">
                <picture>
                    <?php if (has_post_thumbnail($courses->ID)) {
                        echo get_the_post_thumbnail($courses->ID, 'full', array('alt' => $courses->post_title));
                    } else {
                        echo '<img src="' . get_stylesheet_directory_uri() . '/img/no_image_news.png">';
                    }
                    ?>
                </picture>
            </div>
        </div>
    </div>

    <?php
    $expertise = get_post(43);
    ?>
    <div class="doubles__item pt-0 pb-0 cs-bg-square-mini doubles__right-align">
        <div class="red-line" uk-scrollspy="cls:uk-animation-slide-left-medium; offset-top: -300">
            <div class="doubles__img doubles__img_d2">
                <picture>
                    <?php if (has_post_thumbnail($expertise->ID)) {
                        echo get_the_post_thumbnail($expertise->ID, 'full', array('alt' => $expertise->post_title));
                    } else {
                        echo '<img src="' . get_stylesheet_directory_uri() . '/img/no_image_news.png">';
                    }
                    ?>
                </picture>
            </div>
        </div>
        <div class="doubles__content" uk-scrollspy="cls:uk-animation-slide-right-medium; offset-top: -300">
            <div class="doubles__name"><?php echo $expertise->post_title ?></div>
            <div class="doubles__p">
                <?php echo $expertise->post_excerpt ?>
            </div>
            <a href="<?php the_permalink($expertise) ?>" class="cs-btn btn btn-5 mt-86">подробнее</a>
        </div>
    </div>


    <?php
    $fuzi = get_post(1472);
    ?>
    <div class="doubles__item cs-gray-bg">
        <div class="doubles__content" uk-scrollspy="cls:uk-animation-slide-left-medium; offset-top: -300">
            <div class="doubles__name"><?php echo $fuzi->post_title ?></div>
            <div class="doubles__p">
                <?php echo $fuzi->post_excerpt ?>
            </div>
            <a href="<?php the_permalink($fuzi) ?>" class="cs-btn btn btn-5 mt-78">подробнее</a>
        </div>
        <div class="cs-bg-square" uk-scrollspy="cls:uk-animation-slide-right-medium; offset-top: -300">
            <div class="doubles__img doubles__img_d3">
                <picture>
                    <?php if (has_post_thumbnail($fuzi->ID)) {
                        echo get_the_post_thumbnail($fuzi->ID, 'full', array('alt' => $fuzi->post_title));
                    } else {
                        echo '<img src="' . get_stylesheet_directory_uri() . '/img/no_image_news.png">';
                    }
                    ?></picture>
            </div>
        </div>
    </div>

</section>