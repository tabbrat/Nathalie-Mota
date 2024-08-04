<?php
get_header();
?>



<?php
if (have_posts()) : while (have_posts()) : the_post();
?>



 <section class="container single_post">
    <div class="post-info">
    <h2 class="single_title"><?php the_title('<h2>'); ?>
       




   </div>


    <div class="post-image">
          <?php the_post_thumbnail(); // photo principal    ?>
     </div>

 </section>


  

  <section class="contact_line">


     <p>Cette photo vous intéresse ?</p>


  </section>



<?php
    endwhile;

endif; ?>


<?php
get_footer();
?>
