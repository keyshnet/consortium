<?php
global $user_info, $user_info_meta;
if (wp_get_current_user()->ID == $user_info->ID) :
    $metaValues = array();
    $metaValues['access_email'] = acf_get_field('access_email');
    $metaValues['access_email']["title"] = "E-mail";
    $metaValues['access_phone'] = acf_get_field('access_phone');
    $metaValues['access_phone']["title"] = "Телефон";
    $metaValues['access_messanger'] = acf_get_field('access_messanger');
    $metaValues['access_messanger']["title"] = "Мессенджеры";
    $metaValues['access_list_friends'] = acf_get_field('access_list_friends');
    $metaValues['access_list_friends']["title"] = "Доступ к списку друзей";
    $metaValues['access_list_blogs'] = acf_get_field('access_list_blogs');
    $metaValues['access_list_blogs']["title"] = "Доступ к списку авторских блогов";
    //    m_p($metaValues);
?>
    <?php ds_back_link(); ?>
    <h1 class="settings__h1">Настройки профиля</h1>



    <?php
    foreach ($metaValues as $metaKey => $metaValue) {
    ?>
        <h4 class="settings__title"><?php echo $metaValue["title"] ?> <i></i></h4>
        <div class="uk-flex cs-radiobar uk-margin-medium-bottom">
            <?php foreach ($metaValue["choices"] as $c_key => $c_value) :
                if (!empty($user_info_meta[$metaValue["name"]][0]))
                    $checked = checked($user_info_meta[$metaValue["name"]][0], $c_key, false);
                else
                    $checked = checked($metaValue["default_value"], $c_key, false);
            ?>
                <input type="radio" <?php echo $checked; ?> name="<?php echo $metaValue["name"] ?>" id="<?php echo $c_key . '_' . $metaValue["name"] ?>" value="<?php echo $c_key ?>" class="ajax_edit">
                <label for="<?php echo $c_key . '_' . $metaValue["name"] ?>" class="label-radio"><?php echo $c_value ?></label>
            <?php endforeach ?>
        </div>
    <?php
    }
    ?>
    <script>
        $(document).ready(function($) {
            $(".ajax_edit").on('change', function() {
                var resPlace = $(this).parent('div').prev('h4').find('i');
                if ($(this).prop('checked')) {
                    console.log($(this).val());
                    update_field($(this).attr('name'), $(this).val(), 'user_<?php echo $user_info->ID; ?>', resPlace);
                }
            });
        });
    </script>
<?php
else :
?>
    <div class="soc-other-user">
        У вас нет доступа к этой странице!
    </div>
<?php
endif;
?>