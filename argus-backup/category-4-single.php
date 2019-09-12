<?php get_header(); ?>

        <div id="yui-main"><div class="yui-b" id="arg-left">
        This is reaaal special.
<?php while (have_posts()) : the_post(); ?>
            <input name="post_id" id="post_id" value="<?php the_ID(); ?>" type="hidden">

<?php arg_photo($post, 256); ?>
<?php arg_photo_cropped($post, 128); ?>

<h2><?php the_title(); ?></h2>

<?php the_content(); comments_template(); ?>

<?php endwhile; ?>
        </div></div>

        <div class="yui-b" id="arg-sidebar">
            <h2>Story options</h2>
            <p>This is the sidebar.<br>This is the sidebar.<br>This is the sidebar.<br>This is the sidebar.<br>This is the sidebar.<br>This is the sidebar.</p>
<?php if (related_posts_exist()) related_posts(); ?>
        </div>

<?php get_footer(); ?>
