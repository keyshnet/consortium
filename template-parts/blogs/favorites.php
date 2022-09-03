<?php
global $user_info, $user_info_meta, $subjects;
$favorites = (array)get_field('favorites_posts', 'user_' . wp_get_current_user()->ID);
$filterSubjects = get_terms(array(
    'hide_empty'  => 0,
    'taxonomy'    => 'ds_objects',
));
$subjects = wp_list_filter($filterSubjects, array('parent' => 0));
?>

<div class="soc-panel">
    <h1 class="soc-h1"><?php the_title(); ?></h1>

    <?php get_template_part('template-parts/blocks/posts-filter', null); ?>
</div>

<div class="soc-content-wrap">
    <?php
    $myPostsArgs = array(
        'post_type' => 'ds_network',
        'posts_per_page' => -1,
        'post__in'   => $favorites,
        'ds_title' => ''
    );
    ds_show_post_blog($myPostsArgs);

    ?>
</div>