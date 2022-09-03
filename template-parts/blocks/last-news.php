<?php
global $post;
$postslist = get_posts([
    'category_name' => 'news',
    'post_type' => 'post',
    'posts_per_page' => 6,
    'order' => 'ASC',
    'orderby' => 'ID'
]);
if (!empty($postslist)) :
?>
    <div class="news-more__last-news soc-rs">
        <h3>Последние новости:</h3>
        <?php
        foreach ($postslist as $post) {
            setup_postdata($post);
        ?>
            <div class="read-now-item">
                <a href="<?php the_permalink(); ?>" class="read-now-item__title"><?php the_title(); ?> </a>
                <div class="read-now-item__date"><?php the_date(); ?></div>
            </div>
        <?php
        }
        ?>
    </div>
<?php
endif;

wp_reset_postdata();
