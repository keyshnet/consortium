<?php

/**
 * Template name: Blog Network Lenta
 *
 */

get_header();

$metaValues = array();
$metaValues['user_organization'] = acf_get_field('user_organization');
$metaValues['user_interest'] = acf_get_field('user_interest');
$metaValues['user_rate'] = acf_get_field('user_rate');
$metaValues['user_role_blog'] = acf_get_field('user_role_blog');

$user_login = '';
$user_email = '';
$errMess = $okMess = '';

if ('POST' === $_SERVER['REQUEST_METHOD']) {
    if (isset($_POST['user_email']) && is_string($_POST['user_email'])) {
        $user_email = wp_unslash($_POST['user_email']);
        $user_login = wp_unslash($_POST['user_email']);
    }



    $newUser = register_new_user($user_login, $user_email);
    if (is_wp_error($newUser)) { // handle failures.
        $errMess = $newUser->get_error_message();
    } else {
        //        $okMess = "Спасибо за регистрацию!";
        $okMess = sprintf(
            /* translators: %s: Link to the login page. */
            __('Check your email for the confirmation link, then visit the <a href="%s">login page</a>.'),
            wp_login_url()
        );

        if (!empty($_POST['first_name']) or !empty($_POST['last_name'])) {
            $first_name = $_POST['first_name'] ?? '';
            $last_name = $_POST['last_name'] ?? '';
            $user_surname = $_POST['user_surname'] ?? '';
            $display_name = esc_attr($last_name) . ' ' . esc_attr($first_name) . ' ' . esc_attr($user_surname);
            $editUser = wp_update_user([
                'ID'       => $newUser,
                'first_name' => esc_attr($first_name),
                'last_name' => esc_attr($last_name),
                'display_name' => $display_name
            ]);
            if (is_wp_error($editUser)) { // handle failures.
                $errMess = $editUser->get_error_message();
            }
        }

        if ($_POST['acf']) {
            acf_update_values(wp_kses_post_deep($_POST['acf']), 'user_' . $newUser);
        }
        if (isset($_FILES) && !empty($_FILES)) {
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';

            $file = &$_FILES['avatar'];

            $overrides = ['test_form' => false];
            if ($file["tmp_name"]) {
                //$movefile = wp_handle_upload( $file, $overrides );
                $avatar_id = media_handle_upload(
                    'avatar',
                    0,
                    array(),
                    array(
                        'mimes' => array(
                            'jpg|jpeg|jpe' => 'image/jpeg',
                            'gif' => 'image/gif',
                            'png' => 'image/png',
                        ),
                        'test_form' => false,
                        //                    'unique_filename_callback' => array( $this, 'unique_filename_callback' ),
                    )
                );
                if (is_wp_error($avatar_id)) { // handle failures.
                    $errMess = '<strong>' . 'Ошибка загрузки аватара' . '</strong> ' . esc_html($avatar_id->get_error_message());
                } else {
                    $meta_value = array();

                    // set the new avatar
                    if (is_int($avatar_id)) {
                        $meta_value['media_id'] = $avatar_id;
                        $avatar_id = wp_get_attachment_url($avatar_id);
                    }

                    $meta_value['full'] = $avatar_id;

                    update_user_meta($newUser, 'simple_local_avatar', $meta_value);
                }
            }
        }
    }
}

?>
<main>
    <div class="cs-container pt-29 reg">
        <?php ds_back_link(); ?>
        <h1 class="reg-h1">Регистрация</h1>
        <?php
        if ($errMess) {
            echo '<p class="uk-text-bold uk-text-default red-star mb-20">' . $errMess . '</p>';
        }
        if ($okMess) {
            echo '<p class="uk-text-bold uk-text-default mb-20" style="color: green">' . $okMess . '</p>';
        } else {
        ?>
            <form name="registerform" id="registerform" action="<?php site_url('wp-login.php?action=register'); ?>" method="post" enctype="multipart/form-data">
                <div class="reg-block">
                    <h2 class="reg__h2">Укажите информацию о своей деятельности</h2>

                    <div class="uk-flex uk-flex-wrap">

                        <div class="callback__form-col uk-margin-medium-right">
                            <label class="uk-form-label">Роль пользователя <span class="red-star">*</span></label>
                            <div class="form-select">
                                <select name="acf[user_role_blog]">
                                    <?php foreach ($metaValues["user_role_blog"]["choices"] as $ur_key => $role) : ?>
                                        <option value="<?php echo $ur_key ?>" <?php echo (!empty($_POST["acf"]["user_role_blog"]) &&  $_POST["acf"]["user_role_blog"] == $ur_key) ? 'selected' : ''; ?>> <?php echo $role ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="callback__form-col  cs-min-width uk-margin-medium-right">
                            <label class="uk-form-label">Организациия</label>
                            <div class="uk-form-controls">
                                <select name="acf[user_organization]">
                                    <option value="">--Пусто--</option>
                                    <?php foreach ($metaValues["user_organization"]["choices"] as $ua_key => $organiz) : ?>
                                        <option value="<?php echo $ua_key ?>" <?php echo (!empty($_POST["acf"]["user_organization"]) &&  $_POST["acf"]["user_organization"] == $ua_key) ? 'selected' : ''; ?>> <?php echo $organiz ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>


                        <div class="callback__form-col  cs-min-width">
                            <label class="uk-form-label">Научная степень</label>
                            <div class="uk-form-controls">
                                <select name="acf[user_rate]">
                                    <?php foreach ($metaValues["user_rate"]["choices"] as $ur_key => $rate) : ?>
                                        <option value="<?php echo $ur_key ?>" <?php echo (!empty($_POST["acf"]["user_rate"]) &&  $_POST["acf"]["user_rate"] == $ur_key) ? 'selected' : ''; ?>> <?php echo $rate ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>


                        <div class="callback__form-col uk-margin-medium-right">
                            <label class="uk-form-label">Сфера интересов</label>
                            <div class="form-select">
                                <select name="acf[user_interest]">
                                    <option value="">--Пусто--</option>
                                    <?php foreach ($metaValues["user_interest"]["choices"] as $ui_key => $interes) : ?>
                                        <option value="<?php echo $ui_key ?>" <?php echo (!empty($_POST["acf"]["user_interest"]) &&  $_POST["acf"]["user_interest"] == $ui_key) ? 'selected' : ''; ?>> <?php echo $ui_key ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="uk-flex-1 cs-min-width">
                            <label class="uk-form-label cs-mb-9 uk-display-block">Примечание к Сфере интересов</label>
                            <div class="uk-form-controls">
                                <input name="acf[user_interest_note]" class="uk-input cs-inpit" type="text" value="<?php echo $_POST["acf"]["user_interest_note"] ?? ''; ?>" size="255">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="reg-block">
                    <h2 class="reg__h2">Укажите информацию о себе</h2>

                    <div class="uk-flex uk-flex-wrap">

                        <div class="callback__form-col uk-margin-medium-right">
                            <label class="uk-form-label">Фамилия<span class="red-star">*</span></label>
                            <div class="uk-form-controls">
                                <input name="last_name" class="uk-input cs-inpit" required value="<?php echo $_POST["last_name"] ?? ''; ?>" type="text">
                            </div>
                        </div>

                        <div class="callback__form-col uk-margin-medium-right">
                            <label class="uk-form-label">Имя<span class="red-star">*</span></label>
                            <div class="uk-form-controls">
                                <input name="first_name" class="uk-input cs-inpit" required value="<?php echo $_POST["first_name"] ?? ''; ?>" type="text">

                            </div>
                        </div>

                        <div class="callback__form-col uk-margin-medium-right">
                            <label class="uk-form-label">Отчество</label>
                            <div class="uk-form-controls">
                                <input name="acf[user_surname]" class="uk-input cs-inpit" value="<?php echo $_POST["acf"]["user_surname"] ?? ''; ?>" type="text">
                            </div>
                        </div>

                        <div class="callback__form-col uk-margin-medium-right">
                            <label class="uk-form-label">Электронная почта<span class="red-star">*</span></label>
                            <div class="uk-form-controls">
                                <input type="email" name="user_email" id="user_email" class="uk-input cs-inpit" placeholder="ivanov@mail.com" value="<?php echo $_POST["user_email"] ?? ''; ?>" size="25" required>
                            </div>
                        </div>

                        <div class="callback__form-col">
                            <label class="uk-form-label">Телефон</label>
                            <div class="uk-form-controls">
                                <input name="acf[user_phone]" id="phone-mask" class="uk-input cs-inpit" placeholder="+1 (XXX) XXX-XX-XX" type="text" value="<?php echo $_POST["acf"]["user_phone"] ?? ''; ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="reg-block">
                    <h2 class="reg__h2">Мессенджеры</h2>

                    <div class="uk-flex uk-flex-wrap">
                        <div class="callback__form-col uk-margin-medium-right">
                            <label class="uk-form-label">Ссылка на Вконтакте </label>
                            <div class="uk-form-controls">
                                <input name="acf[user_vk]" class="uk-input cs-inpit" type="text" placeholder="Введите ссылку" value="<?php echo $_POST["acf"]["user_vk"] ?? ''; ?>">
                            </div>
                        </div>

                        <div class="callback__form-col uk-margin-medium-right">
                            <label class="uk-form-label">Ссылка на Facebook </label>
                            <div class="uk-form-controls">
                                <input name="acf[user_fb]" class="uk-input cs-inpit" type="text" placeholder="Введите ссылку" value="<?php echo $_POST["acf"]["user_fb"] ?? ''; ?>">
                            </div>
                        </div>

                        <div class="callback__form-col uk-margin-medium-right">
                            <label class="uk-form-label">Ссылка на Google </label>
                            <div class="uk-form-controls">
                                <input name="acf[user_google]" class="uk-input cs-inpit" type="text" placeholder="Введите ссылку" value="<?php echo $_POST["acf"]["user_google"] ?? ''; ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="reg-btns uk-flex uk-flex-between uk-flex-middle">
                    <div class="js-upload" uk-form-custom>
                        <input type="file" name="avatar" multiple>
                        <button class="ghost-btn cs-upload" type="button" tabindex="-1"><span>Прикрепить фото</span></button>
                    </div>
                    <button type="submit" class="ghost-btn cs-btn btn btn-5">регистрация</button>
                </div>
            </form>
        <?php
        }
        ?>
    </div>
</main>
<script>
    // Маска на номер телефона
    var phoneMask = IMask(
        document.getElementById('phone-mask'), {
            mask: '+{1}(000)000-00-00'
        });
</script>
<?php get_footer(); ?>