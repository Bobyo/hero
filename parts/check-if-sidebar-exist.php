<?php
  // Display a suitable column layout depending on whether sidebar exists
  if ( is_active_sidebar( 'sidebar-widgets' ) && hero_options( 'hero_hide_sidebar' ) == '0') :
    echo '<div class="small-12 large-8 columns" role="main">';
  else :
    echo '<div class="small-12 large-8 large-push-2 columns" role="main">';
  endif;
?>
