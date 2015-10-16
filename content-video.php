<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if(strlen( get_the_title() ) >0 ): ?>

    <?php endif; ?>
    <?php
        $parsedUrl  = parse_url(get_the_content());
        $embed      = $parsedUrl['query'];
        parse_str($embed, $out);
        $embedUrl   = $out['v'];
    ?>
    <iframe width="100%" height="300" src="http://www.youtube.com/embed/<?php echo substr($embedUrl, 0, 11); ?>" frameborder="0" allowfullscreen></iframe>
    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <section class="content-body"><?php the_content('Continue reading...'); ?></section>
</article>
