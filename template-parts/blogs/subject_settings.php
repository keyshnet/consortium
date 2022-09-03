<?php
global $user_info, $user_info_meta;
if (current_user_can('administrator')) :
    if (isset($_GET['subject_id']) && intval($_GET['subject_id']) > 0) {
        $subject = get_term(intval($_GET['subject_id']));
    }

    if (!empty($subject)) :
        $metaValuesCurrent = get_field_objects('ds_objects_' . $subject->term_id);

        $metaValues = array();
        $metaValues['access_add_posts'] = acf_get_field('access_add_posts');
        $metaValues['access_add_posts']["title"] = "Разрешение на добавление публикаций в тематический раздел:";
        $metaValues['access_add_posts']["name_field_users"] = "id_users_add_posts";
        $metaValues['access_add_blogs'] = acf_get_field('access_add_blogs');
        $metaValues['access_add_blogs']["title"] = "Разрешение на добавление авторского блога в тематический раздел:";
        $metaValues['access_add_blogs']["name_field_users"] = "id_users_add_blogs";
?>

        <a href="#" onClick="history.back(); return false;" class="back-link">назад</a>
        <h1 class="settings__h1">Настройки тематического раздела “<?php echo $subject->name; ?>”</h1>
        <?php
        foreach ($metaValues as $metaKey => $metaValue) {
        ?>
            <h4 class="settings__title"><?php echo $metaValue["title"] ?> <i></i></h4>
            <div class="uk-margin-medium-bottom  container-access">
                <div class="uk-flex cs-radiobar access-check">
                    <?php foreach ($metaValue["choices"] as $c_key => $c_value) :
                        if (!empty($metaValuesCurrent[$metaValue["name"]]["value"]))
                            $checked = checked($metaValuesCurrent[$metaValue["name"]]["value"], $c_key, false);
                        else
                            $checked = checked($metaValue["default_value"], $c_key, false);
                    ?>
                        <input type="radio" <?php echo $checked; ?> name="<?php echo $metaValue["name"] ?>" id="<?php echo $c_key . '_' . $metaValue["name"] ?>" value="<?php echo $c_key ?>" data-users="<?php echo $metaValue["name_field_users"] ?>" class="ajax_edit">
                        <label for="<?php echo $c_key . '_' . $metaValue["name"] ?>" class="label-radio"><?php echo $c_value ?></label>
                    <?php endforeach ?>
                    <i></i>
                </div>
                <a href="#modal-center" class="btn-add-user ico-plus-circle-right" data-users="<?php echo $metaValue["name_field_users"] ?>" uk-toggle>Добавить пользователя</a>
                <div id="<?php echo $metaValue["name_field_users"] ?>"></div>
            </div>
        <?php
        }
        ?>

        <div id="modal-center" class="uk-flex-top" uk-modal>
            <div class="uk-modal-dialog uk-modal-body cs-modal-search uk-margin-auto-vertical">

                <button class="uk-modal-close-default search-close-but" type="button" uk-close></button>

                <h2 class="cs-modal-search__h2">Поиск пользователей</h2>
                <div class="cs-search uk-margin-medium-top friends__search uk-position-relative">
                    <input type="text" name="search_users" id="search_users" placeholder="Введите ФИО, телефон или электронную почту">
                    <div class="uk-flex uk-align-center uk-margin-remove">
                        <button class="btn-search bg-reset uk-flex uk-flex-center uk-flex-middle ico-search">
                        </button>
                    </div>
                </div>

                <div id="search_res"></div>
            </div>
        </div>

        <script>
            $(document).ready(function($) {
                access_show_users('.access-check input');
                $(".ajax_edit").on('change', function() {
                    var resPlace = $(this).parent('.access-check').find('i');
                    if ($(this).prop('checked')) {
                        update_field($(this).attr('name'), $(this).val(), 'ds_objects_<?php echo $subject->term_id ?>', resPlace);
                    }
                    access_show_users('.access-check input');
                });

                $(".search-close-but").on('click', function() {
                    $("#search_users").val("");
                    $("#search_res").html("");
                });
                UIkit.util.on('.btn-add-user', 'click', function(e) {
                    e.preventDefault();
                    var thisLink = $(this);
                    var thisLinkUsers = thisLink.data("users");
                    var thisModal = $(this).data("modal");
                    $("#search_users").on('keyup', function() {
                        if ($(this).val() > '') {
                            var ajaxdata = {
                                action: 'search_users',
                                nonce_code: myajax.nonce,
                                suser: $(this).val(),
                            };
                            $.post(
                                    myajax.url,
                                    ajaxdata,
                                    function(response) {
                                        if (response.result === 'ok') {
                                            $("#search_res").html(response.usersRes);
                                        } else {
                                            $("#search_res").html(response.message);
                                        }
                                    },
                                    'json')
                                .fail(function(response) {
                                    console.log('error');
                                });
                        }
                    });
                    $(document).on("click", ".addUser", function() {
                        var thisBut = $(this);
                        var ajaxdata = {
                            action: 'edit_field',
                            nonce_code: myajax.nonce,
                            chbxvalue: $(this).data('userid'),
                            chbxname: thisLinkUsers,
                            chbxpost: 'ds_objects_<?php echo $subject->term_id ?>',
                            addValue: true,
                        };
                        $.post(myajax.url, ajaxdata,
                                function(response) {
                                    console.log('response');
                                    if (response.result === 'ok') {
                                        find_acccess_users(thisLinkUsers, 'ds_objects_<?php echo $subject->term_id ?>', thisLinkUsers);
                                        $('<span style="color: green">Добавлен</span>').replaceAll(thisBut);

                                    } else {
                                        console.log('error');
                                    }
                                },
                                'json')
                            .fail(function(response) {
                                console.log('error');
                            });

                    });


                });
                $(document).on("click", ".removeUser", function() {
                    var thisBut = $(this);
                    var thisLinkUsers = thisBut.data("users");
                    var ajaxdata = {
                        action: 'edit_field',
                        nonce_code: myajax.nonce,
                        chbxvalue: $(this).data('userid'),
                        chbxname: $(this).data('users'),
                        chbxpost: 'ds_objects_<?php echo $subject->term_id ?>',
                        removeValue: true,
                    };
                    $.post(myajax.url, ajaxdata,
                            function(response) {
                                console.log('response');
                                if (response.result === 'ok') {
                                    find_acccess_users(thisLinkUsers, 'ds_objects_<?php echo $subject->term_id ?>', thisLinkUsers);
                                    $(this).parent().fadeOut(2000);

                                } else {
                                    console.log('error');
                                }
                            },
                            'json')
                        .fail(function(response) {
                            console.log('error');
                        });

                });

                function access_show_users(element) {
                    $(element).each(function() {
                        $(this).parents('.container-access').find('.btn-add-user').hide();
                        if ($(this).is(":checked") && $(this).val() == 'users') {
                            $(this).parents('.container-access').find('.btn-add-user').show();
                            find_acccess_users($(this).data('users'), 'ds_objects_<?php echo $subject->term_id ?>', $(this).data('users'));
                        }
                    });
                }
            });
        </script>

    <?php
    else :
        echo '<h4 class="settings__title">Тематический раздел не найден</h4>';
    endif;

    ?>
<?php
else :
?>
    <div class="soc-other-user">
        У вас нет доступа к этой странице!
    </div>
<?php
endif;
?>