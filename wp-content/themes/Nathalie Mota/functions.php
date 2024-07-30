<?php
// Pour les versions antérieures à WordPress 6.6.1
if ( ! function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
            do_action( 'wp_body_open' );
    }
}

function nathalie_mota_theme() {
    // Chargement du style personnalisé du theme
    wp_enqueue_style( 'Nathalie-Mota-style', get_stylesheet_uri(), array(), '1.0' );
}
add_action('wp_enqueue_scripts', 'nathalie_mota_theme');

// Ajouter automatiquement le titre du site dans l'en-tête du site
add_theme_support( 'title-tag' );

