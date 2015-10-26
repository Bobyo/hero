<?php
	// If a feature image is set, get the id, so it can be injected as a css background property
	if ( has_post_thumbnail( $post->ID ) ) :
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
		$image = $image[0];
		echo '<header id="featured-hero" role="banner" style="background-image: url(\'' . $image .  '\')" ><div class="row valign-middle"><div class="columns large-12 small-12"><h1 class="entry-title">' .get_the_title(). '</h1></div></div></header>';
	endif;
?>
