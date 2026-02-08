<?php
/**
 * Embedの削除
 */
remove_action('wp_head','rest_output_link_wp_head');
remove_action('wp_head','wp_oembed_add_discovery_links');
remove_action('wp_head','wp_oembed_add_host_js');
remove_action('wp_head','wp_generator');
remove_action('wp_head','wp_shortlink_wp_head');
remove_action('wp_head','rsd_link');
remove_action('wp_head','wlwmanifest_link');
remove_action('wp_head','feed_links_extra',3);
remove_action('wp_head','dns-prefetch');

/**
 * Emoji機能の削除
 */
function disable_emojis() {
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_action('admin_print_styles', 'print_emoji_styles');
  remove_filter('the_content_feed', 'wp_staticize_emoji');
  remove_filter('comment_text_rss', 'wp_staticize_emoji');
  remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init','disable_emojis');
add_filter('emoji_svg_url','__return_false');

//wp-block-library css削除
add_action('wp_enqueue_scripts', 'remove_block_library_style');
function remove_block_library_style(){
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
}

/* 投稿ラベル変更 */
function Change_menulabel() {
	global $menu;
	global $submenu;
	$name = 'お知らせ';
	$menu[5][0] = $name;
	$submenu['edit.php'][5][0] = $name.'一覧';
	$submenu['edit.php'][10][0] = '新規追加';
}
function Change_objectlabel() {
	global $wp_post_types;
	$name = 'お知らせ';
	$labels = &$wp_post_types['post']->labels;
	$labels->name = $name;
	$labels->singular_name = $name;
	$labels->add_new = _x('追加', $name);
	$labels->add_new_item = $name.'の新規追加';
	$labels->edit_item = $name.'の編集';
	$labels->new_item = '新規'.$name;
	$labels->view_item = $name.'を表示';
	$labels->search_items = $name.'を検索';
	$labels->not_found = $name.'が見つかりませんでした';
	$labels->not_found_in_trash = 'ゴミ箱に'.$name.'は見つかりませんでした';
}
add_action( 'init', 'Change_objectlabel' );
add_action( 'admin_menu', 'Change_menulabel' );

function post_has_archive( $args, $post_type ) {
  if( 'post' == $post_type ) {
      $args['rewrite'] = true;
      $args['has_archive'] = 'news';
  }
  return $args;
}
add_filter( 'register_post_type_args', 'post_has_archive', 10, 2 );

// function my_script(){
//   if (is_front_page()) {
//     wp_enqueue_script( 'uikit-js', get_template_directory_uri() . '/js/uikit.min.js', '1.0.0', true );
//   }
//   wp_enqueue_script( 'main-js', get_template_directory_uri() . '/js/js.js', '1.0.0', true );
// }
// add_action('wp_enqueue_scripts', 'my_script');

// function enqueue_name(){
//   wp_enqueue_style('style-css', get_template_directory_uri() . '/css/styles.css', array(), '1.0.0');
// }
// add_action('wp_enqueue_scripts','enqueue_name');

// wp_pagenavi
function adjust_category_paged( $query = []) {
  if (isset($query['name'])
   && $query['name'] === 'page'
   && isset($query['page'])
   && isset($query['category_name'])) {
    $query['paged'] = intval($query['page']); // 念のため整数化しておく
    unset($query['name']);
    unset($query['page']);
  }
  return $query;
}
add_filter('request', 'adjust_category_paged');

// Contact Form 7の自動pタグ無効
add_filter('wpcf7_autop_or_not', 'wpcf7_autop_return_false');
function wpcf7_autop_return_false() {
  return false;
}

//カスタム投稿 施工事例
function add_custom_post_works() {
  register_post_type(
    'works',
    array(
      'label' => '施工事例',
      'public' => true,
      'has_archive' => true,
      'menu_position' => 5,
      'supports' => array(
                      'title',
                      'editor',
                      'thumbnail',
                      'revisions',
                      'excerpt',
                      'custom-fields',
                    )
    )
  );
}
add_action('init', 'add_custom_post_works');

//施工事例カテゴリ
function add_taxonomy_works() {
  register_taxonomy(
  'category-works',
  'works',
  array(
    'label' => '施工事例カテゴリ',
    'singular_label' => '施工事例カテゴリ',
    'labels' => array(
      'all_items' => '施工事例カテゴリ一覧',
      'add_new_item' => '施工事例カテゴリを追加'
    ),
    'public' => true,
    'show_ui' => true,
    'show_in_nav_menus' => true,
    'hierarchical' => true
    )
  );
}
add_action( 'init', 'add_taxonomy_works' );

/*【表示カスタマイズ】アイキャッチ画像の有効化 */
add_theme_support( 'post-thumbnails' );

// 記事全体の自動整形の無効化
remove_filter( 'the_content', 'wpautop' );

// Contact Form7のお問い合せフォーム項目にひらがなが無ければ送信不可
add_filter('wpcf7_validate_textarea', 'wpcf7_validation_textarea_hiragana', 10, 2);
add_filter('wpcf7_validate_textarea*', 'wpcf7_validation_textarea_hiragana', 10, 2);
function wpcf7_validation_textarea_hiragana($result, $tag)
{
  $name = $tag['name'];
  $value = (isset($_POST[$name])) ? (string) $_POST[$name] : '';
  if ($value !== '' && !preg_match('/[ぁ-ん]/u', $value)) {
    $result['valid'] = false;
    $result['reason'] = array($name => 'エラー：こちらの内容は送信できません。');
  }
  return $result;
}


/*-------------------------------------------*/
/*  <head>タグ内に自分の追加したいタグを追加する
/*-------------------------------------------*/
function add_wp_head_custom(){ ?>
<!-- head内に書きたいコード -->
<?php }
// add_action( 'wp_head', 'add_wp_head_custom',1);

function add_wp_footer_custom(){ ?>
<!-- footerに書きたいコード -->
<?php }
// add_action( 'wp_footer', 'add_wp_footer_custom', 1 );