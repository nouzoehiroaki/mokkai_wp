<?php
status_header(404);
nocache_headers();
get_header('under');
?>
<!-- 404ページの内容 -->
<div class="content-section">
  <h2 class="section-title">404 Not Found</h2>
  <p style="text-align: center;">お探しのページは見つかりませんでした。</p>
  <a href="<?php echo home_url(); ?>" class="seemore">トップページに戻る</a>
</div>
<?php get_footer(); ?>