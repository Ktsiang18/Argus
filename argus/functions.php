<?php

// remove the "generated by wordpress" meta tag
remove_action('wp_head', 'wp_generator');

// remove the "windows live writer" meta tag
remove_action('wp_head', 'wlwmanifest_link');

?>