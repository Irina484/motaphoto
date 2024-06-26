<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    
    <?php wp_body_open(); ?>
<header>
<section class="entete">
    <div>
        <a href="<?php echo home_url( '/' ); ?>">
            <img class="header_logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/Logo.png" alt="Logo NMota" >
        </a>
    </div>
    <div>
        <button class="menu-button" onclick="toggleMenu()">☰</button> <!-- Bouton principal pour ouvrir le menu -->
             
        <nav id="main-menu" role="navigation" aria-label="<?php _e('Menu principal', 'Motaphoto'); ?>" class="hidden">
        <button class="close-button" onclick="toggleMenu()">✕</button> <!-- Utilisation d'un bouton pour l'icône de fermeture -->
    </div>
        <?php
        if ( has_nav_menu( 'main' ) ) {
            wp_nav_menu( array(
                'theme_location' => 'main',
                'menu_id'        => 'main-menu',
                'container_class' => 'main-navigation', // classe CSS pour customiser mon menu
            ) );
        }
        ?>
        
    </nav>
</section>



</header> 

