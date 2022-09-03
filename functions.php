<?php
define('URL_NETWORK', 'social-network');
define('CAT_NEWS_ID', 89);

require_once(dirname(__FILE__) . "/ds-functions.php");
require_once(dirname(__FILE__) . "/functions-ajax.php");


add_theme_support( 'post-thumbnails' );
add_theme_support( 'title-tag' );
add_theme_support( 'menus' );

add_action( 'init', 'add_excerpts_to_pages' );
function add_excerpts_to_pages() {
    add_post_type_support( 'page', 'excerpt' );
}


add_action( 'wp_enqueue_scripts', 'theme_enqueue_files' );
function theme_enqueue_files() {
//    $theme = wp_get_theme();
    wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style( 'uikit', get_template_directory_uri(). '/assets/uikit/css/uikit.min.css' );
    wp_enqueue_style( 'style-verstka', get_template_directory_uri() . '/assets/css/style.min.css');
    // wp_enqueue_style( 'query-ui', get_template_directory_uri() . '/assets/css/query-ui.min.css');
    // wp_enqueue_style( 'query-ui-theme', get_template_directory_uri() . '/assets/css/jquery-ui.theme.min.css');


    wp_enqueue_script( 'uikit', get_template_directory_uri(). '/assets/uikit/js/uikit.min.js' );
    wp_enqueue_script( 'uikit-icons', get_template_directory_uri(). '/assets/uikit/js/uikit-icons.min.js' );
    wp_enqueue_script( 'jquery-my', get_template_directory_uri(). '/assets/js/jquery-3.6.0.min.js' );
    wp_enqueue_script( 'jquery-ui.min.js', get_template_directory_uri(). '/assets/js/jquery-ui.min.js' );
    wp_enqueue_script( 'custom-select', get_template_directory_uri(). '/assets/js/jq-custom-select.js' );
    wp_enqueue_script( 'custom', get_template_directory_uri(). '/assets/js/custom.js' );
    wp_enqueue_script( 'unpkg', 'https://unpkg.com/imask' );

   wp_localize_script( 'custom-select', 'myajax',
       array(
           'url' => admin_url('admin-ajax.php'),
           'nonce' => wp_create_nonce('myajax-nonce')
       )
   );

    wp_dequeue_style('eb-public-jquery-ui-css');
    wp_deregister_style('eb-public-jquery-ui-css');
}


// function remove_jquery_migrate( &$scripts ) {
//  if( !is_admin() ) {
//  $scripts->remove( 'jquery' );
//  $scripts->add( 'jquery', false, array( 'jquery-core' ), '1.12.4' );
//  }
// }
// add_filter( 'wp_default_scripts', 'remove_jquery_migrate' );

/* Подсчет количества посещений страниц
---------------------------------------------------------- */
add_action('wp_head', 'kama_postviews');
function kama_postviews() {

    /* ------------ Настройки -------------- */
    $meta_key		= 'views';	// Ключ мета поля, куда будет записываться количество просмотров.
    $who_count 		= 0; 			// Чьи посещения считать? 0 - Всех. 1 - Только гостей. 2 - Только зарегистрированых пользователей.
    $exclude_bots 	= 1;			// Исключить ботов, роботов, пауков и прочую нечесть :)? 0 - нет, пусть тоже считаются. 1 - да, исключить из подсчета.
    /* СТОП настройкам */

    global $user_ID, $post;
    if(is_singular()) {
        $id = (int)$post->ID;
        static $post_views = false;
        if($post_views) return true; // чтобы 1 раз за поток
        $post_views = (int)get_post_meta($id,$meta_key, true);
        $should_count = false;
        switch( (int)$who_count ) {
            case 0: $should_count = true;
                break;
            case 1:
                if( (int)$user_ID == 0 )
                    $should_count = true;
                break;
            case 2:
                if( (int)$user_ID > 0 )
                    $should_count = true;
                break;
        }
        if( (int)$exclude_bots==1 && $should_count ){
            $useragent = $_SERVER['HTTP_USER_AGENT'];
            $notbot = "Mozilla|Opera"; //Chrome|Safari|Firefox|Netscape - все равны Mozilla
            $bot = "Bot/|robot|Slurp/|yahoo"; //Яндекс иногда как Mozilla представляется
            if ( !preg_match("/$notbot/i", $useragent) || preg_match("!$bot!i", $useragent) )
                $should_count = false;
        }

        if($should_count)
            if( !update_post_meta($id, $meta_key, ($post_views+1)) ) add_post_meta($id, $meta_key, 1, true);
    }
    return true;
}

// pagination
function wp_corenavi() {
    global $wp_query;
    $total = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
    if (!$current = get_query_var('paged')) $current = 1;
    $a['total'] = $total;
    $a['mid_size'] = 3; // сколько ссылок показывать слева и справа от текущей
    $a['end_size'] = 1; // сколько ссылок показывать в начале и в конце
    $a['prev_text'] = '&laquo;'; // текст ссылки "Предыдущая страница"
    $a['next_text'] = '&raquo;'; // текст ссылки "Следующая страница"
    $a['current'] = $current;

    $nav = paginate_links( $a );
    $search = array('', '<a', '</a>');
    $replace = array('', '<li><a', '</a></li>');
    $nav = str_replace($search, $replace, $nav);
    $nav = preg_replace('/<span (.*) class="(.*) current">(.*)<\/span>/', '<li  class="uk-active"><span>$3</span></li>', $nav);
    $nav = preg_replace('/<span class="(.*) dots">(.*)<\/span>/', '<li  class="uk-disabled"><span>$2</span></li>', $nav);

    if ( $total > 1 ) echo '<ul class="uk-pagination cs-pagination uk-flex-center uk-margin-large-bottom">';
    echo $nav;

    if ( $total > 1 ) echo '</ul>';
}

function only_admin()
{
    if ( ! current_user_can( 'manage_options' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {
        wp_redirect( site_url() );
    }
}
add_action( 'admin_init', 'only_admin', 1 );
add_filter('show_admin_bar', '__return_false');
