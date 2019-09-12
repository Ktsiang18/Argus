<?php
    $cat_title = single_cat_title('', false);
    $cat_id = get_cat_id($cat_title);

    $num_posts = $wp_query->found_posts;

    $arg_title = array('Section', $cat_title);

    get_header();
?>
        <div id="category" class="span-16">

<?php
    $i = 0;
    if (have_posts()) : while (have_posts()) : the_post();
        $date = the_date('', '', '', false);

        if ($i != 0 && $date)
            echo "            <h2>$date</h2>\n";

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
        <div id="sidebar" class="span-8 last"><div class="inner">
            <div class="section clearfix">
                <form class="clearfix" action="<?php bloginfo('url'); ?>/" onsubmit="location.href='<?php bloginfo('home'); ?>/search/' + encodeURIComponent(this.s.value).replace(/%20/g, '+') + '/'; return false;" method="get" id="search">
            		<div id="search_input">
            			<input class="default" id="s" name="s" value="Search the Argus" />
            		</div>
            		<div id="search_submit">
            			<a><span>&nbsp;</span></a>
            		</div>
                </form>
            </div>
<?php
    if (function_exists('akpc_most_popular')) {
        echo "            <div class=\"section\">\n" .
             "                <h2>Most Popular in $cat_title</h2>\n" .
             "                <ol>\n";
        akpc_most_popular_in_cat(5);
        echo "                </ol>\n";
        echo "            </div>\n";

    }

    // most commented posts
    if (function_exists('mdv_most_commented')) {
        echo "            <h2>Most Commented in $cat_title</h2>\n            <ol>";
        mdv_most_commented(5, '<li>', '</li>', false, '', $cat_id);
        echo "\n            </ol>\n";
    }
?>
        </div></div>
<?php get_footer(); ?>