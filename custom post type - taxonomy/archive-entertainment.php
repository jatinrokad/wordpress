<?php
/*
Template Name: Archives Entertainment
*/
?>

<?php get_header(); ?>

 <div class="container bg-white">
  <div class="featured-contents">
  <div class="row-fluid">
<?php
      $args = array( 'post_type' => 'entertainment', 'posts_per_page' => 10 );
      $loop = new WP_Query( $args );
      while ( $loop->have_posts() ) : $loop->the_post();
        ?>
      <h2 class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>

       <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'thumbnail' ) ; ?></a>
<?php

      endwhile;
?>
  </div>
</div>
</div>

<?php get_footer(); ?>
