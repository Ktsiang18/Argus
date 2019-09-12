<?php

require_once('../../../../wp-load.php');

$sections = array('news', 'features', 'arts', 'sports', 'opinion', 'wespeaks', 'ampersand');
$section_name = $_GET['section_name'];

if (in_array($section_name, $sections)) {
    header("HTTP/1.1 301 Moved Permanently");
    header('Location: ' . get_bloginfo('wpurl') . "/category/$section_name/");
}

?>