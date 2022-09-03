<?php
$argsNews = array(
    'posts_per_page' => 5,
    'post_type' => 'post',
    'cat' => '114'
);
$mainNews = new \WP_Query($argsNews);
if ($mainNews->have_posts()) {
?>
    <section class="members">
        <div class="cs-container">
            <h2 class="h2">Участники консорциума</h2>
            <div class="uk-flex uk-flex-between" uk-scrollspy="cls:uk-animation-scale-up; offset-top: -200">
                <?php
                while ($mainNews->have_posts()) {
                    $mainNews->the_post();
                ?>
                    <picture>
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail(false, array('alt' => get_the_title()));
                        } else {
                            echo '<img src="' . get_stylesheet_directory_uri() . '/img/no_image_news.png">';
                        }
                        ?>
                    </picture>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
<?php
} ?>