<main class="site-main">
    <?php get_header(); ?>

   <!-- ici le hero -->
    <section class="hero">
     <!-- Slider Area -->
<div class="hero-area">
    <div class="hero-thumbnail">
        <!-- Initialisation de post à afficher -->
        <?php   
            $custom_args = array( 
            'post_type' => 'photo',
            'orderby'   => 'rand',
            'posts_per_page' => 1,
            );
            //On crée ensuite une instance de requête WP_Query basée sur 
            //les critères placés dans la variables $args
            $query_hero = new WP_Query( $custom_args );            
        ?>
        <!-- Récupération d'un post photo en mode aléatoire (rand) -->
        <?php while($query_hero->have_posts()) : ?>
            <?php $query_hero->the_post();?> 
            <?php if(has_post_thumbnail()) : ?>
                <a href="<?php the_permalink(); ?>" alt="<?php the_title(); ?>"><?php the_post_thumbnail('hero'); ?></a>
            <?php endif; ?>                  
                    
        <?php endwhile; ?>            
        <h1 class="title-hero"><?php bloginfo('description'); ?></h1>
    </div>  
</div>
<?php
    // On réinitialise à la requête principale
    wp_reset_postdata();       
?>   
      <div> <h1>PHOTOGRAPH EVENT</h1></div> 
    </section>
     <!-- ici contenu dynamique requettes Query pour appeler les photos et les afficher-->
    <section class="photos_container">
        <?php
        $args = array(
            'post_type' => 'photo',
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) :
            while ($query->have_posts()) :
                $query->the_post();
                $post_id = get_the_ID();
        ?>
                <article class="card">
                    <h2 class="title"><?php echo the_title(); ?></h2>
                    <img class="post_img" src="<?php echo get_the_post_thumbnail_url(); ?>" />
                </article>
        <?php endwhile;
        else :
            _e('Sorry, no posts were found.', 'textdomain');
        endif;
        wp_reset_postdata();
        ?>

    </section>
</main>
<?php get_footer(); ?>