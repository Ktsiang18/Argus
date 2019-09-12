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

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Wesleyan Argus Online</title>
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico">
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/_styles/blueprint/screen.css" type="text/css" />
    <!--[if IE]><link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/_styles/blueprint/ie.css" type="text/css"><![endif]-->
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.6.0/build/fonts/fonts-min.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/_styles/screen.css" />
    <script src="<?php bloginfo('template_directory'); ?>/_scripts/jquery-1.2.6.min.js" type="text/javascript"></script>
    <script src="<?php bloginfo('template_directory'); ?>/_scripts/main.js" type="text/javascript"></script>
    <?php wp_head(); ?>
</head>
<body>
    <div id="unfortunatebar"></div>
    <div class="container">
        <div id="header" class="span-29 last">
            <a id="logo" href="/">The Wesleyan Argus Online - Est. 1868</a>
            <form action="<?php bloginfo('url'); ?>/">
                <input class="default" id="search" name="s" value="Search the Argus..." type="text" />
                <input type="image" src="<?php bloginfo('template_directory'); ?>/_images/go.png" />
            </form>
        </div>
        <div id="nav" class="span-20">
            <ul>
                <li<?php curLink('home'); ?>><a href="<?php bloginfo('url'); ?>/">home</a></li>
                <li<?php curLink(3); ?>><a href="<?php bloginfo('url'); ?>/category/news/">news</a></li>
                <li<?php curLink(4); ?>><a href="<?php bloginfo('url'); ?>/category/features/">features</a></li>
                <li<?php curLink(11); ?>><a href="<?php bloginfo('url'); ?>/category/blogs/">blogs</a></li>
                <li<?php curLink(16); ?>><a href="<?php bloginfo('url'); ?>/category/opinion/">opinion</a></li>
                <li<?php curLink(13); ?>><a href="<?php bloginfo('url'); ?>/category/wespeaks/">wespeaks</a></li>
                <li<?php curLink(6); ?>><a href="<?php bloginfo('url'); ?>/category/arts/">arts and culture</a></li>
                <li<?php curLink(5); ?>><a href="<?php bloginfo('url'); ?>/category/sports/">sports</a></li>
                <li<?php curLink(15); ?>><a href="<?php bloginfo('url'); ?>/category/ampersand/">ampersand</a></li>
            </ul>
        </div>
        <div id="subnav" class="span-8 last">
            <ul id="subnav">
                <li<?php curLink('about'); ?>><a href="<?php bloginfo('url'); ?>/about/">about</a></li>
                <li<?php curLink('staff'); ?>><a href="<?php bloginfo('url'); ?>/staff/">staff</a></li>
                <li<?php curLink('archives'); ?>><a href="<?php bloginfo('url'); ?>/archives/">archives</a></li>
                <li<?php curLink('advertisers'); ?>><a href="<?php bloginfo('url'); ?>/advertisers/">advertisers</a></li>
            </ul>
        </div>
