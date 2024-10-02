<?php get_header(); ?>


<main id="main" class="site-main" role="main"> <!-- Balise <main> qui définit la partie principale du contenu de la page. 
    L'attribut "id" est utilisé pour identifier cet élément comme étant l'élément principal. "class" ajoute une classe pour des styles CSS
     et "role" indique le rôle de cet élément pour l'accessibilité. -->

    <!-- Boucle WordPress pour afficher le contenu de la page -->
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?> <!-- Vérifie s'il y a des articles ou des pages à afficher.
     La boucle WordPress commence ici. "have_posts()" vérifie s'il y a des articles, et "the_post()" prépare les données pour
      l'article courant à afficher. -->

            <h1><?php get_the_title(); ?></h1> <!-- Affiche le titre de la page ou de l'article avec une balise <h1>. 
                "get_the_title()" est utilisé pour obtenir le titre de l'article ou de la page. -->

            <section class="container"> <!-- Crée une section pour contenir le contenu de la page ou de l'article. 
                La classe "container" est utilisée pour appliquer des styles CSS. -->

                <?php the_content(); ?> <!-- Affiche le contenu principal de la page ou de l'article. 
                "the_content()" récupère et affiche le contenu que l'utilisateur a ajouté dans l'éditeur WordPress. -->

            </section> <!-- Fin de la section contenant le contenu de la page. -->

    <?php endwhile; endif; ?> <!-- Fin de la boucle WordPress. "endwhile" termine la boucle
     et "endif" termine la condition qui vérifie s'il y a des articles à afficher. -->

</main>
<?php get_footer(); ?>