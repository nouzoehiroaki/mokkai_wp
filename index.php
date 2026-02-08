<?php get_header();?>

  <div class="loading-screen">
    <div class="loading-content">
      <div class="loading-logo">
        <img src="<?php echo get_template_directory_uri(); ?>/images/logo/mokkai-logo.svg" alt="Mokkai" class="logo-svg">
      </div>
      <div class="loading-text">職人さんが作る家と家具</div>
    </div>
  </div>

  <!-- Main Container -->
  <div class="main-container main-site">

    <!-- Home Section -->
    <!-- <section class="page-section home-section active" id="home">
      <div class="fv-mask"></div>
      <div class="hero-content">
        <h1>
          <img src="<?php echo get_template_directory_uri(); ?>/images/logo/mokkai-logo07.svg" alt="">
        </h1>
        <p>上質な手作りの家で、あなたの空間を豊かに</p>
        <a href="#" class="cta-button" data-page="products">施工事例を見る</a>
      </div>
    </section> -->

    <!-- Products Section -->
    <section class="page-section active" id="products">
      <div class="works-top">
        <div class="swiper">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <img src="<?php echo get_template_directory_uri(); ?>/images/works01.jpg" alt="">
            </div>
            <div class="swiper-slide">
              <img src="<?php echo get_template_directory_uri(); ?>/images/works02.jpg" alt="">
            </div>
            
          </div>
        </div>
      </div>
      <div class="content-section">
        <h2 class="section-title">Works</h2>
        <div class="products-grid">
          <?php
            $paged = get_query_var('paged', 1);
            $query = new WP_Query(
                array(
                    'paged' => $paged,
                    'posts_per_page' => 4,
                    'post_type' => 'works',
                    'tax_query' => array(
                		// array(
                		// 	'taxonomy' => 'seasons-cat',
                		// 	'field'    => 'slug',
            			  //   'terms'    => 'cat-spring',
                		// ),
                	),
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
                <p>
                 <?php
                $terms = get_the_terms(get_the_ID(), 'category-works');
                if ($terms && !is_wp_error($terms)):
                  foreach($terms as $term):
                    echo $term->name;
                  endforeach;
                endif;
                ?>
                </p>
              </div>
            </a>
          </div>
          <?php endwhile; ?>
          <?php endif; wp_reset_postdata(); ?>
        </div>
        <a href="<?php echo home_url('works'); ?>" class="seemore">もっと見る</a>
      </div>
    </section>

    <!-- About Section -->
    <section class="page-section" id="about">
      <div class="content-section">
        <h2 class="section-title">木塊について</h2>
        <div class="about-content">
          <div class="about-text">
            <p>株式会社木塊は、シンプルで機能的、そして美しいデザインの手作りの家と家具を提供しています。職人の技術と現代的なデザインが融合した、長く愛用していただける家を心を込めて製作しています。</p>
            <p>素材選びから仕上げまで、すべての工程において品質を追求し、お客様の暮らしに寄り添う家をお届けします。</p>
          </div>
          <div class="about-image">
            <img src="<?php echo get_template_directory_uri(); ?>/images/about01.jpg" alt="">
          </div>
        </div>
      </div>
    </section>

    <!-- News Section -->
    <section class="page-section" id="news">
      <div class="content-section">
        <h2 class="section-title">ニュース</h2>
        <div class="news-grid">
          <?php
            $args = array(
              'offset' => 0,
              'post_type' => 'post',
              'posts_per_page' => 5,
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
          <?php endif; ?>
        </div>
        <a href="<?php echo home_url('news'); ?>" class="seemore">もっと見る</a>
      </div>
    </section>

    <!-- Contact Section -->
    <section class="page-section" id="contact">
      <div class="content-section">
        <h2 class="section-title">お問い合わせ</h2>
        <div class="contact-content">
          <div class="contact-info">
            <h3>会社情報</h3>
            <p>
              <strong>会社名:</strong><br>
              株式会社木塊
            </p>

            <p>
              <strong>代表者名:</strong><br>
              福榮　信彦
            </p>

            <p><strong>本社所在地:</strong><br>
              〒180-0003<br>
              東京都武蔵野市吉祥寺南町3-18-5</p>

            <p><strong>電話:</strong> 03-XXXX-XXXX<br>
              <strong>メール:</strong>fukuei@mokkai.com
            </p>
          </div>
          <?php echo do_shortcode('[contact-form-7 id="5833619" title="ContactForm"]'); ?>
        </div>
      </div>
    </section>
  </div>

  <?php get_footer(); ?>
  