<?php
// Vérifie si la fonction wp_body_open n'existe pas (pour compatibilité avec les versions antérieures à WordPress 6.6.1)
if ( ! function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
        // Permet d'ajouter des actions à wp_body_open via les hooks
        do_action( 'wp_body_open' );
    }
}

//-----------------------------------------Fonction pour charger le style du thème,js-------------------------------------
function nathalie_mota_theme() {
    // Enfile le fichier CSS principal du thème
    wp_enqueue_style( 'Nathalie-Mota-style', get_stylesheet_uri(), array(), '1.0' );
}


// Fonction pour charger les scripts JS personnalisés
function enqueue_my_scripts() {
    // Enfile le script JS principal du thème
    wp_enqueue_script('my-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), null, true);

    // Passe l'URL du template (chemin du thème) au script JS
    wp_localize_script('my-scripts', 'myTheme', array(
        'templateUrl' => get_template_directory_uri(),
    ));

    // Passe l'URL pour les requêtes AJAX au script JS
    wp_localize_script('my-scripts', 'myAjax', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
    ));

    // activer les Dashicons sur le front-end 
    wp_enqueue_style ( 'dashicons' ); 
}
//----------------------------------------fonction chargement plus de photos----------------------------------------------
// Fonction pour charger plus de photos via AJAX
function load_more_photos() {
    // Récupère la page actuelle envoyée par l'appel AJAX
    $paged = $_POST['page'];
    
    // Définition des arguments pour la requête WP_Query
    $args = array(
        'post_type' => 'photo', // Type de contenu 'photo'
        'posts_per_page' => 8,  // Nombre de photos par page
        'paged' => $paged,      // Page actuelle
    );

    // Exécute la requête WP_Query avec les arguments définis
    $query = new WP_Query($args);

    // Vérifie s'il y a des résultats à afficher
    if ($query->have_posts()) :
        // Boucle pour afficher les photos
        while ($query->have_posts()) : $query->the_post(); ?>
            <article class="card">
                <h2 class="title"><?php the_title(); ?></h2>
                <a href="<?php echo get_the_post_thumbnail_url(); ?>" class="lightbox-trigger">
                    <img class="post_img" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" />
                </a>
            </article>
        <?php endwhile;
    endif;

    // Réinitialise les données du post
    wp_reset_postdata();
    
    // Termine correctement l'appel AJAX
    die();
}

//---------------------------------------liens creation menu defauts wordpress--------------------------------------------
// créer un lien pour la gestion des menus dans l'administration
// et activation d'un menu pour le header et d'un menu pour le footer
// Visibles ensuite dans Apparence / Menus (after_setup_theme)
function register_my_menu(){
    register_nav_menu('header', "Menu principal");
    register_nav_menu('footer', "Menu pied de page");
 }
 
//------------------------------------Liens bouton contact page d accuril-------------------------------------------------
function modify_menu_item($items, $args) {
    // Vérifie si nous sommes sur le menu principal
    if ($args->theme_location == 'primary') {
        // URL de la page de contact
        $contact_url = esc_url(get_permalink(get_page_by_path('contact')));

        // Cible l'élément avec l'ID spécifique "menu-item-189"
        $search = 'id="menu-item-189"';
        
        // Remplace l'élément par un lien vers la page de contact
        $replace = 'id="menu-item-189" class="menu-item-189"><a href="' . $contact_url . '" class="contact-button">Contact</a>';
        
        // Remplace dans les éléments du menu
        $items = str_replace($search, $replace, $items);
    }
    return $items;
}
//------------------------------------fonctions filtrage arguments--------------------------------------------------------

// Fonction pour filtrer les photos selon la catégorie, le format, et l'ordre
function filter_photos() {
    // Récupère les filtres envoyés par l'appel AJAX
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : 'DESC';

    // Définit les arguments pour la requête WP_Query
    $args = array(
        'post_type' => 'photo', // Type de contenu 'photo'
        'orderby' => 'date',    // Trie par date
        'order' => $order,      // Ordre (ASC/DESC)
        'posts_per_page' => -1, // Affiche toutes les photos correspondant aux filtres
    );

    // Filtre par catégorie si une catégorie est sélectionnée
    if ($category && $category != 'ALL') {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie', // Taxonomie 'categorie'
            'field'    => 'slug',      // Filtre par slug
            'terms'    => $category,   // Valeur du slug à filtrer
        );
    }

    // Filtre par format si un format est sélectionné
    if ($format && $format != 'ALL') {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',  // Taxonomie 'format'
            'field'    => 'slug',    // Filtre par slug
            'terms'    => $format,   // Valeur du slug à filtrer
        );
    }

    // Exécute la requête WP_Query avec les arguments définis
    $query = new WP_Query($args);

    // Vérifie s'il y a des résultats à afficher
    if ($query->have_posts()) {
        // Boucle pour afficher les résultats filtrés
        while ($query->have_posts()) {
            $query->the_post();
            echo '<article class="card">';
            echo '<h2 class="title">' . get_the_title() . '</h2>';
            echo '<img class="post_img" src="' . get_the_post_thumbnail_url() . '" />';
            echo '</article>';
        }
    } else {
        // Message si aucun résultat n'est trouvé
        echo '<p>Aucun résultat trouvé.</p>';
    }

    // Réinitialise les données du post
    wp_reset_postdata();
    
    // Termine correctement l'appel AJAX
    wp_die();
}

//------------------------------------  Les actions: add_action   ----------------------------------------------------------------------------------//
//----Les actions:des hooks que le noyau WP lance à des moments précis de l'exécution ou lorsque des événements spécifiques se produisent.----------//
//----Les plugins peuvent spécifier qu'une ou plusieurs de ses fonctions PHP sont exécutées à ces moments-là, à l'aide de l'API Action.-------------//
//--------------------------------------------------------------------------------------------------------------------------------------------------//
// Ajoute l'action pour enqueuer les styles lors du chargement des scripts
// 'wp_enqueue_scripts' est le hook utilisé pour ajouter les styles et les scripts
// 'nathalie_mota_theme' est la fonction appelée pour enqueuer les styles
add_action('wp_enqueue_scripts', 'nathalie_mota_theme');

// Active la prise en charge de l'ajout automatique du titre du site dans la balise <title> de l'en-tête HTML
// 'title-tag' permet à WordPress de gérer le titre du site dynamiquement sans avoir à l'ajouter manuellement dans le thème
add_theme_support('title-tag');

// Ajoute l'action pour enqueuer les scripts JS lors du chargement des scripts
// 'enqueue_my_scripts' est la fonction appelée pour enqueuer les scripts JavaScript
add_action('wp_enqueue_scripts', 'enqueue_my_scripts');

// Ajoute l'action pour enregistrer les menus personnalisés du thème après la configuration initiale du thème
// 'register_my_menu' est la fonction appelée pour enregistrer les emplacements de menus
add_action('after_setup_theme', 'register_my_menu');

// Ajoute une action AJAX pour filtrer les photos pour les utilisateurs connectés
// 'wp_ajax_filter_photos' est le hook utilisé pour l'action AJAX côté utilisateur connecté
// 'filter_photos' est la fonction appelée pour traiter la requête AJAX
add_action('wp_ajax_filter_photos', 'filter_photos');

// Ajoute une action AJAX pour filtrer les photos pour les utilisateurs non connectés
// 'wp_ajax_nopriv_filter_photos' est le hook utilisé pour l'action AJAX côté utilisateur non connecté
// 'filter_photos' est la fonction appelée pour traiter la requête AJAX
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');

// Ajoute une action AJAX pour charger plus de photos pour les utilisateurs connectés
// 'wp_ajax_load_more_photos' est le hook utilisé pour l'action AJAX côté utilisateur connecté
// 'load_more_photos' est la fonction appelée pour traiter la requête AJAX
add_action('wp_ajax_load_more_photos', 'load_more_photos');

// Ajoute une action AJAX pour charger plus de photos pour les utilisateurs non connectés
// 'wp_ajax_nopriv_load_more_photos' est le hook utilisé pour l'action AJAX côté utilisateur non connecté
// 'load_more_photos' est la fonction appelée pour traiter la requête AJAX
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');


//------------------------------------   Les actions: add_filter  -----------------------------------------------------------------------------------//
//----WordPress propose des hooks de filtrage pour permettre aux plugins de modifier différents types de données internes lors de l'exécution..------//
//----Un plugin peut modifier des données en liant un rappel à un hook de filtre.peu modifier une valeur en renvoyant une nouvelle valeur.-----------//
//---------------------------------------------------------------------------------------------------------------------------------------------------//

// Modifie les éléments du menu de navigation via un filtre
// 'wp_nav_menu_items' est le hook utilisé pour modifier les éléments de menu
// 'modify_menu_item' est la fonction appelée pour appliquer la modification
// '10' est la priorité du filtre, et '2' indique que la fonction accepte deux arguments (les éléments du menu et les arguments du menu)
add_filter('wp_nav_menu_items', 'modify_menu_item', 10, 2);