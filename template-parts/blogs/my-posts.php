<?php
global $user_info, $user_info_meta;
?>

<div class="soc-panel">
    <h1 class="soc-h1"><?php the_title(); ?></h1>

    <div class="uk-flex uk-flex-between">
        <div class="soc-ddown uk-margin-small-right">
            <select>
                <option value="1">Все тематические разделы</option>
                <option value="2">Все тематические разделы2</option>
                <option value="3">Все тематические разделы3</option>
                <option value="4">Все тематические разделы4</option>
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

<div class="soc-content-wrap">
    <?php
    $myPostsArgs = array(
        'post_type' => 'ds_network',
        'posts_per_page' => -1,
        'author'   => '"' . $user_info->ID . '"',
        'ds_title' => '',
        'ds_edit' => 'Y',
    );
    ds_show_post_blog($myPostsArgs);

    ?>
</div>