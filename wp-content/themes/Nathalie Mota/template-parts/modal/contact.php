<?php
/**
 * Modal contact
 */
?>

<div class="popup-overlay hidden ">
  <div class="popup-contact">
    <div class="popup-title__container">
      <!--<img class="popup-close" src="<?php echo get_stylesheet_directory_uri() . '/assets/img/contact.png'?>" alt="Page contact"> --> 
      <div class="popup-title"></div>
    </div>
    <div class="popup-informations"> 
      <?php
        // Assurez-vous que vous insérez le formulaire qu'une seule fois
        echo do_shortcode('[contact-form-7 id="01e478d" title="Contact form 1"]');
      ?>
    </div>  
  </div>
</div>
