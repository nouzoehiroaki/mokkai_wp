<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
  <link
    href="https://fonts.googleapis.com/css2?family=Klee+One:wght@400;600&amp;family=Zen+Kaku+Gothic+Antique:wght@400;500&amp;display=swap"
    rel="stylesheet">
  <title>MOKKAI | 職人さんが作る家</title>
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/styles.css">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/swiper.min.css">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/swiper.css">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <!-- Header -->
  <header>
    <nav>
      <div class="header-logo">
        <a href="<?php echo home_url('/'); ?>">
          <img src="<?php echo get_template_directory_uri(); ?>/images/logo/mokkai-logo02.svg" alt="">
        </a>
      </div>
      <div class="hamburger" id="hamburger">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </nav>
  </header>

  <!-- Menu Overlay -->
  <div class="menu-overlay" id="menuOverlay">
    <ul class="menu-links">
      <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
      <li><a href="<?php echo home_url('/'); ?>#about">About</a></li>
      <li><a href="<?php echo home_url('/'); ?>#products">Works</a></li>
      <li><a href="<?php echo home_url('/'); ?>#news">News</a></li>
      <li><a href="<?php echo home_url('/'); ?>#contact">Contact</a></li>
      <li>
        <a href="https://www.instagram.com/mokkai_makabe/" target="_blank" rel="noopener noreferrer">
          <img src="<?php echo get_template_directory_uri(); ?>/images/logo/Instagram-icon.svg" alt="Instagram" class="instagram-icon">
        </a>
      </li>
    </ul>
  </div>