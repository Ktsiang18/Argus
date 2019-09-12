<?php

$ARG_VER = get_option('arg_version');

$latest = $wpdb->get_row("select volume, number, date, lead from wp_arg_issues where active = 1 order by date desc limit 1");
$latest_date = date('M. jS, Y', strtotime($latest->date));
$latest_string = $latest_date . ' — Vol. ' . _roman($latest->volume) . ', No. ' . $latest->number;

$displayedPosts = getDisplayedPosts();

$primary = $displayedPosts['primary'];
$secondary = $displayedPosts['secondary'];
$all_cat_posts = $displayedPosts['all_cat_posts'];

?>
<?php get_header(); ?>
        <div class="span-20">
            <div class="section clearfix">
                <div id="primary" class="span-10">
<?php
    /* primary article */
    $post = get_post($primary); setup_postdata($post);
    echo "                    <h3><a href=\"" . get_permalink() . "\">{$post->post_title}</a></h3>\n";
    if (arg_has_photo())
        echo "                    <p class=\"photo\"><a href=\"" . get_permalink() ."\"><img src=\"" .
            arg_photo($post, 330, '', '', true) . "&$ARG_VER\" /></a></p>\n" .
        "                    <p>{$post->post_excerpt}</p>\n";
?>
                </div>
                <div id="secondary" class="span-10 last">
<?php
    /* secondary articles */
    foreach ($secondary as $post_id) {
        $post = get_post($post_id); setup_postdata($post);
        if (arg_has_photo())
            echo "                    <p class=\"photo\"><a href=\"" . get_permalink() . "\"><img src=\"" .
                 arg_photo_cropped($post, 113, '', '', true) . "&$ARG_VER\" /></a></p>\n";

        echo "                    <h3><a href=\"" . get_permalink() . "\">{$post->post_title}</a></h3>\n" .
             "                    <p>{$post->post_excerpt}</p>\n";
    }
?>
                </div>
            </div>
<?php
    /* do the blogs on top */
    
    echo "            <div class=\"section strip clearfix\">\n" .
         "                <h2>Online <a href=\"" . get_category_link(12) . "\">More Online »</a></h2>\n";

    // vernon hack
    $blogs = array(7629, 7662, 7627, 7625);

    for ($i = 0; $i < 4; ++$i) {
        $post = get_post($blogs[$i]); setup_postdata($post);
        showBox($i == 3);
    }

    echo "            </div>\n";

    /* and now for the rest of the categories */

    $i = 0;
    foreach ($all_cat_posts as $cat_id => $cat_posts) {
        $cat = get_category($cat_id);
        $cat_name = $cat->name;

        $has_photo = $cat_posts['has_photo'];
        $no_photo = $cat_posts['no_photo'];

        // if it's not the last category, then use the "section"
        // class, which puts a horizontal line underneath the section
        $section = !($i == count($all_cat_posts) - 1) ? 'section' : '';

        echo "            <div class=\"$section strip clearfix\">\n" .
             "                <h2>$cat_name <a href=\"" . get_category_link($cat_id) . "\">More $cat_name »</a></h2>\n";

        if (count($has_photo) >= 4) { // if there are 4 articles with photos
            for ($j = 0; $j < 4; ++$j) {
                $post = get_post($has_photo[$j]); setup_postdata($post);
                showBox($j == 3);
            }
        } else if (count($has_photo) == 3) { // if there are three articles with photos
            for ($j = 0; $j < 3; ++$j) {
                $post = get_post($has_photo[$j]); setup_postdata($post);
                showBox();
            }

            if ($no_photo[0]) { // if there's an additional text article
                $post = get_post($no_photo[0]); setup_postdata($post);
                showBox(true);
            }
        } else if (count($has_photo) == 2) { // if there are two articles with photos
            for ($j = 0; $j < 2; ++$j) {
                $post = get_post($has_photo[$j]); setup_postdata($post);
                showBox();
            }

            if ($no_photo) { // if there's are additional text articles
                $post = get_post($no_photo[0]);
                setup_postdata($post);

                echo "                <div class=\"span-10 last\"><div class=\"inner\">\n" .
                     "                    <h3><a href=\"" . get_permalink() . "\">{$post->post_title}</a></h3>\n" .
                     "                    <p>{$post->post_excerpt}</p>\n" .
                     "                </div></div>\n";
            }
        } else if (count($has_photo) == 1) { // if there is 1 article with a photo
            $post = get_post($has_photo[0]); setup_postdata($post);
            showBox();

            if ($no_photo) { // if there are additional text articles
                echo "                <div class=\"span-15 last\"><div class=\"inner\">\n";
                for ($j = 0; $j < count($no_photo) && $j < 2; ++$j) {
                    $post = get_post($no_photo[0]); setup_postdata($post);

                    echo "                    <h3><a href=\"" . get_permalink() . "\">{$post->post_title}</a></h3>\n";
                    echo "                    <p>{$post->post_excerpt}</p>\n";
                }
                echo "                </div></div>\n";
            }
        } else if (count($no_photo) >= 2) { // if there are at least 4 text articles
            $post = get_post($no_photo[0]); setup_postdata($post);
            echo "                <div class=\"span-12\">" .
                 "                    <h3><a href=\"" . get_permalink() . "\">{$post->post_title}</a></h3>" .
                 "                    <p>{$post->post_excerpt}</p>" .
                 "                </div>";

            $post = get_post($no_photo[1]); setup_postdata($post);
            echo "                <div class=\"span-8 last\">" .
                 "                    <h3><a href=\"" . get_permalink() . "\">{$post->post_title}</a></h3>" .
                 "                    <p>{$post->post_excerpt}</p>" .
                 "                </div>";                 
        } else if (count($no_photo) == 1) {
            $post = get_post($no_photo[0]); setup_postdata($post);
            echo "                <div class=\"span-20\">" .
                 "                    <h3><a href=\"" . get_permalink() . "\">{$post->post_title}</a></h3>" .
                 "                    <p>{$post->post_excerpt}</p>" .
                 "                </div>";
        }

        echo "            </div>\n";

        ++$i;
    }
?>
        </div>
        <div id="sidebar" class="span-7 last"><div class="inner">
            <div class="section clearfix">
                <h2><?php echo $latest_string; ?></h2>
                
                <form class="clearfix" action="<?php bloginfo('url'); ?>/" onsubmit="location.href='<?php bloginfo('home'); ?>/search/' + encodeURIComponent(this.s.value).replace(/%20/g, '+') + '/'; return false;" method="get" id="search">
            		<div id="search_input">
            			<input class="default" id="s" name="s" value="Search the Argus" />
            		</div>
            		<div id="search_submit">
            			<a><span>&nbsp;</span></a>
            		</div>
                </form>
            </div>
            <div id="submit" class="section">
                <p><a href="<?php bloginfo('url'); ?>/submission/" target="_blank" onclick="submission(); return false;"><img src="<?php bloginfo('template_directory'); ?>/_images/submit.png?<?php echo $ARG_VER; ?>"></a></p>
            </div>
            <div id="tabs" class="section">
            	<ul id="tabstabs" class="clearfix"><li id="mostpopular_tab" class="ui-tabs-selected"><a href="#mostpopular">Most Popular</a></li><li id="mostcommented_tab"><a href="#mostcommented">Most Commented</a></li></ul>
<?php
    // popular posts
    if (function_exists('akpc_most_popular')) {
        echo "                <div id=\"mostpopular\">\n" .
             "                    <ol>\n";
        akpc_most_popular(5);
        echo "                    </ol>\n";
        echo "                </div>\n";

    }

    // most commented posts
    if (function_exists('mdv_most_commented')) {
    	echo "	    		<div id=\"mostcommented\" class=\"ui-tabs-hide\">\n";
        echo "                <ol>";
        mdv_most_commented();
        echo "\n                </ol>\n";
        echo "	    		</div>\n";
    }
?>
			</div>

            <div class="section">
                <h2>The Blargus, Updated Daily</h2>
                <a href="<?php echo get_category_link(12); ?>"><img style="margin: 0 0 .5em 1em;" src="<?php bloginfo('template_directory'); ?>/_images/beigeblargus.png" /></a>
                <p class="more"><a href="<?php echo get_category_link(12); ?>">Read now</a></p>
            </div>

            <div id="wesu">
                <h2>Listen to WESU live</h2>
                <p id="wesu_button" class="clearfix">
                    <a id="wesu_itunes" href="http://www.wesufm.org/wesu_hi.pls">iTunes &amp; WinAmp</a>
                    <a id="wesu_wimp" href="http://www.wesufm.org/wesu_hi.asx">Windows Media Player</a>
                    <a id="wesu_rp" href="http://www.wesufm.org/wesu_hi.ram">RealPlayer</a>
                </p>
                <p class="more"><a href="http://wesufm.org/">wesufm.org</a> | <a href="http://wesufm.blogspot.com/">wesu blog</a></p>
            </div>
        </div></div>
<?php get_footer(); ?>
<?php

function showBox($last = false) {
    global $post, $ARG_VER;

    $last = $last ? 'last' : '';

    $photo = arg_has_photo() ? arg_photo($post, '', '155', '', true) . "&$ARG_VER" :
        get_bloginfo('template_directory') . "/_images/text.png?$ARG_VER";

    // vernon hack

    if ($post->ID == 7625)
        $photo = get_bloginfo('template_directory') . "/_images/text.png?$ARG_VER";
    
    echo "                <div class=\"span-5 photobox $last\">\n" .
         "                    <div style=\"background: url($photo)\">\n" .
         "<a href=\"" . get_permalink() . "\"></a></div>\n" .
         "<h3><a href=\"" . get_permalink() . "\">{$post->post_title}</a></h3>\n" .
         "                </div>\n";
}

function getDisplayedPosts() {
    global $wpdb, $post, $latest;

    $latest_json = json_encode(array('volume' => intval($latest->volume), 'number' => intval($latest->number)));
    $latest_lead = $latest->lead;
    
    /* grab the top level categories */
    
    // get all categories, even if they're empty, except 'uncategorized' and 'blogs'
    $all_cats = get_categories('hide_empty=0&exclude=1,11');
    
    // we have to filter out categories that aren't top level (parent == 0) because
    // get_categories doesn't support the "depth" parameter for some reason
    $top_cats = array(); // holds category objects
    foreach ($all_cats as $cat) {
        if ($cat->parent == 0)
            $top_cats[$cat->term_id] = $cat->name;
    }
    
    /* our data structures for holding the various posts */
    
    $posts = array(); // {337: post, 338: post, 339: post, 340: post}

    $primary = null; // 350
    $secondary = array('has_photo' => array(), 'no_photo' => array()); // [334, 336, 337, 340]
    $all_cat_posts = array(); // {4: [337, 340, 343], 16: [338, 339]}
    $used = array(); // [337, 343, 350, 356]

    foreach ($wpdb->get_col("select post_id from wp_postmeta where meta_key = '_arg_issue' and meta_value = '$latest_json'") as $post_id) {
        $post = get_post($post_id);
        setup_postdata($post);
    
        // save the post in our articles array
        $posts[$post_id] = $post;

        // if it's primary
        if ($post_id == $latest_lead)
            $primary = $post_id;
    
        // if it's secondary
        if (get_post_meta($post_id, '_arg_lead', true)) {
            if (arg_has_photo())
                $secondary['has_photo'][] = $post_id;
            else
                $secondary['no_photo'][] = $post_id;
        }
    
        // get its category
        $cats = get_the_category();
        $cat = $cats[0]->term_id;

        if (!$all_cat_posts[$cat])
            $all_cat_posts[$cat] = array();

        // put it in the category
        if (arg_has_photo())
            array_unshift($all_cat_posts[$cat], $post_id);
        else
            array_push($all_cat_posts[$cat], $post_id);
    }

    // randomnize the secondary articles
    shuffle($secondary['has_photo']);
    shuffle($secondary['no_photo']);

    // merge the shuffled, secondary articles
    $secondary = array_merge($secondary['has_photo'], $secondary['no_photo']);

    $used[] = $primary;

    // pluck the top two
    $secondary_disp = array();
    for ($i = 0; count($secondary_disp) < 2 && $i < count($secondary); $i++) {
        $post_id = $secondary[$i];
    
        if (!in_array($post_id, $used)) {
            $secondary_disp[] = $post_id;
            $used[] = $post_id;
        }
    }
    $secondary = $secondary_disp;
    
    $all_cat_posts_disp = array();
    foreach ($top_cats as $cat_id => $cat_name) {
        $displayed_posts = array();

        // only grab the category posts that haven't been used yet
        for ($i = 0; $i < count($all_cat_posts[$cat_id]); $i++) {
            $post_id = $all_cat_posts[$cat_id][$i];

            if (!in_array($post_id, $used)) {
                $displayed_posts[] = $post_id;
                $used[] = $post_id;
            }
        }

        // if there are any posts in this category, then construct an array
        // with the photo articles and non-photo articles separated
        if (count($displayed_posts) > 0) {
            $cat_posts_disp[$cat_id] = array('has_photo' => array(), 'no_photo' => array());

            foreach ($displayed_posts as $post_id) {
                $post = get_post($post_id);
                setup_postdata($post);

                if (arg_has_photo())
                    $cat_posts_disp[$cat_id]['has_photo'][] = $post_id;
                else
                    $cat_posts_disp[$cat_id]['no_photo'][] = $post_id;
            }
        }
    }
    $all_cat_posts = $cat_posts_disp;

    return array('primary' => $primary, 'secondary' => $secondary, 'all_cat_posts' => $all_cat_posts);
}

?>