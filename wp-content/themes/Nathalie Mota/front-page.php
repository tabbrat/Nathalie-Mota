<?php get_header(); ?>

<!-- Inclut dans "header.php" où le DOCTYPE est défini, ce qui peut causer le "Quirks Mode" (mode bizarreries) -->
<!---    -----------------------------------HERO------------------------------------------------------------------------------   --->

<main class="site-main">
    <!-- Section Hero -->
    <section class="hero">
        <!-- Zone du slider aléatoire -->
        <div class="hero-area">
            <div class="hero-thumbnail">
                <!-- Initialisation de la requête pour afficher un post aléatoire -->
                <?php
                $custom_args = array(
                    'post_type' => 'photo',        // Type de contenu 'photo'
                    'orderby'   => 'rand',         // Trier de manière aléatoire
                    'posts_per_page' => 1,         // Limite à un seul post
                );
                $query_hero = new WP_Query($custom_args);
                ?>
                <!-- Boucle pour récupérer et afficher un post aléatoire -->
                <?php while ($query_hero->have_posts()) : ?>
                    <?php $query_hero->the_post(); ?>
                    <?php if (has_post_thumbnail()) : ?>
                        <!-- Si le post a une photo mise en avant, on l'affiche avec un lien vers l'article complet -->
                        <a href="<?php the_permalink(); ?>" alt="<?php the_title(); ?>"><?php the_post_thumbnail('hero'); ?></a>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
        </div>
        <?php wp_reset_postdata(); // Réinitialise les données post pour la requête principale 
        ?>
    </section>

    <!---   -------------------------------------section filtres--------------------------------------------------------------------   --->

    <!-- Filtres -->
    <div class="filters-and-sort">
        <!-- Filtre | Catégorie -->
        <select name="category-filter" class="selectize" id="category-filter">
            <option value="ALL">CATÉGORIE</option>
            <?php
            // Récupère les termes de la taxonomie 'categorie'
            $photo_categories = get_terms('categorie');
            // Affiche chaque catégorie comme option du menu déroulant
            foreach ($photo_categories as $category) {
                echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
            }
            ?>
        </select>

        <!-- Filtre | Format -->
        <select name="format-filter" class="selectize" id="format-filter">
            <option value="ALL">FORMAT</option>
            <?php
            $photo_formats = get_terms('format'); // Récupère les termes de la taxonomie 'format'
            // Affiche chaque format comme option du menu déroulant
            foreach ($photo_formats as $format) {
                echo '<option value="' . $format->slug . '">' . $format->name . '</option>';
            }
            ?>
            <option value="1/1">1/1</option>
            <option value="1/4">1/4</option>
        </select>

        <!-- Filtre | Trier par date -->
        <select name="date-sort" class="selectize" id="date-sort">
            <option value="ALL">TRIER PAR</option>
            <option value="DESC">Du plus récent au plus ancien</option>
            <option value="ASC">Du plus ancien au plus récent</option>
        </select>
    </div>

    <!-- Titre de la section -->
    <div>
        <img class="evento" src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/Titre header.png'); ?>" alt="" />
    </div>

    <!---   -------------------------------------section charger plus---------------------------------------------------------------   --->

    <!-- Section | Photos avec Lightbox et Bouton Charger Plus -->
    <section class="photos_container">
        <?php
        // Définir les arguments pour récupérer les photos
        $args = array(
            'post_type' => 'photo',        // On récupère les posts du type 'photo'
            'posts_per_page' => 8,         // Limite à 8 le nombre de photos affichées initialement
        );

        // Exécute la requête pour obtenir les photos
        $query = new WP_Query($args);

        // Si des photos sont trouvées
        if ($query->have_posts()) :

            // Boucle à travers chaque photo
            while ($query->have_posts()) : $query->the_post();
                $post_id = get_the_ID();  // Récupère l'ID du post actuel
        ?>
                <!-- Carte individuelle pour chaque photo -->
                <article class="card">
                    <h2 class="title"><?php the_title(); ?></h2> <!-- Titre de la photo -->
                    <h2 class="categorie"><?php the_terms(get_the_ID(), 'categorie'); ?></h2> <!-- Récupère et affiche les termes associés à la taxonomie 'categorie' -->

                    <?php
                    // Récupérer la référence via le champ personnalisé ACF (Advanced Custom Fields)
                    $reference = get_field('reference'); // On récupère le champ personnalisé 'reference'
                    ?>

                    <!-- Élément pour afficher la lightbox et les informations de l'image -->
                    <span
                        class="lightbox-trigger"
                        data-category="<?php echo esc_attr(get_the_terms(get_the_ID(), 'categorie')[0]->name); // On récupère et échappe la catégorie associée 
                                        ?>"
                        data-reference="<?php echo esc_attr($reference); // On échappe la référence 
                                        ?>">
                        <!-- Image de la carte -->
                        <img class="post_img" src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" alt="<?php the_title(); ?>" /> <!-- On affiche l'image principale de la photo -->

                        <!-- Icône pour ouvrir la page single.php de la photo -->
                        <a href="<?php the_permalink(); ?>">
                            <img class="oeil" src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/eye.png'); ?>" alt="Oeil" /> <!-- Icône de l'œil (pour accéder à la page de la photo) -->
                        </a>

                        <!-- Icône pour afficher l'image en plein écran -->
                        <img class="fullscreen" src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/fullscreen.png'); ?>" alt="Plein écran" /> <!-- Icône plein écran -->

                        <!-- Overlay caché par défaut, s'affiche au survol -->
                        <div class="overlay">
                            <div class="info">
                                <div class="reference"></div> <!-- Zone pour afficher la référence de la photo dans l'overlay -->
                                <div class="category"></div> <!-- Zone pour afficher la catégorie de la photo dans l'overlay -->
                            </div>
                        </div>
                    </span>
                </article>
        <?php endwhile;  // Fin de la boucle des photos
        endif;  // Fin de la vérification si des photos existent

        wp_reset_postdata(); // Réinitialise les données de post après la boucle pour ne pas interférer avec d'autres requêtes 
        ?>
    </section>



    <!---   -------------------------------------bouton charger plus----------------------------------------------------------------   --->

    <!-- "Charger Plus" -->
    <div class="galerie_btn">
        <input id="load-more" class="galbtn" type="button" value="Charger plus">
    </div>

</main>

<?php get_footer(); ?>