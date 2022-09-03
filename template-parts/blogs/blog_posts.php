<?php
$filterSubjects = get_terms(array(
    'hide_empty'  => 0,
    'taxonomy'    => 'ds_objects',
));
$subjects = wp_list_filter($filterSubjects, array('parent' => 0));
?>
<div class="soc-panel thematic-panel">
    <h1 class="soc-h1"><?php the_title(); ?></h1>

    <div class="uk-flex uk-flex-between">
        <div class="soc-ddown uk-margin-small-right">
            <select onchange="top.location=this.value">
                <option value="">Все тематические разделы</option>
                <?php foreach ($subjects as $subject) : ?>
                    <option value="<?php echo get_term_link($subject); ?>"><?php echo $subject->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>


        <div class="soc-ddown">
            <select>
                <option value="1">По новизне</option>
                <option value="2">По новизне1</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </div>
    </div>
</div>
<?php
foreach ($subjects as $subject) {
    //    m_p($subject);
?>
    <h2 class="soc-h1"><?php echo $subject->name; ?></h2>
    <!--    <div class="uk-flex uk-flex-between mb-17 cs-get-access">-->
    <!--        <h2 class="soc-h1 ico-lock-right uk-display-inline-block">Восточная юриспруденция</h2>-->
    <!--        <a href="article.html" class="cs-btn-border btn btn-5 fz-10">Запросить доступ</a>-->
    <!--    </div>-->

    <div class="soc-content-wrap">
        <?php
        $filterSubCats = array(
            'number' => 1,
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

        ?>
        <?php
        $args = array(
            'post_type' => 'ds_network',
            'posts_per_page' => 1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'ds_objects',
                    //                                'field'    => 'slug',
                    'terms'    => $subject->term_id,
                    //                                'operator' => 'EXISTS',
                )
            ),
            'ds_title' => '',
            'orderby'       => 'date',
            'order'         => 'DESC',
        );
        ds_show_post_blog($args);
        ?>

        <div class="uk-text-center">
            <a href="<?php echo get_term_link($subject); ?>" class="link-underline thematic__link">ВСЕ АВТОРСКИЕ БЛОГИ И ПУБЛИКАЦИИ ПО ТЕМЕ</a>
        </div>
    </div>
<?php
}
?>