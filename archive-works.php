<?php get_header('under');?>
  <div class="content-section">
  <h2 class="section-title">Works</h2>
  <div class="products-grid">
    <?php
      $paged = get_query_var('paged', 1);
      $query = new WP_Query(
        array(
          'paged' => $paged,
          'posts_per_page' => 9,
          'post_type' => 'works',
          // 'tax_query' => array(
          //   array(
          //   	'taxonomy' => 'works-cat',
          //   	'field'    => 'slug',
          //     'terms'    => 'cat-test',
          //   ),
          // ),
        )
      );
    ?>
    <?php
    if ( $query->have_posts() ) : ?>
    <?php while ( $query->have_posts() ) : $query->the_post();?>
    <div class="product-card">
      <a href="<?php the_permalink(); ?>">
        <div class="product-image">
          <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('full'); ?>
          <?php else : ?>
            <img src="<?php echo get_template_directory_uri(); ?>/images/moc01.webp" alt="">
          <?php endif ; ?>
        </div>
        <div class="product-info">
          <h3><?php the_title(); ?></h3>
          <p><?php the_excerpt(); ?></p>
        </div>
      </a>
    </div>
    <?php endwhile; ?>
  </div>
  <div class="pagenavi">
    <?php if(function_exists('wp_pagenavi')): wp_pagenavi(); endif;?>
  </div>
  <?php endif; wp_reset_postdata(); ?>
<?php get_footer(); ?>