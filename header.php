<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
      <div class="header-link-pc">
       <ul class="menu-links">
          <!-- <li><a href="#" data-page="home">Home</a></li> -->
          <li><a href="#" data-page="products">Works</a></li>
          <li><a href="#" data-page="about">About</a></li>
          <li><a href="#" data-page="news">News</a></li>
          <li><a href="#" data-page="contact">Contact</a></li>
          <li>
            <a href="https://www.instagram.com/mokkai_makabe/" target="_blank" rel="noopener noreferrer">
              <img src="<?php echo get_template_directory_uri(); ?>/images/logo/Instagram-icon.svg" alt="Instagram" class="instagram-icon">
            </a>
          </li>
        </ul>
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
      <!-- <li><a href="#" data-page="home">Home</a></li> -->
      <li><a href="#" data-page="about">About</a></li>
      <li><a href="#" data-page="products">Works</a></li>
      <li><a href="#" data-page="news">News</a></li>
      <li><a href="#" data-page="contact">Contact</a></li>
      <li>
        <a href="https://www.instagram.com/mokkai_makabe/" target="_blank" rel="noopener noreferrer">
          <img src="<?php echo get_template_directory_uri(); ?>/images/logo/Instagram-icon.svg" alt="Instagram" class="instagram-icon">
        </a>
      </li>
    </ul>
  </div>