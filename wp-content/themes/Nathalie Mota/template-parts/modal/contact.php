<?php

/**
 * Modal contact
 */
?>

<div class="popup-overlay hidden">
  <div class="popup-contact">

    <div class="popup-title__container">
      <div class="popup-title"></div>
      <div class="popup-title"></div>
    </div>

    <div class="popup-informations">
      <?php
      // On insère le formulaire de demandes de renseignements
      // get_field('reference')
      $refPhoto = "";
      if (get_field('reference')) {
        $refPhoto = get_field('reference');
      };
      // Insértion et affichage du formulaire de contact
      echo do_shortcode('[contact-form-7 id="01e478d" title="Contact form 1"]');
      ?>
    </div>
  </div>
</div>