<?php get_header('under');?>
<div class="p-single">
  <div class="content-section">
    <h1 class="p-single__title"><?php the_title(); ?></h1>
    <div class="p-single__contents">
      <div class="p-single__head">
        <?php
        $categories = get_the_category();
        if (!empty($categories)) :
        ?>
        <div class="p-single__category">
          <span>
            <?php echo esc_html($categories[0]->name); ?>
          </span>
        </div>
        <?php endif; ?>
        <p class="p-single__time">
          <time datetime="<?php the_time('Y-m-d'); ?>">
            <?php the_time('Y.m.d'); ?>
          </time>
        </p>
      </div>
      <div class="content">
        <?php
        $images = get_post_meta(get_the_ID(), '_works_gallery_images', true);
        if (!empty($images) && is_array($images)) : ?>
            <div class="works-gallery">
                <?php foreach ($images as $index => $image_id) :
                    $full_url = wp_get_attachment_image_url($image_id, 'full');
                ?>
                    <div class="works-gallery-item" data-index="<?php echo $index; ?>">
                        <?php echo wp_get_attachment_image($image_id, 'large'); ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- モーダル -->
            <div class="works-modal" id="worksModal">
                <div class="works-modal__overlay"></div>
                <div class="works-modal__content">
                    <button class="works-modal__close" type="button">&times;</button>
                    <button class="works-modal__prev" type="button">&#10094;</button>
                    <button class="works-modal__next" type="button">&#10095;</button>
                    <img class="works-modal__image" src="" alt="">
                    <p class="works-modal__counter"></p>
                </div>
            </div>
            <?php
            // JSに渡す画像URL配列
            $full_urls = array();
            foreach ($images as $image_id) {
                $full_urls[] = wp_get_attachment_image_url($image_id, 'full');
            }
            ?>
            
        <?php endif; ?>

        <?php echo wpautop( get_the_content() ); ?>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>