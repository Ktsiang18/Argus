<?php

$displayedPosts = getDisplayedPosts();

$primary = $displayedPosts['primary'];
$secondary = $displayedPosts['secondary'];
$cat_posts = $displayedPosts['cat_posts'];

?>
<?php get_header(); ?>
        <div class="span-21">
            <div class="section clearfix">
                <div id="primary" class="span-10">
<?php $post = get_post($primary); setup_postdata($post); ?>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p class="photo">
                        <a href="<?php the_permalink(); ?>"><?php arg_photo($post, 330); ?></a>
                        <span class="photo_caption clearfix"><span class="photo_credit"><?php arg_photo_credit(); ?></span> <?php arg_photo_caption(); ?></span>
                    </p>
                    <?php the_excerpt(); ?>
                </div>
                <div id="secondary" class="span-11 last">
<?php foreach ($secondary as $post_id): $post = get_post($post_id); setup_postdata($post); ?>
                    <a href="<?php the_permalink(); ?>"><?php arg_photo_cropped($post, 75, false, 'right'); ?></a>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <?php the_excerpt(); ?>
<?php endforeach; ?>
                </div>
            </div>
<?php
    /* this code is incredibly messy. I'm going to just echo the html in this section since there's more logic than html */

    $i = 0;
    foreach ($cat_posts as $cat_id => $posts):
        $cat = get_category($cat_id);
        $cat_name = $cat->name;
    
        $last = (($i - 2) % 3 == 0) ? ' last' : '';
    
        if ($i % 3 == 0):
            if ($i > 0):
?>
            </div>
<?php       endif; ?>
            <div class="section clearfix">
<?php   endif; ?>
                <div class="span-7<?php echo $last; ?>">
                    <h2><?php echo $cat_name; ?></h2>
                    <ul>
<?
        foreach ($posts as $post_id):
            $post = get_post($post_id); setup_postdata($post);
?>
                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php   endforeach; ?>
                    </ul>
                </div>
<?
        $i++;
    endforeach;
?>
            </div>
        </div>
        <div id="sidebar" class="span-7 last"><div class="inner">
            <div class="section">
                <h2>Dec. 5th, 2008 — Vol. CXLIV, No. 23</h2>
                <p><strong>Today:</strong> Clear 39°F<br /><strong>Tomorrow:</strong> Cloudy 28°F</p>
            </div>
            <div id="submit" class="section">
                <p><a href="#"><img src="<?php bloginfo('template_directory'); ?>/_images/submit.png"></a></p>
            </div>
            <div id="wesu" class="section">
                <h2>Listen to WESU live</h2>
                <p id="wesu_button" class="clearfix">
                    <a id="wesu_itunes" href="http://www.wesufm.org/wesu_hi.pls">iTunes &amp; WinAmp</a>
                    <a id="wesu_wimp" href="http://www.wesufm.org/wesu_hi.asx">Windows Media Player</a>
                    <a id="wesu_rp" href="http://www.wesufm.org/wesu_hi.ram">RealPlayer</a>
                </p>
                <p class="more"><a href="http://wesufm.org/">wesufm.org</a> | <a href="http://wesufm.blogspot.com/">wesu blog</a></p>
            </div>
            <div>
<?php
    // popular posts
    if (function_exists('WPPP_show_popular_posts')) {
        echo '<div class="section">';
        WPPP_show_popular_posts('title=<h2>Most Popular</h2>&show=posts');
        echo '</div>';
    }

    // most commented posts
    if (function_exists('mdv_most_commented')) {
        echo '<h2>Most Commented</h2><ol>';
        mdv_most_commented();
        echo '</ol>';
    }
?>
            </div>
        </div></div>
<?php get_footer(); ?>
<?php

function getDisplayedPosts() {
    global $wpdb, $post;

    $latest = $wpdb->get_row("select volume, number, date, lead from wp_arg_issues where active = 1 order by date desc limit 1");
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
    
    $articles = array(); // {337: post, 338: post, 339: post, 340: post}
    
    $primary = null; // 350
    $secondary = array(); // [334, 336, 337, 340]
    $cat_posts = array(); // {4: [337, 340, 343], 16: [338, 339]}
    $used = array(); // [337, 343, 350, 356]
    
    foreach ($wpdb->get_col("select post_id from wp_postmeta where meta_key = '_arg_issue' and meta_value = '$latest_json'") as $post_id) {
        $post = get_post($post_id);
        setup_postdata($post);
    
        // save the post in our articles array
        $articles[$post_id] = $post;
    
        // if it's primary
        if ($post_id == $latest_lead)
            $primary = $post_id;
    
        // if it's secondary
        if (get_post_meta($post_id, '_arg_lead', true))
            $secondary[] = $post_id;
    
        // get its category
        $cats = get_the_category();
        $cat = $cats[0]->term_id;

        // put it in the category
        $cat_posts[$cat][] = $post_id;
    }

    // randomnize the secondary articles
    shuffle($secondary);
    
    $used[] = $primary;
    
    $secondary_disp = array();
    for ($i = 0; $i < 3; $i++) {
        $post_id = $secondary[$i];
    
        if (!in_array($post_id, $used)) {
            $secondary_disp[] = $post_id;
            $used[] = $post_id;
        }
    }
    $secondary = $secondary_disp;
    
    $cat_posts_disp = array();
    foreach ($top_cats as $cat_id => $cat_name) {
        $displayed_posts = array();
    
        for ($i = 0; ($i < 3 && $i < count($cat_posts[$cat_id])); $i++) {
            $post_id = $cat_posts[$cat_id][$i];
    
            if (in_array($post_id, $used))
                break;
            else {
                $displayed_posts[] = $post_id;
                $used[] = $post_id;
            }
        }
    
        if (count($displayed_posts) > 0) {
            $cat_posts_disp[$cat_id] = array();
    
            for ($i = 0; $i < count($displayed_posts); $i++)
                $cat_posts_disp[$cat_id][] = $displayed_posts[$i];
        }
    }
    $cat_posts = $cat_posts_disp;

    return array('primary' => $primary, 'secondary' => $secondary, 'cat_posts' => $cat_posts);
}

?>