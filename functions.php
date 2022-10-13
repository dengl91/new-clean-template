<?php
/**
 * functions.php
 * @package WordPress
 * @subpackage new-clean-template-3
 * @author: DHL
 * Author URI: telegram @dhljob
 */

/**
 * Define theme version
 */
$theme = wp_get_theme();
define( 'THEME_VERSION', $theme->Version );

/**
 * Add title tag support
 */
add_theme_support( 'title-tag' );

/**
 * Add menu positions
 */
register_nav_menus( array(
	'top'    => 'top',
	'bottom' => 'bottom'
));

/**
 * Theme image sizes
 */
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 250, 150 );
add_image_size( 'big-thumb', 400, 400, true );

/**
 * Sidebar
 */
register_sidebar( array(
	'name' 		    => 'sidebar',
	'id'   		    => 'sidebar',
	'description'   => 'Simple sidebar', 
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget'  => '</div>\n',
	'before_title'  => '<span class="widgettitle">',
	'after_title'   => '</span>\n'
));

/**
 * Comment constructor
 */
if ( !class_exists( 'clean_comments_constructor' ) ) {
	class clean_comments_constructor extends Walker_Comment {
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$output .= '<ul class="children">' . '\n';
		}
		public function end_lvl( &$output, $depth = 0, $args = array() ) {
			$output .= "</ul><!-- .children -->\n";
		}
	    protected function comment( $comment, $depth, $args ) {
	    	$classes = implode(' ', get_comment_class()) . ($comment->comment_author_email == get_the_author_meta('email') ? ' author-comment' : '');
	        echo '<li id="comment-' . get_comment_ID() . '" class="'.$classes.' media">'.'\n';
	    	echo '<div class="media__left">' . get_avatar($comment, 64, '', get_comment_author(), array('class' => 'media-object')) . "</div>\n";
	    	echo '<div class="media__body">';
	    	echo '<span class="media__heading meta">Author: ' . get_comment_author().'\n';
	    	
	    	echo ' ' . get_comment_author_url();
	    	echo ' Added ' . get_comment_date('F j, Y в H:i') . '\n';
	    	if ( '0' == $comment->comment_approved ) echo '<br><em class="comment-awaiting-moderation">Your comment will be published after being moderated.</em>'.'\n';
	    	echo "</span>";
	        comment_text().'\n';
	        $reply_link_args = array(
	        	'depth' => $depth, 
	        	'reply_text' => 'Answer', 
				'login_text' => 'You should login first' 
	        );
	        echo get_comment_reply_link( array_merge($args, $reply_link_args) );
	        echo '</div>' . '\n';
	    }
	    public function end_el( &$output, $comment, $depth = 0, $args = array() ) {
			$output .= "</li><!-- #comment-## -->\n";
		}
	}
}

/**
 * Pagination normalize
 */
if( !function_exists( 'pagination' ) ){
	function pagination() {
		global $wp_query;
		$big = 9999;
		$links = paginate_links( array(
			'base'         => str_replace( $big, '%#%', esc_url(get_pagenum_link($big)) ),
			'format'       => '?paged=%#%',
			'current'      => max( 1, get_query_var( 'paged' ) ),
			'type'         => 'array',
			'prev_text'    => 'Next',
	    	'next_text'    => 'Prev',
			'total'        => $wp_query->max_num_pages,
			'show_all'     => false,
			'end_size'     => 15,
			'mid_size'     => 15,
			'add_args'     => false,
			'add_fragment' => ''
		));
	 	if( is_array( $links ) ){
		    echo '<ul class="pagination">';
		    foreach( $links as $link ){
		    	if( strpos( $link, 'current' ) !== false ) echo "<li class='active'>$link</li>";
		        else echo "<li>$link</li>";
		    }
		   	echo '</ul>';
		}
	}
}

/**
 * Theme styles
 */
add_action( 'wp_print_styles', 'add_styles' );
if ( !function_exists( 'add_styles' ) ) {
	function add_styles() {
	    if ( is_admin() ) return false;
		wp_enqueue_style( 'main', get_stylesheet_directory_uri() . '/assets/common.css', '', THEME_VERSION, 'all' );
		/** or classic style.css */
		// wp_enqueue_style( 'main', get_stylesheet_directory_uri() . '/style.css', '', THEME_VERSION, 'all' );
	}
}

/**
 * Theme scripts and footer styles
 */
add_action( 'wp_footer', 'add_scripts' );
if ( !function_exists( 'add_scripts' ) ) { 
	function add_scripts() { 
	    if ( is_admin() ) return false;
	    wp_deregister_script( 'jquery' );
	    wp_enqueue_script( 'main', get_stylesheet_directory_uri() . '/assets/js/script.js', '', THEME_VERSION, true );
		wp_localize_script( 'main', 'ajax', array('url' => admin_url( 'admin-ajax.php'), ) );
		wp_localize_script( 'main', 'user', array('id'  => get_current_user_id(), ) );

		if ( is_page_template('templates/login.php') ) {
			wp_enqueue_style( 'login', get_stylesheet_directory_uri() . '/assets/login.css', '', THEME_VERSION, 'all' );
		}
	}
}

/**
 * Admin style
 */
function admin_style() {
	wp_enqueue_style( 'admin-styles', get_template_directory_uri() . '/admin/css/admin.css' );
}
add_action( 'admin_enqueue_scripts', 'admin_style' );

/**
 * Send Telegram bot message
 */
add_action( 'wp_ajax_send_request', 'nct_send_telegram' );

function nct_send_telegram() {
	$botToken = /** Insert token here */;

	$website = 'https://api.telegram.org/bot' . $botToken;
	$chatId  = /** Insert chat id (for groups prepend by '-') */;
	$params = [
		'chat_id'    => $chatId, 
		'text'       => 'Hello word!',
		'parse_mode' => 'MarkdownV2'
	];
	$ch = curl_init($website . '/sendMessage');
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec($ch);
	curl_close($ch);
}

/**
 * Simple wp_mail
 */
add_action( 'wp_ajax_send_request', 'nct_send_request' );
add_action( 'wp_ajax_nopriv_send_request', 'nct_send_request' );

function nct_send_request(){
	$recipient = get_bloginfo('admin_email');
	$from      = get_bloginfo('name');
	$subject   = 'New request from' . get_bloginfo('name');
	$message   = $_POST['message'];
	'<div class="body" style="background: #f5f6f9; padding: 40px 0;">
		<div class="container" style="width: 100%; max-width: 400px; text-align: center; background: #fff; border-radius: 10px; box-shadow: 0 0 10px #0000001a; padding: 40px; margin: 0 auto;">
			<img src="" style="margin: 0 0 10px 0;"><br>
			' . $subject . '.<br>
			<a href="<!-- callback_link -->"
			style="color: #fff;
			font-weight: 600;
			line-height: 38px;
			text-decoration: none;
			background: #ff6846;
			border-radius: 24px;
			display: inline-block;
			padding: 0 20px;
			margin: 10px 0 0 0;" target="_blank">View</a>
		</div>
	</div>';

	wp_mail( $recipient, $subject, $message, "Content-type: text/html; charset=\"utf-8\"\n From: {$from}", '' );
}

/**
 * ACF options page
 */
if( function_exists( 'acf_add_options_page' ) ){
	acf_add_options_page(array(
		'page_title' 	=> 'Theme settings',
		'menu_title'	=> 'Theme settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}

/**
 * Custom Guntenberg blocks
 */
add_action('acf/init', 'nct_acf_init');
function nct_acf_init() {
	if (function_exists('acf_register_block_type')) {
		acf_register_block_type(array(
			'name'            => 'banner',
			'title'           => 'Banner',
			'description'     => '',
			'render_callback' => 'nct_block_render_callback',
			'category'        => 'homepage',
			'icon'            => 'images-alt'
		));
	}
}

/**
 * Custom block render callback
 */
function nct_block_render_callback($block) {
	$slug = str_replace('acf/', '', $block['name']);

	if( file_exists(get_theme_file_path('/templates/blocks/{$slug}.php')) ){
		include( get_theme_file_path('/templates/blocks/{$slug}.php') );
	}
}

/**
 * Custom block categories
 */
function nct_block_category( $categories, $post ) {
	return array_merge(
		array(
			array(
				'slug' => 'homepage',
				'title' => 'Homepage',
			),
		),
		$categories
	);
}
add_filter( 'block_categories', 'nct_block_category', 10, 2 );

/**
 * Disable Revisions
 */
function nct_revisions_to_keep( $revisions ) {
    return 0;
}
add_filter( 'wp_revisions_to_keep', 'nct_revisions_to_keep' );

/**
 * Editing wpml languages directly in the Database
 */
define( 'ICL_PRESERVE_LANGUAGES_TRANSLATIONS', true );

/**
 * Allow svg
 */
function svg_upload_mimes( $mimes = array() ) {
	if ( current_user_can( 'administrator' ) ) {
		$mimes['svg']  = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';

		return $mimes;
	}
}
add_filter( 'upload_mimes', 'svg_upload_mimes', 99 );

/**
 * Check Mime Types
 */
function svg_upload_check( $checked, $file, $filename, $mimes ) {
	if ( ! $checked['type'] ) {
		$check_filetype		= wp_check_filetype( $filename, $mimes );
		$ext				= $check_filetype['ext'];
		$type				= $check_filetype['type'];
		$proper_filename	= $filename;
		if ( $type && 0 === strpos( $type, 'image/' ) && $ext !== 'svg' ) {
			$ext = $type = false;
		}
		$checked = compact( 'ext','type','proper_filename' );
	}
	return $checked;
}
add_filter( 'wp_check_filetype_and_ext', 'svg_upload_check', 10, 4 );

/**
 * Estimated reading time
 */
function estimated_reading_time() {
	$post    = get_post();
	$postcnt = strip_tags( $post->post_content );
	$words   = count(preg_split('/\s+/', $postcnt));
	$minutes = floor( $words / 120 );
	$seconds = floor( $words % 120 / ( 120 / 60 ) );
	if( 1 <= $minutes ){
		$estimated_time = $minutes . ' min' . ($minutes == 1 ? '' : 's');
	}else{
		$estimated_time = $seconds . ' sec' . ($seconds == 1 ? '' : 's');
	}
	echo $estimated_time;
}

/**
 * Wrap first word with tag
 */
function wrap_first_word($string) {
    $pieces = explode(' ', $string);
    $pieces[0] = '<span>' . $pieces[0] . '</span>';
    return implode(' ', $pieces);
}

/**
 * Convert Image to WebP
 */
function get_webp( $source ) {
	if ( strpos( $_SERVER['HTTP_ACCEPT'], 'image/webp' ) !== false ) {
		$img_path = get_template_directory() . '/assets/img/webp/' . basename( $source ) . '.webp';
		if ( !file_exists( $img_path ) ) {
			$extension = pathinfo( $source, PATHINFO_EXTENSION );
			if ( $extension == 'jpeg' || $extension == 'jpg' ) 
				$image = imagecreatefromjpeg( $source );
			elseif ( $extension == 'gif' ) 
				$image = imagecreatefromgif( $source );
			elseif ( $extension == 'png' ) 
				$image = imagecreatefrompng( $source );
			imagewebp( $image, $img_path, 80 );
		}
		return get_stylesheet_directory_uri() . '/assets/img/webp/' . basename( $source ) . '.webp';
	} else {
		return $source;
	}
}

/**
 * Allow Editors to edit Privacy Policy page
 */
add_action('map_meta_cap', 'nct_custom_manage_privacy_options', 1, 4);
function nct_custom_manage_privacy_options($caps, $cap, $user_id, $args) {
	if ( !is_user_logged_in() ) return $caps;
	if ( 'manage_privacy_options' === $cap ) {
		$manage_name = is_multisite() ? 'manage_network' : 'manage_options';
		$caps = array_diff($caps, [ $manage_name ]);
	}
	return $caps;
}

/**
 * Disable Gutenberg css
 */
function nct_remove_wp_block_library_css() {
	if ( is_front_page() ) { /** Or all other page */
		wp_dequeue_style( 'wp-block-library' ); // Wordpress core
		wp_dequeue_style( 'wp-block-library-theme' ); // Wordpress core
		wp_dequeue_style( 'wc-block-style' ); // WooCommerce
		wp_dequeue_style( 'storefront-gutenberg-blocks' ); // Storefront theme
	}
} 
add_action( 'wp_enqueue_scripts', 'nct_remove_wp_block_library_css', 100 );

/**
 * Disable emoji
 */
add_action( 'init', 'nct_disable_emojis' );

function nct_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}

/**
 * Redirect from non-obvious pages
 */
function nct_custom_redirects()
{
	if( !is_user_logged_in() ) {

		$templates_arr = [
			'templates/user-area.php',
		];

		$current_template = get_page_template_slug();

		/** Or add custom logic here */

		if ( in_array($current_template, $templates_arr) ) {
			wp_redirect( home_url( '/' ) );
			die();
		}
	}
}
// add_action( 'template_redirect', 'nct_custom_redirects' );

/**
 * Ajax authorization --uncomment if needed--
 */
// add_action('wp_ajax_nopriv_login_me', 'loginMe');
// add_action('wp_ajax_logout_me', 'logoutMe');
// add_action('wp_ajax_nopriv_register_me', 'registerMe');

function loginMe() {
	$nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';
	if (!wp_verify_nonce($nonce, 'login_me_nonce')) {
		wp_send_json_error(array('message' => 'Data sent from a third party page', 'redirect' => false));
	}

	if (is_user_logged_in()) {
		wp_send_json_error(array('message' => 'You are already logged in', 'redirect' => false));
	}


	$log = isset($_POST['log']) ? $_POST['log'] : false;
	$pwd = isset($_POST['pwd']) ? $_POST['pwd'] : false;
	$rememberme = isset($_POST['rememberme']) ? $_POST['rememberme'] : false;

	if (!$log) {
		wp_send_json_error(array('message' => 'Login or email field is empty', 'redirect' => false));
	}

	if (!$pwd) {
		wp_send_json_error(array('message' => 'The password field is empty', 'redirect' => false));
	}

	$user = get_user_by('login', $log);
	if (!$user) {
		$user = get_user_by('email', $log);
	}

	if (!$user) {
		wp_send_json_error(array('message' => 'Invalid username/email or password', 'redirect' => false));
	}

	if (get_user_meta($user->ID, 'has_to_be_activated', true) != false) {
		wp_send_json_error(array('message' => 'The user has not activated yet', 'redirect' => false));
	}
	$log = $user->user_login;

	$creds = array(
		'user_login'    => $log,
		'user_password' => $pwd,
		'remember'      => $rememberme
	);

	$user = wp_signon($creds, true);
	if (is_wp_error($user)) {
		wp_send_json_error(array('message' => 'Wrong username/email or password', 'redirect' => false));
	} else {
		wp_send_json_success(array('message' => 'Hi, ' . $user->display_name, 'redirect' => $redirect_to, 'hist_redir' => true));
	}
}


function logoutMe() {
	$nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';

	if (!wp_verify_nonce($nonce, 'logout_me_nonce')) {
		wp_send_json_error(array('message' => 'Data sent from a third party page', 'redirect' => false));
	}

	if (!is_user_logged_in()) {
		wp_send_json_error(array('message' => 'You are not authorized', 'redirect' => false));
	}

	$redirect_to = home_url();

	wp_logout();

	wp_send_json_success(array('message' => 'You successfully logout', 'redirect' => $redirect_to));
}

function registerMe() {
	$nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';
	if (!wp_verify_nonce($nonce, 'register_me_nonce')) {
		wp_send_json_error(array('message' => 'Data sent from a third party page', 'redirect' => false));
	}

	if (is_user_logged_in()) {
		wp_send_json_error(array('message' => 'You are already logged in!', 'redirect' => false));
	}

	if (!get_option('users_can_register')) {
		wp_send_json_error(array('message' => 'User registration is temporarily unavailable', 'redirect' => false));
	}

	$user_login = isset($_POST['user_login']) ? $_POST['user_login'] : '';
	$user_email = isset($_POST['user_em']) ? $_POST['user_em'] : '';
	$pass1      = isset($_POST['pass1']) ? $_POST['pass1'] : '';
	$pass2      = isset($_POST['pass2']) ? $_POST['pass2'] : '';
	$i_agree    = isset($_POST['i_agree']) ? $_POST['i_agree'] : '';

	$redirect_to = isset($_POST['redirect_to']) ? $_POST['redirect_to'] : false;

	if (!$i_agree) {
		wp_send_json_error(array('message' => 'To register you must apply site rules', 'redirect' => false));
	}

	if (!$user_email) {
		wp_send_json_error(array('message' => 'Email required', 'redirect' => false));
	}

	if (!preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $user_email)) {
		wp_send_json_error(array('message' => 'Wrong email format', 'redirect' => false));
	}

	if (!$user_login) {
		wp_send_json_error(array('message' => 'Login is a required field', 'redirect' => false));
	}
	if (!$pass1) {
		wp_send_json_error(array('message' => 'Password is a required field', 'redirect' => false));
	}
	if (!$pass2) {
		wp_send_json_error(array('message' => 'Repeat password', 'redirect' => false));
	}

	if ($pass1 != $pass2) {
		wp_send_json_error(array('message' => 'Passwords do not match', 'redirect' => false));
	}
	if (strlen($pass1) < 4) {
		wp_send_json_error(array('message' => 'The password is too short', 'redirect' => false));
	}
	
	if (false !== strpos(wp_unslash($pass1), "\\")) {
		wp_send_json_error(array('message' => 'Password cannot contain backslashes "\\"', 'redirect' => false));
	}

	$user_id = wp_create_user($user_login, $pass1, $user_email );

	if (is_wp_error($user_id) && $user_id->get_error_code() == 'existing_user_email') {
		wp_send_json_error(array('message' => 'User with this email already exists', 'redirect' => false));
 	} elseif (is_wp_error($user_id) && $user_id->get_error_code() == 'existing_user_login') {
		wp_send_json_error(array('message' => 'User with this login already exists', 'redirect' => false));
	} elseif (is_wp_error($user_id) && $user_id->get_error_code() == 'empty_user_login') {
		wp_send_json_error(array('message' => 'Incorrect login', 'redirect' => false));
	} elseif (is_wp_error($user_id)) {
		wp_send_json_error(array('message' => $user_id->get_error_code(), 'redirect' => false));
	}

	$u = new WP_User($user_id);

	wp_send_json_success(array('message' => 'Registration completed successfully. Now you can log in', 'redirect' => false));
}

/**
 * Upload user logo
 */
add_action('wp_ajax_upload_user_logo', 'upload_user_logo');
function upload_user_logo( $file = array() )
{
	$user_id = get_current_user_id();
	if( wp_verify_nonce( $_POST['security'], 'my_file_upload' ) ){
		if ( !function_exists( 'wp_handle_upload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}
	
		$uploadedfile = $_FILES['file'];

		if( !$_FILES['file'] )
			wp_send_json_error('File not found');

		if( $_FILES['file']['size'] > 1048576 )
			wp_send_json_error('File size must be less than 1MB');
	
		$upload_overrides = array( 'test_form' => false );
	
		$movefile = media_handle_sideload( $uploadedfile, 0 );
	
		if( $movefile && !isset( $movefile['error'] ) ) {
			if( update_user_meta( $user_id, 'user_avatar', $movefile ) ){
				wp_send_json_success($movefile);
			}
		} else {
			wp_send_json_error( $movefile['error'] );
		}
	} else {
		wp_send_json_error('Verification failed, try to reload the page');
	}
}

/**
 * Admin bar only on desktop
 */
if ( wp_is_mobile() ) {
	add_filter( 'show_admin_bar', '__return_false' );
}

/**
 * Check if isBot
 */
function isBot() {
    $bots = array (
        'bot','crawl','Chrome-Lighthouse','googlebot','GTmetrix','aport','yahoo','msnbot','turtle','mail.ru','omsktele',
        'yetibot','picsearch','sape.bot','sape_context','gigabot','snapbot','alexa.com',
        'megadownload.net','askpeter.info','igde.ru','ask.com','qwartabot','yanga.co.uk',
        'scoutjet','similarpages','oozbot','shrinktheweb.com','aboutusbot','followsite.com',
        'dataparksearch','google-sitemaps','appEngine-google','feedfetcher-google',
        'liveinternet.ru','xml-sitemaps.com','agama','metadatalabs.com','h1.hrn.ru',
        'googlealert.com','seo-rus.com','yaDirectBot','yandeG','yandex',
        'yandexSomething','Copyscape.com','AdsBot-Google','domaintools.com',
        'bing.com','dotnetdotcom'
    );
    foreach ( $bots as $bot )
    if ( stripos($_SERVER['HTTP_USER_AGENT'], $bot ) !== false ) {
        return true;
    }
    return false;
}
