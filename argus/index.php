<?php get_header(); ?>
        <div class="span-23 last">
<?php if (have_posts()) : while(have_posts()) : the_post(); ?>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <?php the_excerpt(); ?>
<?php endwhile; else: ?>
            <h3>No results</h3>
            <p>No posts were found matching your criteria.</p>
<?php endif; ?>
        </div>
<?php get_footer(); ?>
