
<?php get_header() ?>
<div id="page">
	<div id="page-bgtop">
		<div id="page-bgbtm">
			<div id="content">
				<div class="post">
					<?php while (have_posts()) : the_post(); ?>
						<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h2>
						<p class="meta">Posted By <a><?php the_author_link() ?></a> On <?php echo get_the_date() ?> <a href="#" class="comments">Comments (<?php comments_number( 'no responses', 'one response', '% responses' ); ?>)</a> &nbsp;&bull;&nbsp; <a href="#" class="permalink">Full article</a></p>
						<div class="entry">
							<?php the_post_thumbnail(); ?>
							<?php the_content(); ?>
						</div>
					<?php endwhile; ?>
				</div>
			</div>
			<?php get_sidebar() ?>

			<?php get_footer() ?>
