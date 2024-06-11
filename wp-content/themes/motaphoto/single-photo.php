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
       <input class=" bouton btn-modale" type="button" value="Contact">
  

    <!-- Navigation entre les photos et affichage des photos en miniature -->
<div class="miniaturestyle">
    <!-- Récupération du post suivant et précédent pour afficher leur image au-dessus des flèches -->
    <?php
        $prevPost = get_previous_post();
        $nextPost = get_next_post();
        if (!empty($prevPost)) {
            $prevThumbnail = get_the_post_thumbnail_url($prevPost->ID);
            $prevLink = get_permalink($prevPost);
        }    
        if (!empty($nextPost)) {
            $nextThumbnail = get_the_post_thumbnail_url($nextPost->ID);
            $nextLink = get_permalink($nextPost);
        }    
    ?>
    <div class="fleches">
        <!-- Affichage de la flèche pour le post précédent contenant son URL -->
        <?php if (!empty($prevPost)) { ?>
            <a href="<?php echo $prevLink; ?>">
                <img class="fleche fleche-gauche" src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow_left.png"
                    alt="Flèche pointant vers la gauche" />
            </a>
        <?php } else { ?>
            <img style="opacity:0; cursor: auto;" class="fleche"
                src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow_left.png" />
        <?php } ?>
        
        <!-- Affichage de la flèche pour le post suivant contenant son URL -->
        <?php if (!empty($nextPost)) { ?>
            <a href="<?php echo $nextLink; ?>">
                <img class="fleche fleche-droite" src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow_right.png"
                    alt="Flèche pointant vers la droite" />
            </a>
        <?php } else { ?>
            <img style="opacity:0; cursor: auto;" class="fleche"
                src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow_right.png" />
        <?php } ?>
    </div>

    <!-- Image du post précédent -->
    <?php if (!empty($prevPost)) { ?>
        <div class="preview previous-preview">
            <img class="previous-image" src="<?php echo $prevThumbnail; ?>" alt="Prévisualisation image précédente">
        </div>
    <?php } ?>

    <!-- Image du post suivant -->
    <?php if (!empty($nextPost)) { ?>
        <div class="preview next-preview">
            <img class="next-image" src="<?php echo $nextThumbnail; ?>" alt="Prévisualisation image suivante">
        </div>
    <?php } ?>
</div>
</div>
    </section>
</div>



<?php get_footer(); ?>

