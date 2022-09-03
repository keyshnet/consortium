<?php
//$container_class = apply_filters( 'neve_container_class_filter', 'container', 'blog-archive' );
?>
<section class="cat_block settings_cat_block elementor-section elementor-top-section elementor-element elementor-element-51df6a5 elementor-section-boxed elementor-section-height-default elementor-section-height-default">
    <div class="elementor-container elementor-column-gap-default">
        <div class="back_link">
            <a href="javascript:history.back()"><svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13 6.5C13 6.25377 12.9144 6.01763 12.7621 5.84352C12.6097 5.66941 12.4031 5.5716 12.1876 5.5716H2.77502L6.2635 1.58689C6.41605 1.41256 6.50175 1.17612 6.50175 0.929577C6.50175 0.683038 6.41605 0.446596 6.2635 0.272267C6.11095 0.0979375 5.90405 0 5.68832 0C5.47258 0 5.26568 0.0979375 5.11313 0.272267L0.238676 5.84269C0.163019 5.92893 0.102994 6.03138 0.0620384 6.14417C0.0210829 6.25697 0 6.37788 0 6.5C0 6.62212 0.0210829 6.74303 0.0620384 6.85583C0.102994 6.96862 0.163019 7.07107 0.238676 7.15731L5.11313 12.7277C5.26568 12.9021 5.47258 13 5.68832 13C5.90405 13 6.11095 12.9021 6.2635 12.7277C6.41605 12.5534 6.50175 12.317 6.50175 12.0704C6.50175 11.8239 6.41605 11.5874 6.2635 11.4131L2.77502 7.4284H12.1876C12.4031 7.4284 12.6097 7.33059 12.7621 7.15648C12.9144 6.98237 13 6.74623 13 6.5Z" fill="#DC3333" />
                </svg>назад</a>
        </div>
        <?php if (current_user_can('administrator')) {  ?>
            <div class="blogs_title flex">
                <div class="f34">
                    <h2>Настройки блога “<?php echo get_the_archive_title(); ?>”</h2>
                </div>
            </div>
            <div class="cat_settings_setup" data-id="<?php echo $c_id; ?>">
                <div class="cat_reading">
                    <h3>Чтение блога:</h3>
                    <div class="cat_reading_type">
                        <?php // print_r(get_term_meta($c_id, 'reading_type', true));
                        $reading_type = get_term_meta($c_id, 'reading_type', true) ?>
                        <label><input type="radio" value="0" <?php checked($reading_type, '0') ?> name="cat_reading_type"> Всем</label>
                        <label><input type="radio" value="1" <?php checked($reading_type, '1') ?> name="cat_reading_type"> Выбранным пользователям</label>
                    </div>
                    <div class="access_members cat_reading_members <?php if ($reading_type == '0') {
                                                                        echo 'sending';
                                                                    } ?>">
                        <div class="add_members" data-type="reading">
                            Добавить пользователя <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#DC3333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M12 8V16" stroke="#DC3333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M8 12H16" stroke="#DC3333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div class="access_members_inner">
                            <?php $cat_reading_members = get_term_meta($c_id, 'cat_reading_members', true);
                            if ($cat_reading_members) {
                                $str_arr = preg_split("/\,/", $cat_reading_members);
                                foreach ($str_arr as $str) {
                                    if ($str != '') {
                            ?>
                                        <div class="user_found flex middle" data-user="<?php echo $str; ?>">
                                            <div class="image f5"></div>
                                            <div class="user_title f34">
                                                <?php $user = get_userdata($str);
                                                echo $user->display_name; ?> <div class="add_user" data-type="reading"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#DC3333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M12 8V16" stroke="#DC3333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M8 12H16" stroke="#DC3333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
                                                </div>
                                                <div class="del_user" data-type="reading"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M2.25 4.5H3.75H15.75" stroke="#DC3333" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M6 4.5V3C6 2.60218 6.15804 2.22064 6.43934 1.93934C6.72064 1.65804 7.10218 1.5 7.5 1.5H10.5C10.8978 1.5 11.2794 1.65804 11.5607 1.93934C11.842 2.22064 12 2.60218 12 3V4.5M14.25 4.5V15C14.25 15.3978 14.092 15.7794 13.8107 16.0607C13.5294 16.342 13.1478 16.5 12.75 16.5H5.25C4.85218 16.5 4.47064 16.342 4.18934 16.0607C3.90804 15.7794 3.75 15.3978 3.75 15V4.5H14.25Z" stroke="#DC3333" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M7.5 8.25V12.75" stroke="#DC3333" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M10.5 8.25V12.75" stroke="#DC3333" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                            <?php }
                                }
                            } ?>

                        </div>
                    </div>
                </div>
            </div>

            <?php
            /*$user_name = 'Оль';
            $users = new WP_User_Query( array(
                'search'         => '*'.esc_attr( $user_name ).'*',
                'search_columns' => array(
                    'user_login',
                    'user_nicename',
                    'user_email',
                    'display_name',
                ),
            ) );
            $users_found = $users->get_results();

            foreach ($users_found as $user) {
                echo '<div class="user_found" data-user="'.$user->data->ID.'">'.$user->data->display_name.'</div>';
            }*/
            ?>

            <script>
                jQuery(document).ready(function($) {
                    var cat_id = <?php echo $c_id; ?>;
                    var search_type = '';
                    $('input[type=radio][name=cat_reading_type]').on('change', function() {
                        $('.cat_reading_type').addClass('sending');
                        if (this.value === '0') {
                            $(this).parent().parent().next().addClass('sending');
                        } else if (this.value === '1') {
                            $(this).parent().parent().next().removeClass('sending');
                        }
                        var ajaxdata = {
                            action: 'cat-reading',
                            nonce_code: myajax.nonce,
                            cat: cat_id,
                            reading_type: this.value
                        };
                        jQuery.post(myajax.url, ajaxdata, function(response) {
                            if (response === 'ok') {
                                $('.cat_reading_type').removeClass('sending');
                            }
                        });
                    });
                    $('input[type=radio][name=cat_public_type]').on('change', function() {
                        $('.cat_public_type').addClass('sending');
                        if (this.value === '0') {
                            $(this).parent().parent().next().addClass('sending');
                        } else if (this.value === '1') {
                            $(this).parent().parent().next().removeClass('sending');
                        }
                        var ajaxdata = {
                            action: 'cat-public',
                            nonce_code: myajax.nonce,
                            cat: cat_id,
                            public_type: this.value
                        };
                        jQuery.post(myajax.url, ajaxdata, function(response) {
                            if (response === 'ok') {
                                $('.cat_public_type').removeClass('sending');
                            }
                        });
                    });
                    $('input[type=radio][name=cat_blog_type]').on('change', function() {
                        $('.cat_blog_type').addClass('sending');
                        if (this.value === '0') {
                            $(this).parent().parent().next().addClass('sending');
                        } else if (this.value === '1') {
                            $(this).parent().parent().next().removeClass('sending');
                        }
                        var ajaxdata = {
                            action: 'cat-blog',
                            nonce_code: myajax.nonce,
                            cat: cat_id,
                            blog_type: this.value
                        };
                        jQuery.post(myajax.url, ajaxdata, function(response) {
                            if (response === 'ok') {
                                $('.cat_blog_type').removeClass('sending');
                            }
                        });
                    });


                    $('.add_members').on('click', function() {
                        $('input[name="seach_menbers"]').val('').attr('data-type', $(this).data('type'));
                        search_type = $(this).data('type');
                        $('body').addClass('members_open');
                        $('.pop_up_members').html('');
                    });

                    /* добавление пользователя с попапа */
                    $('body').on('click', '.add_user', function() {
                        if ($(this).data('type') == 'reading') {
                            var us = $(this).parent().parent();
                            $(this).parent().parent().remove();
                            $('.cat_reading_members .access_members_inner').append(us);
                        }
                        if ($(this).data('type') == 'public') {
                            var us = $(this).parent().parent();
                            $(this).parent().parent().remove();
                            $('.cat_public_members .access_members_inner').append(us);
                        }
                        if ($(this).data('type') == 'blog') {
                            var us = $(this).parent().parent();
                            $(this).parent().parent().remove();
                            $('.cat_blog_members .access_members_inner').append(us);
                        }

                        update_users($(this).data('type'), cat_id);
                    });

                    /*удаление пользователя*/
                    $('body').on('click', '.del_user', function() {
                        if ($(this).data('type') == 'reading') {
                            $(this).parent().parent().remove();
                        }
                        if ($(this).data('type') == 'public') {
                            $(this).parent().parent().remove();
                        }
                        if ($(this).data('type') == 'blog') {
                            $(this).parent().parent().remove();
                        }
                        update_users($(this).data('type'), cat_id);
                    });

                    /* поиск пользователя, начиная с 3 символов */
                    $('body').on('keyup', 'input[name="seach_menbers"]', function() {
                        var value = $(this).val();
                        //var type = $(this).data('type');
                        var type = search_type;
                        if (value.length >= 3) {
                            var ajaxdata = {
                                action: 'members-search',
                                nonce_code: myajax.nonce,
                                cat: cat_id,
                                user_name: value,
                                search_type: type
                            };
                            jQuery.post(myajax.url, ajaxdata, function(response) {
                                $('.pop_up_members').html(response);
                            });
                        }
                    });

                    /* обновление пользователей в админке  */
                    function update_users(type, id) {
                        if (type === 'reading') {
                            var users_value = '';
                            $('.cat_reading_members .user_found').each(function(index) {
                                users_value = users_value + $(this).data('user') + ', ';
                            });
                        }
                        if (type === 'public') {
                            var users_value = '';
                            $('.cat_public_members .user_found').each(function(index) {
                                users_value = users_value + $(this).data('user') + ', ';
                            });
                        }
                        if (type === 'blog') {
                            var users_value = '';
                            $('.cat_blog_members .user_found').each(function(index) {
                                users_value = users_value + $(this).data('user') + ', ';
                            });
                        }
                        console.log(type);
                        var ajaxdata = {
                            action: 'members-save',
                            nonce_code: myajax.nonce,
                            cat: id,
                            field_type: type,
                            users: users_value
                        };
                        jQuery.post(myajax.url, ajaxdata, function(response) {
                            console.log(response);
                        });
                    }
                });
            </script>
        <?php } else {
            echo '<h2>У вас нет доступа к данной странице</h2>';
        } ?>

    </div>
</section>
<?php if (current_user_can('administrator')) {  ?>
    <div class="pop_up members_box">
        <div class="pop_up_cls">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13.5 4.5L4.5 13.5" stroke="#DC3333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M4.5 4.5L13.5 13.5" stroke="#DC3333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
        <div class="pop_up_inner">
            <h2>Поиск пользователей</h2>
            <form method="get" class="search-form" action="/">
                <input type="search" class="search-field ui-autocomplete-input" placeholder="Искать пользователя..." value="" name="seach_menbers" autocomplete="off">
                <button type="submit" class="search-submit" aria-label="Поиск">
                    <span class="nv-search-icon-wrap">
                        <div role="button" class="nv-icon nv-search">
                            <svg width="15" height="15" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1216 832q0-185-131.5-316.5t-316.5-131.5-316.5 131.5-131.5 316.5 131.5 316.5 316.5 131.5 316.5-131.5 131.5-316.5zm512 832q0 52-38 90t-90 38q-54 0-90-38l-343-342q-179 124-399 124-143 0-273.5-55.5t-225-150-150-225-55.5-273.5 55.5-273.5 150-225 225-150 273.5-55.5 273.5 55.5 225 150 150 225 55.5 273.5q0 220-124 399l343 343q37 37 37 90z"></path>
                            </svg>
                        </div>
                    </span>
                </button>
            </form>
            <div class="pop_up_members">

            </div>
        </div>
    </div>
<?php } ?>