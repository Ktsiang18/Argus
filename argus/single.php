<?php

// custom category?

$cats = array(12);

foreach ($cats as $cat) {
    if (in_category($cat) && file_exists("wp-content/themes/argus/category-$cat-single.php")) {
        include("wp-content/themes/argus/category-$cat-single.php");
        die;
    }
}

the_post();

$arg_title = array(get_the_title());

get_header();

?>
        <div class="span-18">
            <div id="article" class="section clearfix">
<?php
    $this_issue = json_decode(get_post_meta($post->ID, '_arg_issue', true));
    $latest_issue = $wpdb->get_row("select volume, number, date, lead from wp_arg_issues where active = 1 order by date desc limit 1");

    $issue_link = ($this_issue->volume == $latest_issue->volume && $this_issue->number == $latest_issue->number) ?
        '/' : '/issue/' . strtolower(_roman($this_issue->volume)) . '/' . $this_issue->number . '/';
    $issue_link = get_bloginfo('wpurl') . $issue_link;

    $issue_date = $wpdb->get_var("select date from wp_arg_issues where volume = {$this_issue->volume} and number = {$this_issue->number}");
    $issue_date = date('M. jS, Y', strtotime($issue_date));
    $issue_string = $issue_date . ' — Vol. ' . _roman($this_issue->volume) . ', No. ' . $this_issue->number;

    $this_cat = get_the_category();
    $this_cat_name = $this_cat[0]->name;
    $this_cat_link = get_category_link($this_cat[0]->term_id);

    echo "                <h2>{$post->post_title}</h2>\n";

    $byline = '';

    if (arg_has_authors()) {
        $byline = arg_authors();
        $byline = 'By ' . $byline;

        if (arg_has_byline_sub())
            $byline .= ', ' . arg_byline_sub(true);
    }

    echo "                <p class=\"byline\">$byline</p>";

    if (arg_has_photo($post)) {
        echo "                <p class=\"photo\" style=\"width: " . arg_photo_width(330, '', '', true) . "px\">\n";
        echo "                    <img src=\"" . arg_photo($post, 330, '', '', true) . "\" />";
        echo "                    <span class=\"photo_caption\"><span class=\"photo_credit\">" . arg_photo_credit($post, true) . "</span> " . arg_photo_caption($post, true) . "</span>";
        echo "                </p>";
    }

    the_content();
?>
            </div>
            <div id="comments">
<?php comments_template(); ?>
            </div>
        </div>
        <div id="sidebar" class="span-7 last"><div class="inner">
            <div class="section">
                <h2><?php echo $issue_string; ?></h2>
                <ul>
                    <li><a href="<?php echo $issue_link; ?>">See this issue</a> »</li>
                    <li><a href="<?php echo $this_cat_link; ?>">More in <?php echo $this_cat_name; ?></a> »</li>
                </ul>
            </div>
            <div id="story_tools" class="section">
                <h2>Story Tools</h2>
                <ul>
                    <li><img src="<?php bloginfo('template_directory'); ?>/_images/printer.png" /><a href="?print">Print</a></li>
<!--                    <li><img src="<?php bloginfo('template_directory'); ?>/_images/email.png" /><a href="/email/<? echo $post->ID; ?>/" target="_blank"
                    	onclick="email(<?=$post->ID?>);return false;">Email</a></li>-->
                    <!-- li>
						<img src="<?php bloginfo('template_directory'); ?>/_images/digg.png" />
						<a href="#">Digg</a>
					</li -->
                    <li><img src="<?php bloginfo('template_directory'); ?>/_images/facebook.png" /><a
							target="_blank"
							href="http://www.facebook.com/sharer.php?u=<?=urlencode(get_permalink($post->ID));?>&t=<?=urlencode($post->post_title); ?>">Facebook</a></li>
                </ul>
            </div>
<?php if (function_exists('related_posts_exist') && related_posts_exist()) related_posts(); ?>
        </div></div>
<?php get_footer(); ?>
