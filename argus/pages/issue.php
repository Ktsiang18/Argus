<?php
    require_once('../../../../wp-load.php');

    /* grab and format some useful data */

    $vol = $_GET['vol'];
    $num = $_GET['num'];

    $vol = intval(_arabic($vol));
    $num = intval($num);

    $issue = json_encode(array('volume' => $vol, 'number' => $num));
    $date = $wpdb->get_var("select date from wp_arg_issues where volume = $vol and number = $num");
    $date = date('M. jS, Y', strtotime($date));
    $title_string = "Vol. " . _roman($vol). ", No. $num";
    $issue_string = "$date — " . $title_string;

    // set the title for the page

    $arg_title = array('Issue', $title_string);

    get_header();
    
    $cat_title = single_cat_title('', false);
    $cat_id = get_cat_id($cat_title);
    $num_posts = intval(get_option('posts_per_page'));
?>
        <div id="category" class="span-16">
<?php
    $post_ids = $wpdb->get_col("select post_id from wp_postmeta where meta_key = '_arg_issue' and meta_value = '$issue'");
    foreach ($post_ids as $post_id): $post = get_post($post_id); setup_postdata($post);
?>
            <div class="section clearfix">
<?php
        if (arg_has_photo())
            echo "                        <p class=\"photo\"><a href=\"" . get_permalink() . "\"><img src=\"" .
                 arg_photo_cropped($post, 113, '', '', true) . "\" /></a></p>\n";

        echo "                        <h3><a href=\"" . get_permalink() . "\">{$post->post_title}</a></h3>\n" .
             "                        <p>{$post->post_excerpt}</p>\n";
?>
            </div>
<?php
    endforeach;
?>
            <p class="more"><?php posts_nav_link('','&laquo; Newer posts','') ?> <span style="float: right"><?php posts_nav_link('','','Older posts &raquo;') ?></span></p>
        </div>
        <div id="sidebar" class="span-8 last"><div class="inner">
            <h2><?php echo $issue_string; ?></h2>
        </div></div>
<?php get_footer(); ?>