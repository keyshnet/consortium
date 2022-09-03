<?php

/**
 * Template name: Blog Network User
 *
 */

get_header();

ds_after_content();
// $obj = get_queried_object();
// $c_id = $obj->term_id;

$showBar = false;
?>
<div class="milky-bg">
    <div class="uk-flex uk-flex-between cs-container soc-main-container">
        <?php get_template_part('template-parts/network/left-sitebar'); ?>
        <section class="soc-content settings-prof<?php /*if(isset($_GET['settings']) && $_GET['settings']=='Y'){ echo 'settings-prof';}*/ ?>">
            <div class="soc-content-wrap">
                <?php
                if (isset($_GET['settings']) && $_GET['settings'] == 'Y') {
                    get_template_part('template-parts/user/user_settings');
                } elseif (isset($_GET['edit']) && $_GET['edit'] == 'Y') {
                    get_template_part('template-parts/user/user_edit');
                } else {
                    $showBar = true;
                    get_template_part('template-parts/user/user_page');
                }
                ?>
            </div>
        </section>
        <?php
        if ($showBar) {
            if (isset($user_info) and ds_check_accsess('access_list_friends', 'user_' . $user_info->ID)) :
                get_template_part('template-parts/network/right-sitebar-friends');
            else :
                get_template_part('template-parts/network/right-sitebar');
            endif;
        }
        ?>
    </div>
</div>
<?php get_footer(); ?>