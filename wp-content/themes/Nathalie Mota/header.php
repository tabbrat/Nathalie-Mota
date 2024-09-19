<!DOCTYPE html><!-- header.php où le DOCTYPE est défini, si non inserer ici cause : le "Quirks Mode" (mode bizarreries) -->
<html <?php language_attributes(); ?>>
<!-- Définit automatiquement la langue et la direction du texte (par exemple, de gauche à droite) en fonction des réglages WordPress. -->

<head>
    <!-- Définit l'encodage du site. UTF-8 est recommandé pour une prise en charge maximale des caractères. -->
    <meta charset="<?php bloginfo('charset'); ?>" />

    <!-- Assure un rendu correct sur les appareils mobiles, avec un zoom initial de 100%. -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Balises meta pour le SEO (mots-clés et description du site). -->
    <meta name="keywords" content="photographe événementiel, photographe event, nathalie mota, photo format hd" />
    <meta name="description" content="Nathalie Mota - Site personnel pour la vente de mes photos en impression HD." />

    <!-- Titre du document. Il est recommandé d'utiliser une fonction WordPress pour un titre dynamique. -->
    <title><?php wp_title(''); ?></title>

    <!-- Appel des scripts et styles nécessaires au bon fonctionnement de WordPress et des plugins. -->
    <?php wp_head(); ?>
</head>
<!-- Cette fonction est utilisée pour ajouter des hooks juste après l’ouverture du <body>. 
        C’est une bonne pratique dans les thèmes modernes.-->

<body <?php body_class(); ?>>
    <!---Cette ligne ouvre la balise <body> et ajoute des classes dynamiques à l'élément <body> en utilisant la fonction body_class() de WordPress.
    body_class() : Génère automatiquement une liste de classes pour l'élément <body> en fonction du contexte de la page. Par exemple, il peut ajouter
     des classes spécifiques comme home, single, page-id-2, etc., ce qui permet de cibler ces classes dans votre CSS pour personnaliser l'apparence 
     des différentes pages. -->
    <?php wp_body_open(); ?>
    <!--- ette fonction est une nouvelle addition (depuis WordPress 5.2) qui insère un hook wp_body_open juste après l’ouverture de la balise <body>.
    wp_body_open() : Permet aux développeurs de thèmes et de plugins d’ajouter du contenu immédiatement après l’ouverture de la balise <body>
    par exemple des scripts de suivi, des balises de vérification ou d'autres éléments.
    C’est une bonne pratique de l’inclure dans votre thème pour des raisons de compatibilité avec les plugins et autres personnalisations.  --->
    <header>
        <div class="bloc-menu-nav">
            <!--On utilise la fonction get_template_directory_uri() afin d’obtenir l’adresse absolue du logo
    (c’est à dire complète). Sans ça,notre logo ne s’affichera pas.-->
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo_nathalie_mota.png" alt="Logo <?php echo bloginfo('name'); ?>">
            <nav id="navigation">
                <?php
                // Affichage du menu main déclaré dans functions.php
                wp_nav_menu(array('theme_location' => 'header'));
                ?>
                <!-----   ---------------------------------------- Menu Burger-------------------------------------------------------------------   --->
                <div class="bandeau">
                    <div class="logo">
                        <!-- Affiche le logo du site -->
                        <img class="logoburger" src="<?php echo get_template_directory_uri(); ?>/assets/img/logo_nathalie_mota.png" alt="Logo <?php echo bloginfo('name'); ?>">

                        <!-- Bouton pour activer/désactiver le menu burger -->
                        <button type="button" aria-label="toggle curtain navigation" class="nav-toggler">
                            <!-- Trois lignes qui composent le bouton hamburger -->
                            <span class="line l1"></span>
                            <span class="line l2"></span>
                            <span class="line l3"></span>
                        </button>
                    </div>

                    <!-- Menu burger à afficher/cacher -->
                    <div class="nav-burger" id="menuToggle">
                        <ul>
                            <!-- Liens du menu burger -->
                            <a href="#">
                                <li>Accueil</li>
                            </a>
                            <a href="#">
                                <li>À propos</li>
                            </a>
                            <a href="#">
                                <li>Contact</li>
                            </a>
                        </ul>
                    </div>
                </div>
    </header>