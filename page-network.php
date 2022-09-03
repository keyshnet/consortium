<?php

/**
 * Template name: Blog Network Default
 *
 */

get_header();

ds_after_content();

$obj = get_queried_object();
$c_id = $obj->term_id;
$showBar = true;
?>
<div class="milky-bg">
  <div class="uk-flex uk-flex-between cs-container soc-main-container">
    <?php get_template_part('template-parts/network/left-sitebar'); ?>
    <section class="soc-content">
      <?php
      if ($obj->post_name == "friends") {
        get_template_part('template-parts/friends/friends');
      } elseif ($obj->post_name == "my-posts") {
        get_template_part('template-parts/blogs/my-posts');
      } elseif ($obj->post_name == "favorites") {
        get_template_part('template-parts/blogs/favorites');
      } elseif ($obj->post_name == "video-conference") {
        $showBar = false;
        get_template_part('template-parts/videoconference');
      } else {
      ?>
        <h1 class="friends__h1"><?php the_title(); ?></h1>
      <?php
        //          m_p($obj);
        the_content();
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