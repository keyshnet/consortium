<?php
/*Редактирование/Добавление блога*/
function ds_ajax_edit_blog()
{
    if (!isset($_POST['update_blog_nonce_field']) || !wp_verify_nonce($_POST['update_blog_nonce_field'], 'update_blog_action')) {
        echo '{"result": "error", "message": "Произошла неизвестная ошибка, попробуйте позже!"}';
    } else {
        $blogNewArgs = array();
        $blogNewArgs["term_id"] = intval($_POST["blog_id"]);

        if (!empty($_POST['name']))
            $blogNewArgs["name"] = sanitize_text_field($_POST['name']);
        if (!empty($_POST['slug']))
            $blogNewArgs["slug"] = sanitize_text_field($_POST['slug']);
        if (!empty($_POST['description']))
            $blogNewArgs["description"] = esc_attr($_POST['description']);
        if (!empty($blogNewArgs)) {
            if ($blogNewArgs["term_id"] > 0) {
                $updateBlogRes = wp_update_term($blogNewArgs["term_id"], 'ds_blogs', $blogNewArgs);
            } else {
                $updateBlogRes = wp_insert_term($blogNewArgs["name"], 'ds_blogs', $blogNewArgs);
                update_field('blog_author', intval($_POST['user_id']), 'ds_blogs_' . $blogNewArgs["term_id"]);
            }

            if (is_wp_error($updateBlogRes)) {
                echo $updateBlogRes->get_error_message();
            } else {
                echo '{"result": "ok", "message": "Изменения успешно сохранены!"}';
                update_field('subjet', esc_attr($_POST['ds_objects']), 'ds_blogs_' . $blogNewArgs["term_id"]);
                //                $blog = get_post($updateBlogRes);
            }
        } else {
            echo '{"result": "error", "message": "Не все поля заполнены"}';
        }
    }

    wp_die();
}
add_action('wp_ajax_add_blog', 'ds_ajax_edit_blog');
add_action('wp_ajax_nopriv_add_blog', 'ds_ajax_edit_blog');
add_action('wp_ajax_edit_blog', 'ds_ajax_edit_blog');
add_action('wp_ajax_nopriv_edit_blog', 'ds_ajax_edit_blog');

/*Редактирование поля*/
function ds_ajax_edit_field()
{
    if (!wp_verify_nonce($_POST['nonce_code'], 'myajax-nonce')) {
        echo 'Произошла ошибка';
        wp_die();
    }
    $chbxvalue = sanitize_text_field($_POST["chbxvalue"]);
    $chbxname = sanitize_text_field($_POST["chbxname"]);
    $chbxpost = sanitize_text_field($_POST["chbxpost"]);
    $addValue = sanitize_text_field($_POST["addValue"]);
    $removeValue = sanitize_text_field($_POST["removeValue"]);
    if (!empty($chbxvalue) and !empty($chbxname) and !empty($chbxpost)) {
        if ($addValue) {
            $values = array();
            $values = (array)get_field($chbxname, $chbxpost);
            if (!empty($values))
                $chbxvalue = array_merge(array($chbxvalue), $values);
            //            m_p($chbxvalue);
        }
        if ($removeValue) {
            $values = (array)get_field($chbxname, $chbxpost);
            //            m_p($values);
            //            m_p($values[array_search($chbxvalue,$values)]);
            unset($values[array_search($chbxvalue, $values)]);
            $chbxvalue = $values;
        }
        if (update_field($chbxname, $chbxvalue, $chbxpost))
            echo '{"result": "ok", "message": "Сохранено"}';
        else {
            echo '{"result": "error", "message": "Произошла ошибка"}';
        }
    } else {
        echo '{"result": "error", "message": "Произошла ошибка"}';
    }

    wp_die();
}
add_action('wp_ajax_edit_field', 'ds_ajax_edit_field');
add_action('wp_ajax_nopriv_edit_field', 'ds_ajax_edit_field');


/*Поиск пользователей*/
function ds_ajax_search_users()
{
    if (!wp_verify_nonce($_POST['nonce_code'], 'myajax-nonce')) {
        echo 'Произошла ошибка';
        wp_die();
    }
    $suser = sanitize_text_field($_POST["suser"]);

    if (!empty($suser)) {
        $users = get_users([
            //            'role'         => 'authors',
            //            'meta_key'     => '',
            //            'meta_value'   => '',
            //            'meta_compare' => '',
            //            'meta_query'   => array(),
            'search'       => '*' . $suser . '*',
            //            'search_columns' => array(),
            'fields'       => array('ID', 'display_name'),
            //            'who'          => '',
            //            'date_query'   => array() // смотрите WP_Date_Query
        ]);
        if (!empty($users)) {
            $resHtml = array();
            $resHtml["result"] = "ok";
            $resHtml["message"] = "Найдено";
            $resHtml["usersRes"] = "";
            foreach ($users as $user) {
                $user_organization = get_field('user_organization', 'user_' . $user->ID);
                $resHtml['usersRes'] .= '
                <div class="friends__my">
                  <div class="friends__my_ls">
                    <div class="friends__my_img">' . get_avatar($user->ID) . '</div>
                    <div>
                      <div class="friends__my_name">' . $user->display_name . '</div>
                      <div class="friends__my_pos">' . $user_organization . '</div>
                    </div>
                  </div>
                  <div class="friends__my_rs">
                    <a href="#" data-userid="' . $user->ID . '" class="addUser cs-btn-border btn btn-5 ico-plus-right uk-margin-remove">
                      добавить
                    </a>
                  </div>
                </div>
            ';
            }

            $userRes = wp_json_encode($resHtml);
            //        m_p($userRes);
            echo $userRes;
        } else
            echo '{"result": "error", "message": "Ничего не найдено!"}';
    } else {
        echo '{"result": "error", "message": "Произошла ошибка"}';
    }

    wp_die();
}
add_action('wp_ajax_search_users', 'ds_ajax_search_users');
add_action('wp_ajax_nopriv_search_users', 'ds_ajax_search_users');


/*Поиск пользователей с правами*/
function ds_ajax_search_users_access()
{
    if (!wp_verify_nonce($_POST['nonce_code'], 'myajax-nonce')) {
        echo 'Произошла ошибка';
        wp_die();
    }
    $field = sanitize_text_field($_POST["field"]);
    $postid = sanitize_text_field($_POST["postid"]);
    $usersRes = array();

    if (!empty($field) and !empty($postid)) {
        $usersRes['result'] = "ok";
        $users = get_field($field, $postid);
        $userArray = array();
        foreach ($users as $user) {
            $userArray[$user] = get_user_by('ID', $user)->data->display_name;
        }


        $usersRes['message'] = $userArray;
        //        m_p($userArray);
        echo wp_json_encode($usersRes);
    } else {
        echo '{"result": "error", "message": "Пустые значения"}';
    }

    wp_die();
}
add_action('wp_ajax_search_users_access', 'ds_ajax_search_users_access');
add_action('wp_ajax_nopriv_search_users_access', 'ds_ajax_search_users_access');



//  Ajax Login
function ajax_login_init()
{

    /* Подключаем скрипт для авторизации */
    wp_register_script('ajax-login-script', get_template_directory_uri() . '/assets/js/ajax-login-script.js', array('jquery'));
    wp_enqueue_script('ajax-login-script');

    /* Локализуем параметры скрипта */
    wp_localize_script('ajax-login-script', 'ajax_login_object', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'redirecturl' => $_SERVER['REQUEST_URI'],
        'loadingmessage' => __('Проверяются данные, секундочку...')
    ));

    // Разрешаем запускать функцию ajax_login() пользователям без привелегий
    add_action('wp_ajax_nopriv_ajaxlogin', 'ajax_login');
}

// Выполняем авторизацию только если пользователь не вошел
if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_init');
}

function ajax_login()
{

    // Первым делом проверяем параметр безопасности
    check_ajax_referer('ajax-login-nonce', 'security');

    // Получаем данные из полей формы и проверяем их
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon($info, false);
    //    if ( is_wp_error($user_signon) ){
    //        echo json_encode(array('loggedin'=>false, 'message'=>__('Неправильный логин или пароль!')));
    //    } else {
    //        echo json_encode(array('loggedin'=>true, 'message'=>__('Отлично! Идет перенаправление...')));
    //    }

    die();
}
