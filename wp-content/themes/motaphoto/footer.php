<?php get_template_part('templates-parts/modale_contact'); ?>

<footer >
<?php
        if ( has_nav_menu( 'footer' ) ) {
            wp_nav_menu( array(
                'theme_location' => 'footer',
                'menu_id'        => 'footer-menu',
                'container_class' => 'footer-navigation',
            ) );
        }

?>
</footer>

<?php wp_footer(); ?>
</body>
</html>

