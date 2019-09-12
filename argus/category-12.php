<?php
    $cat_title = single_cat_title('', false);
    $cat_id = get_cat_id($cat_title);

    $num_posts = $wp_query->found_posts;

    $arg_title = array('Section', $cat_title);

    get_header();
?>
        <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/_styles/blogs.css" />
        <div id="blog" class="span-16">

<?php
    $i = 0;
    if (have_posts()) : while (have_posts()) : the_post();
        $date = the_date('', '', '', false);

/*
        if ($i != 0 && $date)
            echo "            <h2>$date</h2>\n";
*/
?>
            <div class="section clearfix">
<?php
/*
        if (arg_has_photo())
            echo "                        <p class=\"photo\"><a href=\"" . get_permalink() . "\"><img src=\"" .
                 arg_photo_cropped($post, 113, '', '', true) . "\" /></a></p>\n";
*/

        echo "                        <h2><a href=\"" . get_permalink() . "\">{$post->post_title}</a></h2>\n";

        $byline = '';
    
        if (arg_has_authors()) {
            $byline = arg_authors();
            $byline = 'By ' . $byline;
    
            if (arg_has_byline_sub())
                $byline .= ', ' . arg_byline_sub(true);
        }
    
        echo "                <p class=\"byline\">$byline</p>\n";

        if (arg_has_photo($post)) {
            echo "                <p class=\"photo\" style=\"width: " . arg_photo_width(300, '', '', true) . "px\">\n" .
                 "                    <a href=\"" . get_permalink() . "\"><img src=\"" .
                 arg_photo($post, 300, '', '', true) . "\" /></a>" .
                 "                    <span class=\"photo_caption\"><span class=\"photo_credit\">" .
                 arg_photo_credit($post, true) . "</span> " . arg_photo_caption($post, true) . "</span>" .
                 "                </p>";
        }

        the_content();
?>
            </div>
<?php
        echo "                <p class=\"more\"><a href=\"" . get_permalink() . "\">Comment on this post &raquo;</a></p>\n";

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
        <div id="sidebar" class="span-8 last">
<!--
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
-->
			<a id="blogLogo" href="<?php echo get_category_link(12); ?>"><img src="<?php bloginfo('template_directory'); ?>/_images/blargus.png" /></a>
			<p id="blogByline">Daily opinions on Wes and beyond</p>
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
        </div>
<?php get_footer(); ?>