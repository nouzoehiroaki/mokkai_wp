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
        <?php echo wpautop( get_the_content() ); ?>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>