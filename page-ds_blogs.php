<?php

/**
 */

get_header();
?>
<div class="milky-bg">
    <div class="uk-flex uk-flex-between cs-container soc-main-container">
        <?php get_template_part('template-parts/network/left-sitebar'); ?>
        <section class="soc-content">
            <div class="soc-content__item soc-art__item">
                <h2><?php echo get_the_archive_title(); ?></h2>
                <div class="cat_description"><?php echo get_the_archive_description(); ?></div>
                <div class="my_publication_block">
                    <div class="flex rows">
                        <?php
                        $terms = get_terms([
                            'taxonomy'   => 'post',
                            'hide_empty' => false,
                        ]);
                        // m_p($terms);

                        $filterSubCats = get_terms(array(
                            'hide_empty'  => 0,
                            'taxonomy'    => 'ds_network',
                            // 'meta_query'        => array(
                            //     'relation'      => 'AND',
                            //     array(
                            //         'key'           => 'subjet',
                            //         'value'         => get_queried_object()->term_taxonomy_id,
                            //         'compare'       => '='
                            //     )
                            // )
                        ));
                        $blogs = wp_list_filter($filterSubCats, array('parent' => 0));
                        if ($blogs) {
                        ?>
                            <div class="f2">
                                <?php
                                $num = 0;
                                foreach ($blogs as $blog) {
                                    if ($num > 0) {
                                        echo '<div class="f0">';
                                    }
                                ?>
                                    <div class="inner" style="background:url(<?php echo get_image_cat($blog->term_id, 'cat_image', 'ds_blogs') ?>);background-size:cover;background-position:center;">
                                        <a href="<?php echo get_term_link($blog); ?>"></a>
                                        <div class="meta">
                                            <div class="title"><?php echo $blog->name; ?></div>
                                        </div>
                                    </div>

                                <?php
                                    if ($num > 0) {
                                        echo '</div>';
                                    }
                                    if ($num == 0) {
                                        echo '</div><div class="f2">';
                                    }
                                    $num++;
                                }
                                ?>
                            </div>
                        <?php

                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>


<?php get_footer(); ?>