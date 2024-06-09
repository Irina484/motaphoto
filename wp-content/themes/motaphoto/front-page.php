<?php get_header(); ?>
<section class="hero">
  <h1>Photographe event</h1>
  <?php
    $image_url = get_photo_url();
    if ($image_url) {
        echo '<img class="heroimg" src="' . esc_url($image_url) . '" alt="Hero Image">';
    } else {
        echo 'No image found';
    }
  ?>
</section>

<?php get_footer(); ?>