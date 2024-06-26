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

<div class="taxonomie organisation ">
    <form id="categorie" class="taxonomie_categorie">
        <select id="select-categorie" name="categorie">
            <option value="" hidden disabled selected>CATÉGORIES</option> <!-- Option désactivée et non sélectionnée -->
            <?php 
            $terms = get_terms(['taxonomy' => 'categorie', 'orderby' => 'name']);
            if (!empty($terms) && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                    echo '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
                }
            }
            ?>
        </select>
    </form>
</div>
    <form id="format" class="taxonomie_format">
        <select id="select-format" name="format">
            <option value="" hidden disabled selected>FORMATS</option> <!-- Option désactivée et non sélectionnée -->
            <?php 
            $terms = get_terms(['taxonomy' => 'format', 'orderby' => 'name']);
            if (!empty($terms) && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                    echo '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
                }
            }
            ?>
        </select>
    </form>
</div>

<div class="tri organisation">

    <div class="half"></div>
    <form id="ordre" class="taxonomie_ordre">
        <select id="select-ordre" name="ordre">
        <option value="" hidden disabled selected>TRIER PAR</option>
            <option  value="DESC">À partir des plus récentes</option>
            <option  value="ASC">À partir des plus anciennes</option>
        </select>
    </form>
    </div>

<!-- Conteneur pour les photos -->
<div id="photo-container" class="photo_type"></div>

<?php get_footer(); ?>