<?php
get_header();

// Get current page slug
$slug   = get_post_field( 'post_name', get_the_ID() );
$custom = get_template_directory() . '/page-' . $slug . '.php';

if ( file_exists( $custom ) ) {
    include( $custom );
} else {
    // Show what slug and path WordPress is looking for
    echo '<div style="padding:40px;background:#fff3cd;border:2px solid orange;margin:20px;">';
    echo '<strong>DEBUG:</strong><br>';
    echo 'Page slug: <code>' . $slug . '</code><br>';
    echo 'Looking for file: <code>' . $custom . '</code><br>';
    echo 'File exists: <code>' . ( file_exists($custom) ? 'YES' : 'NO' ) . '</code>';
    echo '</div>';

    // Fallback content
    while ( have_posts() ): the_post(); ?>
        <div style="padding:48px 5%;max-width:900px;margin:0 auto;">
            <h1><?php the_title(); ?></h1>
            <div><?php the_content(); ?></div>
        </div>
    <?php endwhile;
}

get_footer();
