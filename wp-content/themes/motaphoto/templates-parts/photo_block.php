<div class="photo-post">
    <?php 
    // Récupérer l'ID de l'image mise en avant
    $thumbnail_id = get_post_thumbnail_id($photo->ID); 
    
    // Récupérer l'URL de l'image mise en avant
    $thumbnail_url = get_the_post_thumbnail_url($photo->ID); 
    
    // Récupérer les termes de la taxonomie 'categorie'
    $categories = get_the_term_list($photo->ID, 'categorie', '', ', ', ''); 
    
    // Récupérer la référence personnalisée
    $reference = get_field('reference', $photo->ID); 
    ?>
    
    <img class="img-photo" 
        src="<?php echo esc_url($thumbnail_url); ?>" 
        alt="<?php echo esc_attr(get_the_title($photo->ID)); ?>" 
        data-ref="<?php echo esc_attr($reference); ?>"
        data-categorie="<?php echo strip_tags($categories); ?>"
    />
</div>
