
<?php get_header(); ?>
<main class="site-main">


<section class="hero">

    ici le hero
<h1>PHOTOGRAPH EVENT</h1>
</section>
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
                <article class="card  ">
  <h2 class="title"><?php echo the_title(); ?></h2>
                    <img class="post_img" src="<?php echo get_the_post_thumbnail_url(); ?>" />
                </article>
        <?php    endwhile;
            else :
                _e('Sorry, no posts were found.', 'textdomain');
        endif;
        wp_reset_postdata();
    ?>
</section>
</main>
<?php get_footer(); ?>
