<?php

/**
 * Template name: Blog Network Lenta
 *
 */

get_header('social');
global $user_info, $user_info_meta;
$show_hidden = (isset($_GET["show"]) && $_GET["show"] == "hidden") ? true : false;

$addTitle = "";
if (isset($_GET["subj"]) && !empty($_GET["subj"])) {
    $addTitle .= " - " . get_term(intval($_GET["subj"]), 'ds_objects')->name;
}

?>
<div class="milky-bg">
    <div class="uk-flex uk-flex-between cs-container soc-main-container">
        <?php get_template_part('template-parts/network/left-sitebar'); ?>
        <section class="soc-content">
            <h1 class="soc-h1"><?php the_title();
                                echo $addTitle ?></h1>

            <form method="get">
                <div class="cs-search uk-margin-medium-top friends__search uk-position-relative">
                    <input type="text" value="<?php echo (!empty($_GET["search"])) ? $_GET["search"] : "" ?>" name="search" placeholder="Поиск">
                    <div class="uk-flex uk-align-center uk-margin-remove">
                        <button class="btn-search bg-reset uk-flex uk-flex-center uk-flex-middle ico-search">
                        </button>
                    </div>
                </div>
            </form>
            <div class="soc-panel">
                <?php
                if (isset($_GET["show_hidden"]) && $_GET["show_hidden"] == "Y") {
                    $show_hidden_loc = add_query_arg(['show_hidden' => false]);
                    $check_show_hidden = "checked";
                } else {
                    $show_hidden_loc = add_query_arg(['show_hidden' => 'Y']);
                    $check_show_hidden = "";
                }
                ?>
                <input type="checkbox" name="show_hidden" onclick="top.location='<?php echo $show_hidden_loc ?>'" <?php echo $check_show_hidden ?> id="cb1">
                <label for="cb1">Показывать закрытые блоги</label>
                <?php get_template_part('template-parts/blocks/posts-filter', null); ?>

            </div>


            <div class="soc-content-wrap">
                <?php
                //                $meta_query_blogs = array(
                //                    array(
                //                        'taxonomy' => 'ds_objects',
                ////                                'field'    => 'slug',
                //                        'terms'    => $subject->term_id,
                ////                                'operator' => 'EXISTS',
                //                    )
                //                );
                $myPostsArgs = array(
                    'post_type' => 'ds_network',
                    'posts_per_page' => 10,
                    'ds_title' => '',
                    //'meta_query' => $meta_query_blogs
                );
                ds_show_post_blog($myPostsArgs);

                ?>
                <?php
                $args = array(
                    'category' => '119',
                    'meta_query' => $meta_query,
                    'ds_title' => '',
                );
                ds_show_confs($args);
                ?>
            </div>

        </section>
        <?php get_template_part('template-parts/network/right-sitebar'); ?>
    </div>
</div>
<?php get_footer(); ?>