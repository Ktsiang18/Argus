<?php get_header(); ?>
        <div id="yui-main"><div class="yui-b" id="arg-left">
<?php if (have_posts()) : while(have_posts()) : the_post(); ?>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <?php the_excerpt(); ?>
<?php endwhile; else: ?>
            <h2>No results</h2>
            <p>No posts were found matching your criteria.</p>
<?php endif; ?>
        </div></div>
<?php get_footer(); ?>
