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
        
        <!-- Button Burger -->
        <div class="burger-menu">
            <button class="burger-button" aria-label="Toggle menu">
                <span class="burger-icon">☰</span>
                <span class="close-icon">✖</span>
            </button>
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

        <!-- Mobile Menu -->
        <div class="mobile-menu">
            <?php
            if ( has_nav_menu( 'main' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'main',
                    'menu_id'        => 'mobile-main-menu',
                    'container_class' => 'mobile-main-navigation', // classe CSS pour customiser mon menu mobile
                ) );
            }
            ?>
        </div>
    </section>
</header>
