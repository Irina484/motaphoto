<?php
// Ajouter automatiquement le titre du site dans l'en-tête du site
add_theme_support( 'title-tag' );

// Ajouter le menu dans le tableau de bord WP
add_theme_support( 'menus' );

// Ajouter la prise en charge des images mises en avant
add_theme_support( 'post-thumbnails' );



// Chargement des fichiers css et js
function motaphoto_enqueue_assets() {
    // Enqueue le style CSS
    wp_enqueue_style('motaphoto-style', get_template_directory_uri() . '/assets/scss/style.css');
    
    // Enqueue le script JavaScript avec URL absolue
    wp_enqueue_script('motaphoto-js', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), '', true);
    wp_localize_script('motaphoto-js','motaphoto-ajax', array('ajax_url' => admin_url('admin-ajax.php')));
}

// Ajoutez la fonction combinée au hook wp_enqueue_scripts
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_assets');


// Mise en place des menu de navigation main et footer
function register_my_menus() {
    register_nav_menus( array(
        'main' => __( 'Menu Principal', 'Motaphoto' ),
        'footer' => __( 'Menu Footer', 'Motaphoto' ),
    ) );
}
add_action( 'after_setup_theme', 'register_my_menus' );

function add_contact_link_to_menu($items, $args) {
    // Vérifiez si c'est le bon menu (par exemple, le menu principal)
    if ($args->theme_location == 'main') {
        // Ajoutez le lien "Contact" avec la classe CSS pour ouvrir la modale
        $contact_link = '<li class="menu-item menu-item-type-custom menu-item-object-custom">
                            <a href="#" class="contact-link">CONTACT</a>
                         </li>';
        $items .= $contact_link;
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'add_contact_link_to_menu', 10, 2);



// Ajoutez une requête pour récupérer le contenu Photo //

 function motaphoto_photos()
 {
    $photos = new WP_Query([
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'order' => 'DESC',
        'orderby' => 'date',
        'post_status'=> 'publish',
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'custom_categorie',
                'field' => 'slug',
                'terms' => $categorie, 
            ),
            array(
                'taxonomy' => 'custom_format',
                'field' => 'slug',
                'terms' => $format,
            )
            ),
        ]);
        if ($photos->have_posts()) {
            while ($photos->have_posts());
            get_template_part('templates-parts/photo_block.php');
        }  
         else {
        
            echo 'No posts found';
        }
        wp_reset_postdata();
    }
           


add_action('wp_ajax_motaphoto_photos', 'motaphoto_photos');
add_action('wp_ajax_nopriv_motaphoto_photos', 'motaphoto_photos');


