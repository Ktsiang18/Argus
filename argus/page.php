<?php get_header(); the_post(); ?>
        <div class="span-18 last">
            <h3><?php the_title(); ?></h3>
            <?php the_content(); ?>
        </div>
<?php get_footer(); ?>