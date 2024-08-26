<?php get_header(); ?>
<!-- Inclut header.php où le DOCTYPE est défini, ce qui peut causer le "Quirks Mode" (mode bizarreries) -->
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
                        <!-- Si le post a une image mise en avant, on l'affiche avec un lien vers l'article complet -->
                        <a href="<?php the_permalink(); ?>" alt="<?php the_title(); ?>"><?php the_post_thumbnail('hero'); ?></a>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
        </div>
        <?php wp_reset_postdata(); // Réinitialise les données post pour la requête principale ?>
    </section>
<!---   -------------------------------------section filtres--------------------------------------------------------------------   --->
    <!-- Filtres -->
    <div class="filters-and-sort">
        <!-- Filtre | Catégorie -->
        <select name="category-filter" id="category-filter">
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
        <select name="format-filter" id="format-filter">
            <option value="ALL">FORMAT</option>
            <?php
            $photo_formats = get_terms('format');// Récupère les termes de la taxonomie 'format'
            // Affiche chaque format comme option du menu déroulant
            foreach ($photo_formats as $format) {
                echo '<option value="' . $format->slug . '">' . $format->name . '</option>';
            }
            ?>
            <option value="1/1">1/1</option>
            <option value="1/4">1/4</option>
        </select>

        <!-- Filtre | Trier par date -->
        <select name="date-sort" id="date-sort">
            <option value="ALL">TRIER PAR</option>
            <option value="DESC">Du plus récent au plus ancien</option>
            <option value="ASC">Du plus ancien au plus récent</option>
        </select>
    </div>

    <!-- Titre de la section -->
    <div>
        <h1>PHOTOGRAPHE EVENT</h1>
    </div>
<!---   -------------------------------------section charger plus--------------------------------------------------------------------   --->
    <!-- Section | Photos avec Lightbox et Bouton Charger Plus -->
    <section class="photos_container">
        <?php
        // Arguments pour la requête principale des photos
        $args = array(
            'post_type' => 'photo',        // Type de contenu 'photo'
            'posts_per_page' => 8,         // Nombre de photos à afficher initialement
        );
        $query = new WP_Query($args);

        if ($query->have_posts()) :
            // Boucle pour afficher chaque photo sous forme de carte
            while ($query->have_posts()) : $query->the_post();
                $post_id = get_the_ID();  // Récupère l'ID du post actuel
        ?>
               <!-- Carte individuelle pour chaque photo -->
<article class="card">
        <h2 class="title"><?php the_title(); ?></h2>
        <h2 class="categorie"><?php the_terms(get_the_ID(), 'categorie'); ?></h2>
        <a href="<?php echo get_the_post_thumbnail_url(); ?>" class="lightbox-trigger">
        <img class="post_img" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" />
        <img class="oeil" src="<?php echo get_the_post_thumbnail_url('assets/img/eye.png'); ?>" alt="oeil" />
        <img class="fullscreen" src="<?php echo get_the_post_thumbnail_url('assets/img/fullscreen.png'); ?>" alt="fullscreen.png" />
    </a>
</article>
        <?php endwhile;
        endif;
        wp_reset_postdata(); // Réinitialise les données post pour la requête principale ?>
        
    </section>
<!---   -------------------------------------bouton charger plus--------------------------------------------------------------------   --->
    <!-- "Charger Plus" -->
    <div class="galerie_btn">
        <input id="load-more" class="galbtn" type="button" value="Charger plus">
    </div>

</main>
<?php get_footer(); ?> 