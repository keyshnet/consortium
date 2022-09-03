<?php
global $user_info, $user_info_meta;
$blog = new stdClass();

if (isset($_GET['blog_id']) && intval($_GET['blog_id']) > 0) {

  $blog = get_term(intval($_GET['blog_id']));
  $blog->data_more = get_field_objects('ds_blogs_' . intval($_GET['blog_id']));

  $title_form = 'Редактировать авторский блог "' . $blog->name . '"';
  $action = "edit_blog";
} else {
  $title_form = "Добавить авторский блог";
  $action = "add_blog";
}
$metaValues = ds_get_meta_values('user_' . $user_info->ID);

$meta_query_objects = array(
  'relation'    => 'OR',
  array(
    'key'    => 'access_add_blogs',
    'value'    => 'all',
    'compare'  => '='
  ),
  array(
    'relation'    => 'AND',
    array(
      'key'    => 'access_add_blogs',
      'value'    => 'users',
      'compare'  => '='
    ),
    array(
      'key'     => 'id_users_add_blogs',
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

?>
<?php ds_back_link(); ?>
<h1 class="settings__h1"><?php echo $title_form; ?></h1>

<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="form_edit_blog" method="POST">
  <div class="conferention__block edit-profile">
    <div class="callback__form-col w-2-4 mr-20">
      <label class="uk-form-label cs-mb-9 uk-display-block">Выберите тематический раздел</label>
      <div class="uk-form-controls">
        <select name="ds_objects">
          <?php foreach ($ds_objects as $ds_object) : ?>
            <option value="<?php echo $ds_object->term_id ?>" <?php //echo ($metaValues["subjet"]["value"] == $ds_object->term_id)? 'selected':'';
                                                              ?>><?php echo $ds_object->name ?></option>
          <?php endforeach ?>
        </select>
      </div>
    </div>

    <div class="callback__form-col w-4-4">
      <label class="uk-form-label cs-mb-9 uk-display-block">Название авторского блога</label>
      <div class="uk-form-controls">
        <input class="uk-input cs-inpit" type="text" placeholder="Введите название" name="name" value="<?php echo (!empty($blog->name)) ? $blog->name : '' ?>">
      </div>
    </div>

    <div class="mb-29">
      <!--            <div class="cs-uploaded-img">-->
      <!--              <picture><source srcset="img/soc/uploaded.webp" type="image/webp"><img src="img/soc/uploaded.jpg" alt=""></picture>-->
      <!--            </div>-->

      <div class="js-upload uk-display-block mt-8" uk-form-custom>
        <input type="file" multiple name="picture">
        <button class="ghost-btn uk-button uk-button-default ico-img-left link-underline btn-upload" type="button" tabindex="-1">Добавить обложку</button>
      </div>
    </div>

    <div class="soc-art__textarea-wrap w-100">
      <label class="uk-form-label cs-mb-9 uk-display-block">Описание авторского блога</label>
      <textarea name="description" class="soc-art__textarea" placeholder="Введите описание"><?php echo (!empty($blog->description)) ? $blog->description : '' ?></textarea>
    </div>

  </div>

  <div class="conferention__block edit-profile cs-new-tags-col mt-30">

  </div>

  <h4 class="settings__title">Разрешение на чтение тематического блога:</h4>
  <div class="uk-flex cs-radiobar uk-margin-medium-bottom">
    <input type="radio" name="rb3" id="rb21" checked> <label for="rb21" class="label-radio">Всем</label>
    <input type="radio" name="rb3" id="rb22"> <label for="rb22" class="label-radio">Выбранным пользователям</label>
  </div>

  <h4 class="settings__title">Разрешение на добавление публикаций в авторский блог:</h4>
  <div class="uk-flex cs-radiobar">
    <input type="radio" name="rb4" id="rb31" checked> <label for="rb31" class="label-radio">Всем</label>
    <input type="radio" name="rb4" id="rb32"> <label for="rb32" class="label-radio">Выбранным пользователям</label>
  </div>

  <a href="#modal-center" class="btn-add-user ico-plus-circle-right" uk-toggle>Добавить пользователя</a>
  <ul class="settings__users">
    <li class="settings__users_item">
      <span>Астафьева Анастасия Вячеславовна</span>
      <button type="button" class="ghost-btn ico-remove"></button>
    </li>
    <li class="settings__users_item">
      <span>Александров Петр Афанасьевич</span>
      <button type="button" class="ghost-btn ico-remove"></button>
    </li>
  </ul>

  <div class="uk-flex cs-flex-end">
    <button name="updateblog" type="submit" class="ghost-btn cs-btn btn btn-5 conferention__btn">сохранить</button>

    <?php wp_nonce_field('update_blog_action', 'update_blog_nonce_field') ?>
    <input name="action" type="hidden" value="<?php echo $action ?>" />
    <input name="blog_id" type="hidden" value="<?php echo $blog->term_id ?? ''; ?>" />
    <input name="user_id" type="hidden" value="<?php echo $user_info->ID; ?>" />
    <input name="slug" type="hidden" value="<?php if (!empty($blog->slug)) echo sanitize_text_field($blog->slug) ?>" />
  </div>
  <div class="result" style="color: green"></div>
</form>

<script>
  $(document).ready(function($) {
    var form = $('#form_edit_blog');

    $(form).submit(function(e) {
      e.preventDefault();

      var myformData = new FormData(form[0]);
      // console.log(myformData);

      $.ajax({
        type: "POST",
        data: myformData,
        dataType: "json",
        url: myajax.url,
        cache: false,
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        success: function(respone) {
          if (respone.result == "ok") {
            $('.result').css("color", "green").html(respone.message);
            UIkit.modal.alert(respone.message).then(function() {
              console.log('Confirmed.')
            }, function() {
              $('.result').css("color", "green").html(respone.message);
              console.log('Rejected.')
            });
          } else {
            UIkit.modal.alert(respone.message);
            $('.result').css("color", "red").html(respone.message);
          }

        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('.result').css("color", "red").html("Произошла неизвестная ошибка, попробуйте позже!");
          console.log(jqXHR.responseText);
        }
      });
    });
  });
</script>