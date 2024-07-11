<?php

add_action('wp_ajax_single_photo', 'single_photo');
add_action('wp_ajax_nopriv_single_photo', 'single_photo');

function single_photo() {
    if (!check_ajax_referer('wp_rest', 'security')) {
        wp_send_json_error('Invalid nonce');
        die();
    }

    if (isset($_POST['posts_per_page']) && isset($_POST['categorie_slug'])) {
        $posts_per_page = intval($_POST['posts_per_page']);
        $categorie_slug = sanitize_text_field($_POST['categorie_slug']);

        $args = array(
            'post_type' => 'photo',
            'posts_per_page' => $posts_per_page,
            'post__not_in' => array(null),
            'tax_query' => array(
                array(
                    'taxonomy' => 'categorie',
                    'field' => 'slug',
                    'terms' => $categorie_slug,
                ),
            ),
            'orderby' => 'rand',
        );

        $photos = get_posts($args);
        $affich_photos = array(); // Tableau pour contenir les données des photos formatées

        foreach ($photos as $photo) {
            $affich_photos[] = array(
                'thumbnail' => get_the_post_thumbnail_url($photo->ID, 'full'),
                'title' => get_the_title($photo->ID),
                'categories' => strip_tags(get_the_term_list($photo->ID, 'categorie', '', ', ', '')),
                'reference' => get_field('reference', $photo->ID),
                'permalink' => get_permalink($photo->ID) // Ajoutez cette ligne
            );
        }

        wp_send_json_success($affich_photos);
    } else {
        wp_send_json_error('Missing required parameters');
    }

    wp_die();
}

// Function php front-page //

add_action('wp_ajax_frontpage_photo', 'frontpage_photo');
add_action('wp_ajax_nopriv_frontpage_photo', 'frontpage_photo');

function frontpage_photo() {
    if (!check_ajax_referer('wp_rest', 'security')) {
        wp_send_json_error('Invalid nonce');
        die();
    }

    if (isset($_POST['posts_per_page']) && isset($_POST['page'])) {
        $posts_per_page = intval($_POST['posts_per_page']);
        $page = intval($_POST['page']);
        $offset = $page * $posts_per_page;

        $tax_query = array('relation' => 'AND');
        
        if (!empty($_POST['categorie_slug'])) {
            $categorie_slug = sanitize_text_field($_POST['categorie_slug']);
            $tax_query[] = array(
                'taxonomy' => 'categorie',
                'field' => 'slug',
                'terms' => $categorie_slug,
            );
        }

        if (!empty($_POST['format_slug'])) {
            $format_slug = sanitize_text_field($_POST['format_slug']);
            $tax_query[] = array(
                'taxonomy' => 'format',
                'field' => 'slug',
                'terms' => $format_slug,
            );
        }

        $args = array(
            'post_type' => 'photo',
            'posts_per_page' => $posts_per_page,
            'offset' => $offset,
            'tax_query' => count($tax_query) > 1 ? $tax_query : '',
            
        );

        $photos = get_posts($args);
        $affich_photos = array();

        foreach ($photos as $photo) {
            $affich_photos[] = array(
                'thumbnail' => get_the_post_thumbnail_url($photo->ID, 'full'),
                'title' => get_the_title($photo->ID),
                'categories' => strip_tags(get_the_term_list($photo->ID, 'categorie', '', ', ', '')),
                'reference' => get_field('reference', $photo->ID),
                'permalink' => get_permalink($photo->ID)
            );
        }

        wp_send_json_success($affich_photos);
    } else {
        wp_send_json_error('Missing required parameters');
    }

    wp_die();
}

