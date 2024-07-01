<?php get_header(); ?>
   
<div class="container1">
    <section class="post-content">
        <div class="post-details">
            <?php
            if (have_posts()) : while (have_posts()) : the_post();
                // Récupérer le titre du post
                $title = get_the_title();

                // Récupérer l'image mise en avant
                $thumbnail_url = get_the_post_thumbnail_url(null, 'full');

                // Récupérer la date de publication
                $date = get_the_date('Y');

                // Récupérer la référence de la photo (supposons qu'elle est stockée dans un champ personnalisé ACF)
                $photo_reference = get_field('reference');

                // Récupérer le type (champ personnalisé ACF)
                $type = get_field('type');
                
                // Récupérer la catégorie sans balises HTML
                $categories = get_the_term_list(get_the_ID(), 'categorie', '', ', ', '');
                if (!is_wp_error($categories)) {
                    $category_list = strip_tags($categories);
                } else {
                    $category_list = 'Aucune catégorie trouvée';
                }

                // Récupérer le format de la photo sans balises HTML
                $formats = get_the_term_list(get_the_ID(), 'format', '', ', ', '');
                if (!is_wp_error($formats)) {
                    $photo_format = strip_tags($formats);
                } else {
                    $photo_format = 'Aucun format trouvé';
                }
            ?>

                <h2><?php echo $title; ?></h2>
                <p>RÉFÉRENCE : <span id="reference-photo"><?php echo $photo_reference; ?></span></p>
                <p>CATÉGORIE : <?php echo $category_list; ?></p>
                <p>FORMAT : <?php echo $photo_format; ?></p>
                <p>TYPE: <?php echo $type; ?></p>
                <p>ANNÉE : <?php echo $date; ?></p>
            <?php endwhile; endif; ?>
        </div>
        
        <div class="post-thumbnail">
            <?php if ($thumbnail_url): ?>
                <img src="<?php echo $thumbnail_url; ?>">
            <?php endif; ?>
        </div>
    </div>
    
    <div class="post-body">
        <?php
        // Afficher le contenu du post
        if (have_posts()) : while (have_posts()) : the_post();
            the_content();
        endwhile; endif;
        ?>
    </section>
<section class="container2">
    <div class="containerstyle">
	        <p >Cette photo vous intéresse ?</p>
            <input class=" bouton contact-link" type="button" value="Contact">
  

    <!-- Navigation entre les photos et affichage des photos en miniature -->
    <div class="miniaturestyle">
    <?php
        $prevPost = get_previous_post();
        $nextPost = get_next_post();

        $prevThumbnail = !empty($prevPost) ? get_the_post_thumbnail_url($prevPost->ID) : '';
        $prevLink = !empty($prevPost) ? get_permalink($prevPost) : '';

        $nextThumbnail = !empty($nextPost) ? get_the_post_thumbnail_url($nextPost->ID) : '';
        $nextLink = !empty($nextPost) ? get_permalink($nextPost) : '';
    ?>
    <div class="fleches">
        <!-- Flèche pour le post précédent -->
        <a href="<?php echo $prevLink; ?>" class="nav-link prev-link">
            <img class="fleche <?php echo !empty($prevPost) ? 'fleche-gauche' : ''; ?>" src="<?php echo get_template_directory_uri(); ?>/assets/images/fleche_gauche.png"
                alt="Flèche pointant vers la gauche" />
        </a>
        
        <!-- Flèche pour le post suivant -->
        <a href="<?php echo $nextLink; ?>" class="nav-link next-link">
            <img class="fleche <?php echo !empty($nextPost) ? 'fleche-droite' : ''; ?>" src="<?php echo get_template_directory_uri(); ?>/assets/images/fleche_droit.png"
                alt="Flèche pointant vers la droite" />
        </a>
        
        <!-- Zone de prévisualisation au centre -->
        <div class="photo-preview">
            <?php if (!empty($prevPost)) : ?>
                <img class="preview-image prev-thumbnail" src="<?php echo $prevThumbnail; ?>" alt="Prévisualisation image précédente">
            <?php endif; ?>
            <?php if (!empty($nextPost)) : ?>
                <img class="preview-image next-thumbnail" src="<?php echo $nextThumbnail; ?>" alt="Prévisualisation image suivante">
            <?php endif; ?>
        </div>
        </div>
    </div>

</section>
    
<!-- Section liste des photos apparentées -->
<section class="recommandations">
    <h3>Vous aimerez aussi</h3>
    <div class="recommandations_images">
        <?php
        $terms = get_the_terms(get_the_ID(), 'categorie');

        if (!is_wp_error($terms) && !empty($terms)) {
            $categorie_slug = $terms[0]->slug;
        } else {
            $categorie_slug = ''; // Valeur par défaut si aucun terme n'est trouvé
        }

       
        ?>
        <input type="hidden" id="photos-per-page" value="2">
        <input type="hidden" id="categorie-slug" value="<?php echo esc_attr($categorie_slug); ?>">
    </div>
</section>


<?php get_footer(); ?>

