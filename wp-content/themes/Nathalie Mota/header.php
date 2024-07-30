<!doctype html>
<!--Permet de définir automatiquement la langue du document. 
Cette valeur est basée sur le réglage WordPress dans Réglages > Général > Langue du site.-->
<html <?php language_attributes(); ?>>

<head>
    <!--Permet de définir l’encodage du site. Par défaut -> UTF-8 prise en charge des caractères spéciaux
    accents, caractères non-latins…-->
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords" content="photographe événementiel, photographe event, nathalie mota, photo format hd" />
    <meta name="description" content="Nathalie Mota - Site personnel pour la vente de mes photos en impression HD." />

    <!– plein de choses entre –>

        <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <header class="header">
        <div class="container">
            <a href="<?php echo home_url('/'); ?>">
                <!--On utilise la fonction get_template_directory_uri() afin d’obtenir l’adresse absolue 
    (c’est-à-dire complète) du logo. Sans ça,notre image ne s’affichera pas.-->
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo_nathalie_mota.png" alt="Logo"> </a>

    </header>