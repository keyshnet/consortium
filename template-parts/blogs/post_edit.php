<?php
global $user_info, $user_info_meta;
$post = new stdClass();
$accessPage = true;
if (isset($_GET['post_id']) && intval($_GET['post_id']) > 0) {

    $post = get_post(intval($_GET['post_id']));
    //    $post->data_more = get_fields( 'ds_network_'.intval($_GET['post_id']));

    $getTermsBlog = get_the_terms(get_the_ID(), 'ds_blogs')[0];
    $getTermsObject = get_the_terms(get_the_ID(), 'ds_objects')[0];

    $title_form = 'Редактировать публикацию "' . $post->post_title . '"';
    $action = "post_edit";

    if (intval($post->post_author) !== intval($user_info->ID))
        $accessPage = false;
} else {
    $getTermsBlog = new stdClass();
    $getTermsObject = new stdClass();
    $getTermsBlog->term_id = '';
    $getTermsObject->term_id = '';
    $title_form = "Добавить публикацию";
    $action = "post_edit";
}
if ($accessPage) :
    $metaValues = ds_get_meta_values('user_' . $user_info->ID);

    $meta_query_blogs = array(
        'relation'        => 'OR',
        array(
            'key'     => 'access_add',
            'value'   => '"' . $user_info->ID . '"',
            'compare' => 'LIKE',
        )
    );
    $ds_blogs = get_terms(array(
        'hide_empty'  => 0,
        'taxonomy'    => 'ds_blogs',
        'meta_query' => $meta_query_blogs
    ));
    //$ds_blogs = get_terms('ds_blogs', array( 'hide_empty' => 0 ));

    $meta_query_objects = array(
        'relation'        => 'OR',
        array(
            'key'        => 'access_add_posts',
            'value'        => 'all',
            'compare'    => '='
        ),
        array(
            'relation'        => 'AND',
            array(
                'key'        => 'access_add_posts',
                'value'        => 'users',
                'compare'    => '='
            ),
            array(
                'key'     => 'id_users_add_posts',
                'value'   => '"' . $user_info->ID . '"',
                'compare' => 'LIKE',
            )
        )
    );
    $ds_objects = get_terms(array(
        'hide_empty'  => 0,
        'taxonomy'    => 'ds_objects',
        'meta_query' => $meta_query_objects
    ));
    //$ds_objects = get_terms('ds_objects', array( 'hide_empty' => 0 ));

    if ('POST' == $_SERVER['REQUEST_METHOD']  && !empty($_POST['action']) && $_POST['action'] == 'post_edit') {
        if (!isset($_POST['update_post_notice']) || !wp_verify_nonce($_POST['update_post_notice'], 'update_post')) {
            echo 'Произошла неизвестная ошибка, попробуйте позже!';
        } else {
            $error = '';
            $errorSave = '';

            $postNewArgs = array();



            if (!empty($_POST['post_title']))
                $postNewArgs["post_title"] = $_POST["post_title"];
            if (!empty($_POST['post_excerpt']))
                $postNewArgs["post_excerpt"] = $_POST["post_excerpt"];
            if (!empty($_POST['postcontent']))
                $postNewArgs["post_content"] = $_POST["postcontent"];

            //        m_p($postNewArgs);
            if (!empty($postNewArgs)) {
                if (!empty($_POST['ds_objects']))
                    $postNewArgs["tax_input"]["ds_objects"] = array($_POST["ds_objects"]);
                if (!empty($_POST['ds_blogs']))
                    $postNewArgs["tax_input"]["ds_blogs"] = array($_POST["ds_blogs"]);

                $postNewArgs["ID"] = intval($_POST["post_id"]);
                $postNewArgs["post_type"] = "ds_network";
                $postNewArgs["post_author"] = $user_info->ID;
                $postNewArgs["post_status"] = "publish";

                if ($postNewArgs["ID"] > 0) {
                    $addPostRes = wp_update_post(wp_slash($postNewArgs));
                } else {
                    $addPostRes = wp_insert_post(wp_slash($postNewArgs));
                }

                if (is_wp_error($addPostRes)) {
?>
                    <div class="soc-other-user" style="color: red">
                        <?php
                        echo $addPostRes->get_error_message();
                        ?>
                    </div>
                <?php
                } else {
                ?>
                    <div class="soc-other-user" style="color: green">
                        Изменения успешно сохранены!
                    </div>
                <?php
                    $post = get_post($addPostRes);
                }
            } else {
                ?>
                <div class="soc-other-user" style="color: red">
                    Не все поля заполнены
                </div>
    <?php
            }
        }
    }

    ?>
    <?php //if(current_user_can('administrator')||adding_accsess($c_id)||get_term_meta($c_id, 'blog_type', true)=='0') {  
    ?>
    <a href="/<?php echo URL_NETWORK ?>/my-posts/" class="back-link">назад</a>
    <h1 class="settings__h1"><?php echo $title_form; ?></h1>

    <form id="editpost" class="form" method="post" action="" enctype="multipart/form-data">
        <div class="conferention__block edit-profile">
            <div class="callback__form-col w-2-4 mr-20">
                <label class="uk-form-label cs-mb-9 uk-display-block">Выберите тематический раздел</label>
                <div class="uk-form-controls">
                    <select name="ds_objects">
                        <?php foreach ($ds_objects as $ds_object) : ?>
                            <option value="<?php echo $ds_object->term_id ?>" <?php echo ($getTermsObject->term_id == $ds_object->term_id) ? 'selected' : ''; ?>><?php echo $ds_object->name ?></option>
                            <?php endforeach ?>?>
                    </select>
                </div>
            </div>

            <div class="callback__form-col w-2-4 mr-0">
                <label class="uk-form-label cs-mb-9 uk-display-block">Выберите авторский блог</label>
                <div class="uk-form-controls">
                    <select name="ds_blogs">
                        <?php foreach ($ds_blogs as $ds_blog) : ?>
                            <option value="<?php echo $ds_blog->term_id ?>" <?php selected($getTermsBlog->term_id, $ds_blog->term_id); ?>><?php echo $ds_blog->name ?></option>
                            <?php endforeach ?>?>
                    </select>
                </div>
            </div>

            <div class="callback__form-col w-4-4">
                <label class="uk-form-label cs-mb-9 uk-display-block">Название публикации</label>
                <div class="uk-form-controls">
                    <input class="uk-input cs-inpit" type="text" placeholder="Введите название" name="post_title" value="<?php echo $post->post_title ?? ''; ?>">
                </div>
            </div>

            <div class="mb-29">
                <div class="preview_image">
                    <?php
                    // if (get_term_meta($obj->term_id, 'cat_image', true)){
                    //     //$pre_img = get_the_post_thumbnail_url('news_block');
                    //     echo '<img src="'.wp_get_attachment_image_url(get_term_meta($obj->term_id, 'cat_image', true), 'news_block').'" alt="" >';
                    // }
                    ?>
                </div>
                <?php
                if (has_post_thumbnail()) {
                ?>
                    <div class="cs-uploaded-img">
                        <picture><img src="<?php echo the_post_thumbnail_url(); ?>" alt=""></picture>
                    </div>
                <?php
                }
                ?>


                <div class="js-upload uk-display-block mt-8" uk-form-custom>
                    <input type="file" name="myfilefield" class="form-control" value="<?php echo get_post_thumbnail_id() ?>">
                    <?php wp_nonce_field('myuploadnonce', 'mynonce'); ?>
                    <button type="submit" class="ghost-btn uk-button uk-button-default ico-img-left link-underline btn-upload" tabindex="-1">Добавить обложку</button>
                </div>
            </div>

            <div class="soc-art__textarea-wrap w-100">
                <label class="uk-form-label cs-mb-9 uk-display-block">Описание публикации</label>
                <textarea name="post_excerpt" class="soc-art__textarea" placeholder="Введите описание"><?php echo $post->post_excerpt ?? ''; ?></textarea>
            </div>


            <div class="soc-art__textarea-wrap mt-20 w-100">
                <label class="uk-form-label cs-mb-9 uk-display-block">Текст публикации</label>
                <?php
                wp_editor($post->post_content ?? '', 'postcontent', array(
                    'wpautop'       => 1,
                    'media_buttons' => 0,
                    'textarea_name' => 'postcontent',
                    'textarea_rows' => 20,
                    'tabindex'      => null,
                    'editor_css'    => '',
                    'editor_class'  => '',
                    'teeny'         => 1,
                    'dfw'           => 0,
                    'tinymce'       => 1,
                    'quicktags'     => 0,
                    'drag_drop_upload' => false
                ));
                ?>
            </div>

        </div>

        <div class="conferention__block edit-profile cs-new-tags-col mt-30">

        </div>

        <h4 class="settings__title">Комментирование доступно</h4>
        <div class="uk-flex cs-radiobar uk-margin-medium-bottom">
            <input type="radio" name="rb3" id="rb21" checked> <label for="rb21" class="label-radio">Всем</label>
            <input type="radio" name="rb3" id="rb22"> <label for="rb22" class="label-radio">Друзьям</label>
            <input type="radio" name="rb3" id="rb23"> <label for="rb23" class="label-radio">Никому</label>
        </div>

        <div class="uk-flex cs-flex-end">
            <button type="submit" class="ghost-btn cs-btn btn btn-5 conferention__btn">сохранить</button>
        </div>

        <?php wp_nonce_field('update_post', 'update_post_notice') ?>
        <input name="action" type="hidden" value="<?php echo $action ?>" />
        <input name="post_id" type="hidden" value="<?php echo $post->ID ?? ''; ?>" />
        <div class="result"></div>
    </form>


<?php
else :
?>
    <a href="/<?php echo URL_NETWORK ?>/my-posts/" class="back-link">назад</a>
    <div class="soc-other-user">
        У вас нет доступа к этой странице!
    </div>
<?php
endif; ?>