<?php get_template_part('templates-parts/modal-contact'); ?>

<footer >
    <section class = "piedpage">
        <?php
            if ( has_nav_menu( 'footer' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'footer',
                    'menu_id'        => 'footer-menu',
                    'container_class' => 'footer-navigation',
                ) );
            }

        ?>
        <p class="footer-text">TOUS DROITS RÉSERVÉS</p>
    </section>
</footer>

<?php wp_footer(); ?>
</body>
</html>

