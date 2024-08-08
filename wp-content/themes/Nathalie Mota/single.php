<?php
get_header();
?>

<?php 
// Vérifier l'activation de ACF
if ( !function_exists('get_field')) return;

// Récupérer la taxonomie actuelle
$term = get_queried_object();
$term_id  = $term ? $term->term_id : null;
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php 
// Récupération du nom de la catégorie et du format
$Formats = get_field('format-acf') ? get_field('format-acf') : 'Inconnu';
$reference = get_post_meta(get_the_ID(), 'reference', true);
$type = get_field('type') ? get_field('type') : 'Inconnu'; 
?>
 
<section class="container single_post">
    <div class="post-info">
        <!-- Affiche titre photo -->
        <h2 class="single_title"><?php echo get_the_title(); ?></h2>
        <!-- Affiche les données ACF -->
        <div class="event-meta">
            <ul>
                <li>Référence : <?php echo $reference; ?></li>
                <li>catégorie :<?php the_terms(get_the_ID(), 'categorie', false);?></li>
                <li>format : <?php echo the_terms(get_the_ID(), 'format', false) ?></li>
                <li>type : <?php echo $type; ?></li>
                <li>année :<?php the_date('Y'); ?></li>
            </ul>
        </div>
    </div>
    <div class="post-image">
        <?php the_post_thumbnail('custom-size'); ?>
    </div>
</section>  

<section class="contact_line">
    <div class="contact-section">
        <p>Cette photo vous intéresse ? </p>
        <a href="mailto:example@example.com" class="contact-button">
            Contact
        </a>
    </div>
</section>

<?php endwhile; endif; ?>

<?php
$args = array (
    'post_type' => 'photo', 
    'posts_per_page' => 2, 
    'orderby' => 'rand',
    "post__not_in" => array(get_the_ID()) // exclure la photo du post single.php
);  

$query = new WP_Query($args);
?>

<section class="container_bas">
    <h3>VOUS AIMEREZ AUSSI</h3>
    <div class="img-bas">
        <?php if( $query->have_posts() ) : while($query->have_posts()): $query->the_post(); ?>
            <article class="cardb">
                <img class="post-img" src="<?php echo get_the_post_thumbnail_url(); ?>" />
            </article>
        <?php endwhile; endif; wp_reset_postdata(); ?>
    </div>
</section>

<?php
get_footer();
?>



