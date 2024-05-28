<?php
// Ajouter automatiquement le titre du site dans l'en-tête du site
add_theme_support( 'title-tag' );

// Ajouter le menu dans le tableau de bord WP
add_theme_support( 'menus' );

// Ajouter la prise en charge des images mises en avant
add_theme_support( 'post-thumbnails' );



// Chargement du fichier css
function motaphoto_enqueue_styles() {
    wp_enqueue_style('motaphoto-style', get_template_directory_uri() . '/assets/css/style.css');
}
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_styles');


function motaphoto_enqueue_scripts() {
    // Enqueue le script JavaScript avec URL absolue
    wp_enqueue_script('motaphoto-js', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), '', true);
}
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_scripts');

// Mise en place des menu de navigation main et footer
function register_my_menus() {
    register_nav_menus( array(
        'main' => __( 'Menu Principal', 'Motaphoto' ),
        'footer' => __( 'Menu Footer', 'Motaphoto' ),
    ) );
}
add_action( 'after_setup_theme', 'register_my_menus' );


