<?php

/**
 */

get_header();
$subject = get_queried_object();
//m_p(get_field( 'access_request', 'ds_objects_'.$subject->term_id));
?>
<div class="milky-bg">
    <div class="uk-flex uk-flex-between cs-container soc-main-container">
        <?php get_template_part('template-parts/network/left-sitebar'); ?>
        <section class="soc-content">
            <?php
            if ($subject->term_id > 0) {
                $is_posts = (isset($_GET["show"]) && $_GET["show"] == "posts") ? true : false;
            ?>
                <h1 class="soc-h1"><?php echo $subject->name; ?></h1>
                <div class="soc-panel">

                    <div class="uk-flex uk-flex-between uk-flex-1">
                        <div class="soc-ddown uk-margin-small-right uk-flex uk-flex-middle">
                            <div class="thematic-label">
                                Показать:
                            </div>
                            <select onchange="top.location=this.value">
                                <option value="<?php echo add_query_arg(['show' => false]) ?>">Авторские блоги</option>
                                <option value="<?php echo add_query_arg(['show' => 'posts']) ?>" <?php echo ($is_posts) ? 'selected' : '' ?>>Публикации</option>
                            </select>
                        </div>


                        <div class="soc-ddown">
                            <select onchange="top.location=this.value">
                                <option value="">По новизне</option>
                                <option value="<?php echo add_query_arg(['order' => 'desc']) ?>">Сначала последние</option>
                                <option value="<?php echo add_query_arg(['order' => 'asc']) ?>">Сначала первые</option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="soc-content-wrap">
                    <?php
                    if ($is_posts) {
                        $args = array(
                            'post_type' => 'ds_network',
                            'posts_per_page' => -1,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'ds_objects',
                                    //                                'field'    => 'slug',
                                    'terms' => $subject->term_id,
                                    //                                'operator' => 'EXISTS',
                                )
                            ),
                            'ds_title' => ''
                        );
                        ds_show_post_blog($args);
                    } else {
                        $filterSubCats = array(
                            'posts_per_page' => 1,
                            'hide_empty'  => 0,
                            'taxonomy'    => 'ds_blogs',
                            'meta_query'        => array(
                                'relation'      => 'AND',
                                array(
                                    'key'           => 'subjet',
                                    'value'         => $subject->term_id,
                                    'compare'       => '='
                                )
                            )
                        );
                        ds_show_blogs($filterSubCats);
                    }
                    ?>
                </div>
            <?php
            } else {
            ?>
                <div class="soc-other-user">
                    Тематическое направление не найдено!
                </div>
            <?php
            }
            ?>

        </section>
        <?php get_template_part('template-parts/network/right-sitebar'); ?>
    </div>
</div>


<?php get_footer(); ?>