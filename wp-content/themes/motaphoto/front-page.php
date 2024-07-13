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


<section class="taxonomies">
    <div class="tax_categorie_format">
    <form id="categorie" class="taxonomie_categorie">
        <select id="select-categorie" name="categorie">
            <option value="" hidden disabled selected>CATÉGORIES</option>
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
        <option value="" hidden disabled selected>FORMATS</option>
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

<div class="tri_organisation">
 
    <form id="ordre" class="taxonomie_ordre">
        <select id="select-ordre" name="ordre">
            <option value="" hidden disabled selected>TRIER PAR</option>
            <option value="DESC">À PARTIR DES PLUS RÉCENTES</option>
            <option value="ASC">À PARTIR DES PLUS ANCIENNES</option>
        </select>
    </form>
    </div>
    </section>
<section class="blocphoto">
<!-- Conteneur pour les photos -->
<div id="photo-container" class="photo_type">
<input type="hidden" id="photos-per-page" value="8">
<input type="hidden" id="categorie-slug" value="">
<input type="hidden" id="format-slug" value="">

   
</div>

<!-- Bouton pour charger plus -->
<button id="load-more-button">Charger plus</button>
</section>

<?php get_footer(); ?>