<?php

/**
 */

get_header();
$obj = get_queried_object();
?>
<div class="milky-bg">
    <div class="uk-flex uk-flex-between cs-container soc-main-container">
        <?php get_template_part('template-parts/network/left-sitebar'); ?>
        <section class="soc-content">
            <?php
            if ($obj->term_id > 0) {
                //m_p($obj);
                $author = get_field('blog_author', 'ds_blogs_' . $obj->term_id);
            ?>
                <div class="soc-content__item soc-content-thematic">
                    <h1 class="soc-h1"><?php echo $obj->name; ?></h1>
                    <?php if (!empty($author)) : ?>
                        <div class="mini-author">
                            <div class="mini-author__img">
                                <picture>
                                    <?php echo get_avatar($author["ID"]); ?>
                                </picture>
                            </div>
                            <h3><?php echo $author["display_name"]; ?></h3>
                        </div>
                    <?php endif; ?>
                    <p class="thematic-p">
                        <?php echo $obj->description; ?>
                    </p>
                </div>

                <div class="soc-panel mt-20">

                    <div class="uk-flex uk-flex-between uk-flex-1">
                        <div class="soc-ddown uk-margin-small-right uk-flex uk-flex-middle">
                            <div class="thematic-label">
                                Показать публикации:
                            </div>
                            <select>
                                <option value="1">По популярности</option>
                                <option value="2">Все тематические разделы2</option>
                                <option value="3">Все тематические разделы3</option>
                                <option value="4">Все тематические разделы4</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="soc-content-wrap thematic-content">
                    <?php

                    $args = array(
                        'post_type' => 'ds_network',
                        'posts_per_page' => -1,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'ds_blogs',
                                //                                'field'    => 'slug',
                                'terms'    => $obj->term_id,
                                //                                'operator' => 'EXISTS',
                            )
                        ),
                        'ds_title' => ''
                    );
                    ds_show_post_blog($args);

                    ?>
                </div>
            <?php
            } else {
            ?>
                <div class="soc-other-user">
                    Блог не найден!
                </div>
            <?php
            }
            ?>
        </section>
        <?php get_template_part('template-parts/network/right-sitebar'); ?>
    </div>
</div>


<?php get_footer(); ?>