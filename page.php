<?php
get_header(); ?>
<div id="page">
    <div id="page-bgtop">
    <h2><?php the_breadcrumb(); ?></h2>
        <div id="page-bgbtm">
            <div id="content">
                <div class="post">
                    <?php the_post(); ?>
                    <?php the_Content(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php get_sidebar(); ?>

    <?php get_footer(); ?>
