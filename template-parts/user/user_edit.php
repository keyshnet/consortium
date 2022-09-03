<?php
global $user_info, $user_info_meta;
global $current_user, $wp_roles;

if ($current_user->ID == $user_info->ID) :
    //$metaValues = ds_get_meta_values('user_'.$user_info->ID);
    //m_p($user_info);
    $metaValues = array();
    $metaValues['user_organization'] = acf_get_field('user_organization');
    $metaValues['user_interest'] = acf_get_field('user_interest');
    $metaValues['user_rate'] = acf_get_field('user_rate');
?>
    <div class=" pt-29 reg">
        <?php ds_back_link(); ?>
        <h1 class="settings__h1">Редактирование профиля</h1>
        <?php
        if ('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['action']) && $_POST['action'] == 'update-user') {
            $error = '';
            $errorSave = '';
            if (empty($_POST['first_name']))
                $error .= "Имя не должно быть пустым<br/>";
            if (empty($_POST['last_name']))
                $error .= "Фамилия не должна быть пустой<br/>";
            if (empty($_POST['user_phone']))
                $error .= "Телефон не должен быть пустой<br/>";
            if (empty($_POST['user_email']))
                $error .= "E-Mail не должен быть пустой<br/>";

            /* Redirect so the page will show updated info. */
            if (!$error) {
                update_user_meta($user_info->ID, 'first_name', esc_attr($_POST['first_name']));
                update_user_meta($user_info->ID, 'last_name', esc_attr($_POST['last_name']));
                update_user_meta($user_info->ID, 'user_surname', esc_attr($_POST['user_surname']));
                //        update_user_meta($user_info->ID, 'display_name', $display_name);
                update_user_meta($user_info->ID, 'user_phone', esc_attr($_POST['user_phone']));
                //        update_user_meta($user_info->ID, 'user_email', esc_attr($_POST['user_email']));
                wp_update_user(['ID' => $user_info->ID, 'user_email' => esc_attr($_POST['user_email'])]);
                update_field('user_organization', esc_attr($_POST['user_organization']), 'user_' . $user_info->ID);
                update_field('user_rate', esc_attr($_POST['user_rate']), 'user_' . $user_info->ID);
                update_field('user_interest', esc_attr($_POST['user_interest']), 'user_' . $user_info->ID);
                update_field('user_interest_note', esc_attr($_POST['user_interest_note']), 'user_' . $user_info->ID);
                update_user_meta($user_info->ID, 'user_vk', esc_attr($_POST['user_vk']));
                update_user_meta($user_info->ID, 'user_fb', esc_attr($_POST['user_fb']));
                update_user_meta($user_info->ID, 'user_google', esc_attr($_POST['user_google']));

                $display_name = esc_attr($_POST['last_name']) . ' ' . esc_attr($_POST['first_name']) . ' ' . esc_attr($_POST['user_surname']);
                wp_update_user([
                    'ID'       => $user_info->ID,
                    'display_name' => $display_name
                ]);

                //        m_p($_POST);

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
                            echo '<strong>' . 'Ошибка загрузки аватара' . '</strong> ' . esc_html($avatar_id->get_error_message());
                        } else {
                            $meta_value = array();

                            // set the new avatar
                            if (is_int($avatar_id)) {
                                $meta_value['media_id'] = $avatar_id;
                                $avatar_id = wp_get_attachment_url($avatar_id);
                            }

                            $meta_value['full'] = $avatar_id;

                            update_user_meta($user_info->ID, 'simple_local_avatar', $meta_value);
                        }
                    }
                }
            }
            if (!$error) {
        ?>
                <div class="soc-other-user" style="color: green">
                    Изменения успешно сохранены!
                </div>
            <?php
                exit;
            } else {
            ?>
                <div class="soc-other-user" style="color: red">
                    <?php
                    echo $error;
                    echo $errorSave;
                    ?>
                </div>
        <?php
            }
        }
        ?>
        <form method="post" id="adduser" action="" enctype="multipart/form-data">
            <div class="edit-img uk-flex uk-flex-middle">
                <div class="edit-img__avatar">
                    <picture style="border-radius: 50%; overflow: hidden; display: block;">
                        <?php echo get_avatar($user_info->ID); ?>
                    </picture>
                </div>
                <div class="js-upload" uk-form-custom>
                    <input type="file" name="avatar" multiple>
                    <button class="ghost-btn uk-text-left" type="button" tabindex="-1">Сменить фото <br> профиля</button>
                </div>
            </div>
            <div class="conferention__block edit-profile">
                <div class="callback__form-col w-1-4 mr-20">
                    <label class="uk-form-label cs-mb-9 uk-display-block">Имя</label>
                    <div class="uk-form-controls">
                        <input name="first_name" class="uk-input cs-inpit" type="text" required placeholder="Введите имя" value="<?php echo $user_info_meta["first_name"][0] ?? ''; ?>">
                    </div>
                </div>

                <div class="callback__form-col w-1-4 mr-20">
                    <label class="uk-form-label cs-mb-9 uk-display-block">Фамилия</label>
                    <div class="uk-form-controls">
                        <input name="last_name" class="uk-input cs-inpit" type="text" required placeholder="Введите фамилию" value="<?php echo $user_info_meta["last_name"][0] ?? ''; ?>">
                    </div>
                </div>

                <div class="callback__form-col w-1-4 mr-20">
                    <label class="uk-form-label cs-mb-9 uk-display-block">Отчество</label>
                    <div class="uk-form-controls">
                        <input name="user_surname" class="uk-input cs-inpit" type="text" placeholder="Введите отчество" value="<?php echo $user_info_meta["user_surname"][0] ?? ''; ?>">
                    </div>
                </div>

                <div class="callback__form-col w-1-4 mr-0">
                    <label class="uk-form-label cs-mb-9 uk-display-block">Телефон</label>
                    <div class="uk-form-controls">
                        <input name="user_phone" class="uk-input cs-inpit" type="text" id="phone-mask" required placeholder="Введите телефон" value="<?php echo $user_info_meta["user_phone"][0] ?? ''; ?>">
                    </div>
                </div>

                <div class="callback__form-col w-1-4 mr-20">
                    <label class="uk-form-label cs-mb-9 uk-display-block">E-mail</label>
                    <div class="uk-form-controls">
                        <input name="user_email" class="uk-input cs-inpit" type="email" required placeholder="Введите E-mail" value="<?php echo $user_info->data->user_email ?? ''; ?>">
                    </div>
                </div>
                <div class="callback__form-col w-3-4 mr-0">
                    <label class="uk-form-label cs-mb-9 uk-display-block">Организация</label>
                    <div class="uk-form-controls">
                        <select name="user_organization" class="ajax_edit">
                            <?php foreach ($metaValues["user_organization"]["choices"] as $ua_key => $organiz) : ?>
                                <option value="<?php echo $ua_key ?>" <?php echo ($user_info_meta["ds_user_organization"] == $ua_key) ? 'selected' : ''; ?>> <?php echo $organiz ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="callback__form-col w-2-4 mr-20">
                    <label class="uk-form-label cs-mb-9 uk-display-block">Научная степень</label>
                    <div class="uk-form-controls">
                        <select name="user_rate" class="ajax_edit">
                            <?php foreach ($metaValues["user_rate"]["choices"] as $ur_key => $rate) : ?>
                                <option value="<?php echo $ur_key ?>" <?php echo ($user_info_meta["ds_user_rate"] == $ur_key) ? 'selected' : ''; ?>> <?php echo $rate ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="callback__form-col w-2-4 mr-0">
                    <label class="uk-form-label cs-mb-9 uk-display-block">Сфера интересов</label>
                    <div class="uk-form-controls">
                        <select name="user_interest">
                            <?php foreach ($metaValues["user_interest"]["choices"] as $ui_key => $interes) : ?>
                                <option value="<?php echo $ui_key ?>" <?php echo (in_array($ui_key, $user_info_meta["ds_user_interest"])) ? 'selected' : ''; ?>> <?php echo $ui_key ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="soc-art__textarea-wrap w-100">
                    <label class="uk-form-label cs-mb-9 uk-display-block">Примечание к сфере интересов</label>
                    <textarea name="user_interest_note" class="soc-art__textarea" placeholder="Введите примечание"><?php echo $user_info_meta["user_interest_note"][0] ?? ''; ?></textarea>
                </div>

            </div>

            <div class="uk-flex uk-flex-middle edit-profile conferention__block mt-23">
                <div class="callback__form-col w-2-4 mr-20">
                    <label class="uk-form-label cs-mb-9 uk-display-block">Ссылка на Вконтакте</label>
                    <div class="uk-form-controls">
                        <input name="user_vk" class="uk-input cs-inpit" type="text" placeholder="Введите ссылку" value="<?php echo $user_info_meta["user_vk"][0] ?? ''; ?>">
                    </div>
                </div>
                <div class="callback__form-col w-2-4 mr-0">
                    <label class="uk-form-label cs-mb-9 uk-display-block">Ссылка на Facebook</label>
                    <div class="uk-form-controls">
                        <input name="user_fb" class="uk-input cs-inpit" type="text" placeholder="Введите ссылку" value="<?php echo $user_info_meta["user_fb"][0] ?? ''; ?>">
                    </div>
                </div>
                <div class="callback__form-col w-2-4 mr-20">
                    <label class="uk-form-label cs-mb-9 uk-display-block">Ссылка на Google</label>
                    <div class="uk-form-controls">
                        <input name="user_google" class="uk-input cs-inpit" type="text" placeholder="Введите ссылку" value="<?php echo $user_info_meta["user_google"][0] ?? ''; ?>">
                    </div>
                </div>


                <button type="submit" name="updateuser" id="updateuser" class="ghost-btn cs-btn btn btn-5 conferention__btn uk-flex-1">сохранить</button>
                <?php wp_nonce_field('update-user') ?>
                <input name="action" type="hidden" id="action" value="update-user" />
            </div>
        </form>

    </div>
    <script>
        // Маска на номер телефона
        var phoneMask = IMask(
            document.getElementById('phone-mask'), {
                mask: '+{1}(000)000-00-00'
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