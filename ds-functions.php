<?php

function m_p($array){
	echo "start print_r";
	echo "<pre>";
	print_r($array);
	echo "</pre>";
	echo "end print_r";
}

function ds_back_link(){
    echo '<a href="#" onClick="history.back(); return false;" class="back-link">назад</a>';
}

// echo get_page_template();
// global $template;
// echo $template;

function custom_rewrite_basic() {
  add_rewrite_rule('^social-network/user/([^/]*)/?', 'index.php?user_profile=$matches[1]', 'top');
}
add_action('init', 'custom_rewrite_basic');


function custom_rewrite_tag() {
  add_rewrite_tag('%user_profile%', '([^&]+)');
}
add_action('init', 'custom_rewrite_tag', 10, 0);

function get_image_cat($catId, $imgField, $custom = '') {
	$imgSrc = "/wp-content/themes/neve-child/img/no_image_news.png";

	if ($catId && $imgField ){
		if($custom)
			$imgId = get_field('image', $custom."_".$catId);
		else
			$imgId = get_term_meta($catId, $imgField, true);
		
		if($imgId > 0)
			$imgSrc = wp_get_attachment_image_src( $imgId, 'full' )[0];
	};
	return $imgSrc;
}

function get_image_post($postId, $custom = '') {
    $imgSrc = "/wp-content/themes/neve-child/img/no_image_news.png";

    if (has_post_thumbnail($postId) ){
        $imgSrc = get_the_post_thumbnail_url($postId);
    };
    return $imgSrc;
}

add_action( 'init', 'ds_register_post_types' );
function ds_register_post_types(){
	register_post_type( 'ds_network', [
		'label'  => null,
		'labels' => [
			'name'               => 'Социальная сеть', // основное название для типа записи
			'singular_name'      => 'Публикация', // название для одной записи этого типа
			'add_new'            => 'Добавить публикацию', // для добавления новой записи
			'add_new_item'       => 'Добавление публикации', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактирование публикации', // для редактирования типа записи
			'new_item'           => 'Новая публикация', // текст новой записи
			'view_item'          => 'Смотреть публикацию', // для просмотра записи этого типа.
			'search_items'       => 'Искать публикацию', // для поиска по этим типам записи
			'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'all_items'          => 'Все публикации',
		],
		'menu_icon'           => 'dashicons-admin-site',
		'public'              => true,
		'supports'            => [ 'title', 'editor', 'author','thumbnail','custom-fields','excerpt','comments' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','revisions','page-attributes','post-formats'
		'rewrite'      => array( 'slug' => 'social-network-blog' ),
	] );

    register_taxonomy( 
    	'ds_objects',
    	'ds_network', 
    	array(
	        'label'        => 'Тематические направления',
	        'rewrite'      => array( 'slug' => 'network-objects' ),
	        'hierarchical' => true
	    )
    );

    register_taxonomy( 
    	'ds_blogs',
    	'ds_network', 
    	array(
	        'label'        => 'Блоги',
	        'rewrite'      => array( 'slug' => 'social-network/blog' ),
	        'hierarchical' => true,
	    )
    );
}

function ds_after_content(){
	global $wp_query, $user_info, $user_info_meta;
    if(!empty($wp_query->query_vars['user_profile'])) {

        $userId = get_user_by('login', $wp_query->query_vars['user_profile'])->ID??'';
        if($userId >0 ) {
            $verified = get_field('verified', 'user_' . $userId);
            $user_role_blog = get_field('user_role_blog', 'user_' . $userId);
            if($user_role_blog == "Не аффилированное лицо" OR $verified == true){
                $user_info = get_user_by('login', $wp_query->query_vars['user_profile']);
                $user_info_meta = get_user_meta($userId);
            }
        }
    } else {
        $user_info = wp_get_current_user();
        $user_info_meta = get_user_meta(wp_get_current_user()->ID);
    }
    if($user_info_meta) {
        //$user_info_meta["ds_user_avatar_url"] = ds_get_avatar($user_info->ID);
//        $user_info_meta["ds_user_avatar_url"] = !empty($user_info_meta["user_avatar"][0]) ? get_field('user_avatar', 'user_' . $user_info->ID)["url"] : get_template_directory_uri() . '/assets/img/no-avatar.png';
        $user_info_meta["ds_user_interest"] = !empty($user_info_meta["user_interest"][0]) ? get_field('user_interest', 'user_' . $user_info->ID) : "";
        $user_info_meta["ds_interest"] = !empty($user_info_meta["interest"][0]) ? get_field('interest', 'user_' . $user_info->ID) : "";
        $user_info_meta["ds_user_organization"] = !empty($user_info_meta["user_organization"][0]) ? get_field('user_organization', 'user_' . $user_info->ID) : "";
        $user_info_meta["ds_user_rate"] = !empty($user_info_meta["user_rate"][0]) ? get_field('user_rate', 'user_' . $user_info->ID) : "";
    }

//	if(!empty($wp_query->query_vars['user_profile'])) {
//	    $user_info = get_user_by('login', $wp_query->query_vars['user_profile']);
//	} else {
//	    $user_info = wp_get_current_user();
//	}
//	if($user_info){
//		$user_info->data_more = ds_get_user_dop_info( $user_info->ID );
//		$user_info->data->data_more["ds_user_avatar_url"] = isset($user_info->data->data_more["user_avatar"]["url"])?: get_template_directory_uri().'/assets/img/no-avatar.png';
//	}
}
function ds_get_avatar($userId){
    $avatar = get_template_directory_uri() . '/assets/img/no-avatar.png';
    if($userId){
        $avatarArr = get_field('user_avatar', 'user_' . $userId);
        if(!empty($avatarArr))
            $avatar = $avatarArr["url"];
    }
    return $avatar;
}
add_filter( 'avatar_defaults', 'add_default_avatar_option' );
function add_default_avatar_option( $avatars ){
    $url = get_stylesheet_directory_uri() . '/assets/img/no-avatar.png';
    $avatars[ $url ] = 'Аватар сайта';
    return $avatars;
}

//function ds_get_user_dop_info($userId = false){
//		global $user_info;
//		$userArray = array();
//
//		if($user_info->ID > 0){
//			$userArray = (array)get_field_objects( 'user_'.$userId);
//		}
//
//		return $userArray;
//}
function ds_get_meta_values($postId){
    $metaArray = array();

    if(strlen($postId) > 0){
        $metaArray = get_field_objects( $postId);
    }
    return $metaArray;
}

/* check accsess */
function ds_check_accsess($field = false, $postId = false, $userId = false, $accsess = "read"){
    if(!is_user_logged_in())
        return false;

    if(current_user_can('administrator'))
        return true;

    if(!$userId)
        $userId = get_current_user_id();

    $accessValue = get_field($field, $postId);
    if($accessValue == "none")
        return false;
    elseif($accessValue == "friends") {
        $user_friends = get_field( 'friends',  $postId);
        if(in_array($userId, $user_friends))
            return true;
        else
            return false;
    }
    else
        return true;
}

/* check accsess Subjects*/
function check_accsess_subj($accsess = "read", $subjId = false, $userId = false){
    if(!is_user_logged_in())
        return false;

    if(!$userId)
        $userId = get_current_user_id();

    if($accsess == "read"){
        $access_read = get_field('access_read_subj', "ds_objects_".$subjId);
        if($access_read == "all")
            return true;
        else{
            $accessReadUsers = get_field('id_users_read_subj', "ds_objects_".$subjId);
            if($accessReadUsers AND in_array($userId, $accessReadUsers)){
                return true;
            }else{
                return false;
            }
        }
    }
}
    /* check accsess blog */
function check_accsess_blog($typePost = false, $postId = false, $accsess = "read", $userId = false)
{
    if (!is_user_logged_in())
        return false;

    $typePostTax = false;
    if ($typePost == "blog")
        $typePostTax = "ds_blogs_";
    elseif ($typePost = "subj")
        $typePostTax = "ds_objects_";
    elseif ($typePost = "network")
        $typePostTax = "ds_network_";
    else
        $typePostTax = $typePost;


    if (!$userId) {
        $userId = get_current_user_id();

        if (current_user_can('administrator') or get_field('blog_author', $typePostTax . $postId)["ID"] == $userId)
            return true;

        if($accsess == "read"){
            $access_read = get_field('access_read', $typePostTax . $postId);
            if($access_read == "all")
                return true;
            else{
                $accessReadUsers = get_field('access_read_users', $typePostTax . $postId);
                if($accessReadUsers AND in_array($userId, $accessReadUsers)){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }
}

function ds_show_post_blog($postFilter)
{
    if(!empty($postFilter))
        get_template_part( 'template-parts/blocks/posts', null, $postFilter );
}
function ds_show_blogs($blogsFilter)
{
    if(!empty($blogsFilter))
        get_template_part( 'template-parts/blocks/blogs', null, $blogsFilter );
}
function ds_show_confs($confsFilter)
{
    if(!empty($confsFilter))
        get_template_part( 'template-parts/blocks/confs', null, $confsFilter );
}

function ds_count_favorites($postId)
{
    if($postId <= 0)
        return 0;

    $meta_query = array(
        'relation'		=> 'OR',
        array(
            'key'     => 'favorites_posts',
            'value'   => $postId,
            'compare' => 'LIKE',
        ),
    );
    $args = array(
        'posts_per_page' => -1,
        'meta_query' => $meta_query,
        'fields'       => array('ID'),
    );
    $favs = get_users($args);
    return count($favs);
}



function get_excerpt($limit, $source = null){

    $excerpt = $source == "content" ? get_the_content() : get_the_excerpt();
    $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $limit);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
    $excerpt = $excerpt.'...';
    return $excerpt;
}
