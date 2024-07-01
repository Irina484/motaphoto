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
        $formatted_photos = array(); // Tableau pour contenir les données des photos formatées

        foreach ($photos as $photo) {
            $formatted_photos[] = array(
                'thumbnail' => get_the_post_thumbnail_url($photo->ID, 'full'),
                'title' => get_the_title($photo->ID),
                'categories' => strip_tags(get_the_term_list($photo->ID, 'categorie', '', ', ', '')),
                'reference' => get_field('reference', $photo->ID)
            );
        }

        wp_send_json_success($formatted_photos);
    } else {
        wp_send_json_error('Missing required parameters');
    }

    wp_die();
}
