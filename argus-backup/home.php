<?php get_header(); ?>
        <style type="text/css">.alignright { float: right; }</style>

        <div id="yui-main"><div class="yui-b" id="arg-left">
            <div class="yui-gc">
                <div class="yui-u first">
<?php foreach (get_posts('tag=topleft&numberposts=1') as $post) : setup_postdata($post); ?>
                    <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a> <span>by <?php echo get_post_meta($post->ID, 'author', true); ?></span></h2>
                    <?php the_content('More...'); ?>
<?php endforeach; ?>
                </div>

                <div class="yui-u">
<?php foreach (get_posts('tag=topright&numberposts=1') as $post) : setup_postdata($post); ?>
                    <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                    <?php the_content(); ?>
<?php endforeach; ?>
                </div>
            </div>

            <div class="yui-gd" id="arg-bottom">
                <div class="yui-u first">
<?php foreach (get_posts('tag=bottomleft&numberposts=1') as $post) : setup_postdata($post); ?>
                    <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                    <?php the_content(); ?>
<?php endforeach; ?>
                </div>

                <div class="yui-u">
<?php foreach (get_posts('tag=bottomright&numberposts=1') as $post) : setup_postdata($post); ?>
                    <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                    <?php the_content(); ?>
<?php endforeach; ?>
                </div>
            </div>

            <div class="yui-gb">
                <div class="yui-u first">
                    <h2>News</h2>
                    <ul>
<?php foreach (get_posts('category=3&numberposts=5') as $post) : setup_postdata($post); ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endforeach; ?>
                    </ul>
                </div>

                <div class="yui-u">
                    <h2>Features</h2>
                    <ul>
<?php foreach (get_posts('category=4&numberposts=5') as $post) : setup_postdata($post); ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endforeach; ?>
                    </ul>
                </div>

                <div class="yui-u">
                    <h2>Wespeaks</h2>
                    <ul>
<?php foreach (get_posts('category=13&numberposts=5') as $post) : setup_postdata($post); ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div></div>
        <div class="yui-b" id="arg-sidebar">
            <h2>Sidebar</h2>
            <p>This is the sidebar.<br>This is the sidebar.<br>This is the sidebar.<br>This is the sidebar.<br>This is the sidebar.<br>This is the sidebar.</p>
        </div>
<?php get_footer(); ?>
