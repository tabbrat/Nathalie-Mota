<footer>
<?php
// Affichage du menu main déclaré dans functions.php
wp_nav_menu(array('theme_location' => 'footer'));
?>        
</footer>
<!-- Lance la popup contact page single.php -->
<?php
get_template_part('template-parts/modal/contact');
?>


<?php wp_footer(); ?>

</body>

</html>