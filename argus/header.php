<?php

function curLink($page) {
    global $arg_isArchive;

    if (($page == 'home' && is_home()) ||
        ($page == 'archives' && $arg_isArchive) ||
        (is_page($page)) ||
        (!is_home() && in_category($page))) {
        echo ' class="current"';
    }
}

function getTitle() {
    global $arg_title;

    $return_title = 'The Wesleyan Argus';

    if ($arg_title) {
        $arg_title = implode(' — ', array_reverse($arg_title));
        $return_title = "$arg_title — $return_title";
    }

    echo $return_title;
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php getTitle(); ?></title>
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico">
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/_styles/blueprint/screen.css" type="text/css" />
    <!--[if IE]><link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/_styles/blueprint/ie.css" type="text/css"><![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/_styles/screen.css" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/_styles/print.css"
		media="<?=(isset($_GET['print'])?'all':'print')?>" />

    <?php wp_head(); ?>
</head>
<body>
    <div id="header"><div>
        <a id="logo" href="<?php bloginfo('url'); ?>/"><img src="<?php bloginfo('template_directory'); ?>/_images/logo.png" alt="The Wesleyan Argus — Est. 1868" /></a>
        <div id="navigation"><ul>
            <li<?php curLink('home'); ?>><a href="<?php bloginfo('url'); ?>/">home</a></li>
            <li<?php curLink(3); ?>><a href="<?php bloginfo('url'); ?>/section/news/">news</a></li>
            <li<?php curLink(4); ?>><a href="<?php bloginfo('url'); ?>/section/features/">features</a></li>
            <li<?php curLink(12); ?>><a href="<?php bloginfo('url'); ?>/section/online/blargus/">online</a></li>
            <li<?php curLink(16); ?>><a href="<?php bloginfo('url'); ?>/section/opinion/">opinion</a></li>
            <li<?php curLink(13); ?>><a href="<?php bloginfo('url'); ?>/section/wespeaks/">wespeaks</a></li>
            <li<?php curLink(6); ?>><a href="<?php bloginfo('url'); ?>/section/arts/">arts & culture</a></li>
            <li<?php curLink(5); ?>><a href="<?php bloginfo('url'); ?>/section/sports/">sports</a></li>
            <li<?php curLink(15); ?>><a href="<?php bloginfo('url'); ?>/section/ampersand/">ampersand</a></li>
        </ul></div>
    </div></div>

    <div class="container">
