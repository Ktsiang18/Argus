<?php

require_once('../../../../wp-load.php');

$old_id = intval($_GET['article_id']);

$new_id = $wpdb->get_var("select post_id from wp_postmeta where meta_key = '_arg_old_id' and meta_value = '$old_id';");

$post = get_post($new_id); setup_postdata($post);
$permalink = get_permalink();

header("HTTP/1.1 301 Moved Permanently");
header("Location: $permalink");

?>