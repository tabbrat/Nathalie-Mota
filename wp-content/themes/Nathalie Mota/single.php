<?php
get_header();
?>

<?php
// Vérifier l'activation de ACF
if (!function_exists('get_field')) return;

// Récupérer la taxonomie actuelle
$term = get_queried_object();
$term_id  = $term ? $term->term_id : null;
?>
<!-- Partie haute single.php - Détail de la photo -->
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
                        <li>catégorie :<?php the_terms(get_the_ID(), 'categorie', false); ?></li>
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
        <!--Partie centrale - Contact + photos suivantes et précédentes -->
        <section class="contact_line">
            <div class="contact-section">
                <p>Cette photo vous intéresse ? </p>
                <a href="#" class="contact-button">Contact</a>

                <div class="navigation-avatar">
                    <!-- next_prev_link( '%link', '%title', false );  -->
                    <div class="navigation-prev">
                        <?php
                        $prev_post = get_previous_post();
                        if ($prev_post) {
                            $prev_title = strip_tags(str_replace('"', '', $prev_post->post_title));
                            $prev_post_id = $prev_post->ID;
                            echo '<a rel="prev" href="' . get_permalink($prev_post_id) . '" title="' . $prev_title . '" class="previous_post">';
                            if (has_post_thumbnail($prev_post_id)) {
                        ?>
                                <div>
                                    <?php echo get_the_post_thumbnail($prev_post_id, array(71, 81)); ?></div>
                        <?php
                            } else {
                                echo '<img src="' . get_stylesheet_directory_uri() . '/assets/img/no-image.jpeg" alt="Pas de photo" width="77px" ><br>';
                            }
                            echo '<img src="' . get_stylesheet_directory_uri() . '/assets/img/precedent.png" alt="Photo précédente" ></a>';
                        }
                        ?>

                        <div class="navigation-next">
                            <!-- next_post_link( '%link', '%title', false );  -->
                            <?php
                            $next_post = get_next_post();
                            if ($next_post) {
                                $next_title = strip_tags(str_replace('"', '', $next_post->post_title));
                                $next_post_id = $next_post->ID;
                                echo  '<a rel="next" href="' . get_permalink($next_post_id) . '" title="' . $next_title . '" class="next_post">';
                                if (has_post_thumbnail($next_post_id)) {
                                } else {
                                    echo '<img src="' . get_stylesheet_directory_uri() . '/assets/img/no-image.jpeg" alt="Pas de photo" width="77px" ><br>';
                                }
                                echo '<img src="' . get_stylesheet_directory_uri() . '/assets/img/suivant.png" alt="Photo suivante" ></a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
        </section>

<?php endwhile;
endif; ?>
<!-- Partie basse - Autres photos de la catégorie -->
<?php
$args = array(
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
        <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
                <img class="post-img" src="<?php echo get_the_post_thumbnail_url(); ?>" />
        <?php endwhile;
        endif;
        wp_reset_postdata(); ?>
    </div>
</section>

<?php
get_footer();
?>