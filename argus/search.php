<?php
    $query = $_GET['s'];

    $arg_title = array('Search', $query);
    get_header();
    
    $num_posts = $wp_query->found_posts;
?>
        <div id="category" class="span-16">

<?php
    $i = 0;
    if (have_posts()) : while (have_posts()) : the_post();
        $section = ($i != $num_posts - 1) ? 'section' : '';
?>
            <div class="<?php echo $section; ?> clearfix">
<?php
        if (arg_has_photo())
            echo "                        <p class=\"photo\"><a href=\"" . get_permalink() . "\"><img src=\"" .
                 arg_photo_cropped($post, 113, '', '', true) . "\" /></a></p>\n";

        echo "                        <h3><a href=\"" . get_permalink() . "\">{$post->post_title}</a></h3>\n" .
             "                        <p>{$post->post_excerpt}</p>\n";
?>
            </div>
<?php
            ++$i;
        endwhile;
?>
            <p class="more"><?php posts_nav_link('','&laquo; Newer posts','') ?> <span style="float: right"><?php posts_nav_link('','','Older posts &raquo;') ?></span></p>
<?php
    else:
?>
            <h3>No results</h3>
            <p>No posts were found matching your criteria.</p>
<?php endif; ?>
        </div>
        <div id="sidebar" class="span-7 last"><div class="inner">
            <div class="section clearfix">
                <form class="clearfix" action="<?php bloginfo('url'); ?>/" onsubmit="location.href='<?php bloginfo('home'); ?>/search/' + encodeURIComponent(this.s.value).replace(/%20/g, '+') + '/'; return false;" method="get" id="search">
            		<div id="search_input">
            			<input class="default" id="s" name="s" value="<?php echo $query; ?>" />
            		</div>
            		<div id="search_submit">
            			<a><span>&nbsp;</span></a>
            		</div>
                </form>
            </div>
            <h2>Search results for “<?php echo $query; ?>”</h2>
            <p><?php echo $num_posts; ?> results found</p>
<?php
?>
        </div></div>
<?php get_footer(); ?>