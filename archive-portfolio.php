<?php
/**
* Template Name: Portfolio Template
*
* @package WordPress
* 
*/
?>

<?php get_template_part( 'template-part/portfolio', 'header' ); ?>

                <?php 
$loop = new WP_Query( array( 'post_type' => 'portfolio') ); 


while ( $loop->have_posts() ) : $loop->the_post();

the_title( '<h3 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h3>' ); 
?>

    <div class="entry-content">
        <?php the_content(); ?>
    </div>

<?php endwhile; ?>

<?php get_template_part( 'template-part/portfolio', 'footer' ); ?>





