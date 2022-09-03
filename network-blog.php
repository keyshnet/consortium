<?php

/**
 * Template name: Blog Network
 *
 */

get_header();

ds_after_content();

$showBar = false;
?>
<div class="milky-bg">
    <div class="uk-flex uk-flex-between cs-container soc-main-container">
        <?php get_template_part('template-parts/network/left-sitebar'); ?>
        <section class="soc-content settings-prof">
            <?php
            if (isset($_GET['action']) && $_GET['action'] == 'subject_settings') {
                get_template_part('template-parts/blogs/subject_settings');
            } elseif (isset($_GET['settings']) && $_GET['settings'] == 'Y') {
                get_template_part('template-parts/blogs/blog_settings');
            } elseif (isset($_GET['action']) && $_GET['action'] == 'blog_edit') {
                get_template_part('template-parts/blogs/blog_edit');
            } elseif (isset($_GET['action']) && $_GET['action'] == 'post_edit') {
                get_template_part('template-parts/blogs/post_edit');
            } else {
                $showBar = true;
                get_template_part('template-parts/blogs/blog_posts');
            }
            ?>
        </section>
        <?php
        if ($showBar) {
            get_template_part('template-parts/network/right-sitebar');
        }
        ?>
    </div>
</div>
<?php get_footer(); ?>