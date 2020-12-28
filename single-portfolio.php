<?php get_template_part( 'template-part/portfolio', 'header' ); ?>


                <div class="post">
                    <?php while (have_posts()) : the_post(); ?>
                        <h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h2>
                        <p class="meta">Posted By <a><?php the_author_link() ?></a> On <?php echo get_the_date() ?> <a href="#" class="comments">Comments (64)</a> &nbsp;&bull;&nbsp; <a href="#" class="permalink">Full article</a></p>
                        <div class="entry">
                            <?php the_content(); ?>
                        </div>
                    <?php endwhile; ?>
                </div>
                <?php get_template_part( 'template-part/portfolio', 'footer' ); ?>