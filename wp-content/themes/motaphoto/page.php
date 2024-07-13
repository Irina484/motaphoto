<?php
// Inclure l'en-tête
get_header(); 

// Commence la boucle principale
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        // Vérifie si la page actuelle est "Vie Privée" ou "Mentions Légales"
        if ( is_page('vie-privee') || is_page('mentions-legales') ) :
            ?>
            <div class="page-content">
                <h1><?php the_title(); // Affiche le titre de la page ?></h1>
                <div class="content">
                    <?php the_content(); // Affiche le contenu de la page ?>
                </div>
            </div>
            <?php
        else :
            // Affichage par défaut pour les autres pages
            ?>
            <div class="page-content">
                <h1><?php the_title(); ?></h1>
                <div class="content">
                    <?php the_content(); ?>
                </div>
            </div>
            <?php
        endif;
    endwhile;
else :
    // Si aucun contenu n'est trouvé
    ?>
    <div class="page-content">
        <h1>Page non trouvée</h1>
        <div class="content">
            <p>Désolé, aucun contenu n'a été trouvé.</p>
        </div>
    </div>
    <?php
endif;

// Inclure le pied de page
get_footer();
?>
