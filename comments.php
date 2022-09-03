<?php
if (post_password_required()) {
    return;
}

if (!comments_open()) {
    return;
}
?>
<?php if (post_password_required()) {
    return;
}

// шаблон вывода комментариев
function templ_comment($comment, $args, $depth)
{
    $add_below = 'comment';

    $classes = ' ' . comment_class(empty($args['has_children']) ? 'soc-comment__item' : 'parent', null, null, false);
?>

    <div<?php echo $classes; ?> id="comment-<?php comment_ID() ?>">
        <div class="soc-comment__img">
            <?php echo get_avatar($comment); ?>
        </div>
        <div class="soc-comment__content">
            <div class="soc-comment__header">
                <div class="soc-comment__name"><?php echo get_comment_author(); ?></div>
                <div class="soc-comment__date"><?php
                                                printf(
                                                    __('%1$s %2$s'),
                                                    get_comment_date(),
                                                    get_comment_time()
                                                ); ?></div>
            </div>
            <?php if ($comment->comment_approved == '0') { ?>
                <p><em class="comment-awaiting-moderation">
                        <?php _e('Your comment is awaiting moderation.'); ?>
                    </em></p>
            <?php } ?>

            <?php comment_text(); ?>
            <?php
            //                comment_reply_link(
            //                    array_merge(
            //                        $args,
            //                        array(
            //                            'add_below' => $add_below,
            //                            'depth'     => $depth,
            //                            'max_depth' => $args['max_depth']
            //                        )
            //                    )
            //                );
            ?>
        </div>
    <?php
}
    ?>
    <div class="soc-content__item soc-comment soc-art__comment-wrap">
        <?php
        comment_form(array(
            'class_form' => 'soc-art__textarea-wrap',
            'logged_in_as' => '',
            'title_reply'          => 'Комментарии',
            'title_reply_to'       => 'Комментарии',
            'title_reply_before'   => '<h2 class="soc-art-h2">',
            'title_reply_after'    => '</h2>',
            'comment_field' => '<textarea class="soc-art__textarea" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>',
            'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s btn-send"></button>'
        ));
        ?>

        <?php if (have_comments()) : ?>
            <?php
            wp_list_comments(array(
                'style'       => 'div',
                'short_ping'  => true,
                'callback' => 'templ_comment'
            ));
            ?>
        <?php endif; ?>
    </div>