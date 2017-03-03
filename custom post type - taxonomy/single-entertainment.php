<?php
/*
Template Name: Single Entertainment
*/
?>
<?php get_header(); ?>

 <div class="container bg-white">
  
  <div class="featured-blocks">
  <div class="row-fluid">

  <?php if(have_posts()) : ?>

    <?php while(have_posts()) : the_post(); ?>

      <div class="post">
         
            <h2 class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
            <?php the_title(); ?></a></h2>
           
               <div class="block-content">
                  <?php the_content(); ?>
              </div>
             <p>Posted by : <?php  the_author(); ?></p>
          </div>  
       
      <?php endwhile; ?>

  <?php endif; ?>
  </div>
  </div>
</div>

<?php get_footer(); ?>
