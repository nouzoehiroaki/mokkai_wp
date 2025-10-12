<?php get_header('under');?>
  <div class="content-section">
    <h2 class="section-title">ニュース</h2>
    <div class="news-grid">
      <?php
        $paged = get_query_var('paged', 1);
        $args = array(
          'paged' => $paged,
          'post_type' => 'post',
          'posts_per_page' => 10,
        );
        query_posts($args);
      ?>
      <?php
      if ( have_posts() ) : while ( have_posts() ) : the_post();?>
      <article class="news-card">
        <a href="<?php the_permalink(); ?>">
          <div class="news-content">
            <span class="news-date"><?php echo get_the_date('Y.n.j.(D)'); ?></span>
            <span class="news-category">
              <?php 
              $cat = get_the_category();
              $cat = $cat[0];
              echo $cat->cat_name; 
              ?>
            </span>
            <h3 class="news-title"><?php the_title(); ?></h3>
            <p class="news-excerpt"><?php echo mb_substr( get_the_excerpt(), 0, 50 ) . '[...]'; ?></p>
          </div>
        </a>
      </article>
      <?php endwhile; wp_reset_query(); ?>
      <div class="pagenavi">
        <?php if(function_exists('wp_pagenavi')): wp_pagenavi(); endif;?>
      </div>
      <?php endif; ?>
    </div>
  </div>
<?php get_footer(); ?>
