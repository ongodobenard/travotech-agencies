<?php
/* index.php — fallback for all other pages */
get_header(); ?>
<div style="padding:48px 5%;max-width:800px;margin:0 auto;">
  <?php if (have_posts()): while (have_posts()): the_post(); ?>
    <h1 style="font-family:'Playfair Display',serif;color:var(--text);margin-bottom:16px;"><?php the_title(); ?></h1>
    <div style="font-size:.88rem;color:var(--text-mid);line-height:1.8;"><?php the_content(); ?></div>
  <?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>
