<?php
$obj = get_queried_object();
$c_id = $obj->term_id;
$cat_title = '';
$cat_description = '';

$actiontype = '0';


?>
<section class="cat_block settings_cat_block elementor-section elementor-top-section elementor-element elementor-element-51df6a5 elementor-section-boxed elementor-section-height-default elementor-section-height-default">
    <div class="elementor-container elementor-column-gap-default">
        <div class="back_link">
            <a href="javascript:history.back()"><svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13 6.5C13 6.25377 12.9144 6.01763 12.7621 5.84352C12.6097 5.66941 12.4031 5.5716 12.1876 5.5716H2.77502L6.2635 1.58689C6.41605 1.41256 6.50175 1.17612 6.50175 0.929577C6.50175 0.683038 6.41605 0.446596 6.2635 0.272267C6.11095 0.0979375 5.90405 0 5.68832 0C5.47258 0 5.26568 0.0979375 5.11313 0.272267L0.238676 5.84269C0.163019 5.92893 0.102994 6.03138 0.0620384 6.14417C0.0210829 6.25697 0 6.37788 0 6.5C0 6.62212 0.0210829 6.74303 0.0620384 6.85583C0.102994 6.96862 0.163019 7.07107 0.238676 7.15731L5.11313 12.7277C5.26568 12.9021 5.47258 13 5.68832 13C5.90405 13 6.11095 12.9021 6.2635 12.7277C6.41605 12.5534 6.50175 12.317 6.50175 12.0704C6.50175 11.8239 6.41605 11.5874 6.2635 11.4131L2.77502 7.4284H12.1876C12.4031 7.4284 12.6097 7.33059 12.7621 7.15648C12.9144 6.98237 13 6.74623 13 6.5Z" fill="#DC3333" />
                </svg>назад</a>
        </div>
        <?php if (current_user_can('administrator') || adding_accsess($c_id) || get_term_meta($c_id, 'blog_type', true) == '0' && is_user_logged_in()) {  ?>
            <div class="blogs_title flex">
                <div class="f34">
                    <h2>Добавить блог</h2>
                </div>
            </div>
            <div class="add_blog">
                <strong>Сначала загрузите фото</strong>
                <form id="imageform" class="form" method="post" action="" enctype="multipart/form-data">
                    <input type="file" name="myfilefield" class="form-control" value="">
                    <?php wp_nonce_field('myuploadnonce', 'mynonce'); ?>
                    <button type="submit" class="btn btn-primary">Загрузить</button>
                </form>
                <div class="preview_image">
                    <?php
                    if (get_term_meta($obj->term_id, 'cat_image', true)) {
                        //$pre_img = get_the_post_thumbnail_url('news_block');
                        echo '<img src="' . wp_get_attachment_image_url(get_term_meta($obj->term_id, 'cat_image', true), 'news_block') . '" alt="" >';
                    } ?>
                </div>
                <p><strong>Заголовок</strong><br>
                    <input class="cat_name" name="cat_name" value="<?php echo $cat_title; ?>">
                </p>
                <p><strong>Краткое описание</strong><br>
                    <textarea class="cat_text" name="cat_text"><?php echo $cat_description; ?></textarea>
                </p>
                <input type="hidden" class="cat_image" name="cat_image" value="<?php echo get_term_meta($obj->term_id, 'cat_image', true); ?>">
                <button type="submit" class="btn btn-primary send_cat">Опубликовать</button>
                <div class="result"></div>
            </div>
            <script>
                jQuery(document).ready(function($) {
                    $('#bpsp_site_post_select_category').val(<?php echo $c_id ?>).change();
                });
            </script>
        <?php } else {
            echo '<h2>У вас нет доступа к етому разделу</h2>';
        } ?>

    </div>
</section>