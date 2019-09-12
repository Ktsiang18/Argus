<?php
    the_post();

    $arg_title = array('Blargus', $post->post_title);

    get_header();

    $cat_title = 'Blargus';
    $cat_id = 12;
?>
        <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/_styles/blogs.css" />
        <div id="blog" class="span-16">
            <div class="clearfix">
<?php
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
            echo "                <p class=\"photo\" style=\"width: " . arg_photo_width(300, '', '', true) . "px\">\n";
            echo "                    <img src=\"" . arg_photo($post, 300, '', '', true) . "\" />";
            echo "                    <span class=\"photo_caption\"><span class=\"photo_credit\">" . arg_photo_credit($post, true) . "</span> " . arg_photo_caption($post, true) . "</span>";
            echo "                </p>";
        }

        the_content();

        $date = date('M. jS, Y', strtotime($post->post_date));
?>
                <p id="blogTools">Posted <?php echo $date; ?></p>
            </div>
        </div>
        <div id="sidebar" class="span-8 last">
			<a id="blogLogo" href="<?php echo get_category_link(12); ?>"><img src="<?php bloginfo('template_directory'); ?>/_images/blargus.png" /></a>
			<p id="blogByline">Daily opinions on Wes and beyond</p>
<?php
    if (function_exists('akpc_most_popular')) {
        echo "            <div class=\"section\">\n" .
             "                <h2>Most Popular in $cat_title</h2>\n" .
             "                <ol>\n";
        akpc_most_popular_in_cat(5, "                <li>", "</li>\n", $cat_id);
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