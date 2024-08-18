<!DOCTYPE html>
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
	<?php wp_body_open(); ?>

    <header>

                <!--On utilise la fonction get_template_directory_uri() afin d’obtenir l’adresse absolue du logo
    (c’est à dire complète). Sans ça,notre image ne s’affichera pas.-->
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo_nathalie_mota.png"alt="Logo <?php echo bloginfo('name'); ?>">

                
    </header>
    