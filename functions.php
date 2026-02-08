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

// 施工事例用のメタボックス追加
function works_gallery_meta_box() {
    add_meta_box(
        'works_gallery',
        '施工事例 画像ギャラリー',
        'works_gallery_meta_box_callback',
        'works',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'works_gallery_meta_box');

// メタボックスのHTML出力
function works_gallery_meta_box_callback($post) {
    wp_nonce_field('works_gallery_nonce_action', 'works_gallery_nonce');
    $images = get_post_meta($post->ID, '_works_gallery_images', true);
    if (!is_array($images)) $images = array();
    ?>
    <div id="works-gallery-container">
        <?php foreach ($images as $index => $image_id) :
            $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
            if (!$image_url) continue;
        ?>
            <div class="works-gallery-item" style="display:inline-block; margin:5px; position:relative;">
                <img src="<?php echo esc_url($image_url); ?>" style="width:150px; height:150px; object-fit:cover; display:block;">
                <input type="hidden" name="works_gallery_images[]" value="<?php echo esc_attr($image_id); ?>">
                <button type="button" class="works-gallery-remove" style="position:absolute; top:0; right:0; background:red; color:#fff; border:none; cursor:pointer; padding:2px 6px;">×</button>
            </div>
        <?php endforeach; ?>
    </div>
    <p>
        <button type="button" id="works-gallery-add" class="button">画像を追加</button>
    </p>

    <script>
    jQuery(document).ready(function($) {
        // 画像追加
        $('#works-gallery-add').on('click', function(e) {
            e.preventDefault();
            var frame = wp.media({
                title: '画像を選択',
                multiple: true,
                library: { type: 'image' },
                button: { text: '画像を追加' }
            });
            frame.on('select', function() {
                var attachments = frame.state().get('selection').toJSON();
                $.each(attachments, function(i, attachment) {
                    var html = '<div class="works-gallery-item" style="display:inline-block; margin:5px; position:relative;">';
                    html += '<img src="' + attachment.sizes.thumbnail.url + '" style="width:150px; height:150px; object-fit:cover; display:block;">';
                    html += '<input type="hidden" name="works_gallery_images[]" value="' + attachment.id + '">';
                    html += '<button type="button" class="works-gallery-remove" style="position:absolute; top:0; right:0; background:red; color:#fff; border:none; cursor:pointer; padding:2px 6px;">×</button>';
                    html += '</div>';
                    $('#works-gallery-container').append(html);
                });
            });
            frame.open();
        });

        // 画像削除
        $(document).on('click', '.works-gallery-remove', function() {
            $(this).closest('.works-gallery-item').remove();
        });

        // ドラッグ&ドロップで並び替え
        $('#works-gallery-container').sortable({
            items: '.works-gallery-item',
            cursor: 'move',
            placeholder: 'sortable-placeholder'
        });
    });
    </script>
    <?php
}

// 保存処理
function works_gallery_save($post_id) {
    if (!isset($_POST['works_gallery_nonce']) || !wp_verify_nonce($_POST['works_gallery_nonce'], 'works_gallery_nonce_action')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['works_gallery_images'])) {
        $images = array_map('intval', $_POST['works_gallery_images']);
        update_post_meta($post_id, '_works_gallery_images', $images);
    } else {
        delete_post_meta($post_id, '_works_gallery_images');
    }
}
add_action('save_post_works', 'works_gallery_save');



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