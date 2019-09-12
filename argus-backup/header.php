<?php

function curLink($catID) {
  if (!is_home() && in_category($catID))
    echo ' class="current"';
}

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Wesleyan Argus Online</title>
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico">
    <link rel="stylesheet" href="http://yui.yahooapis.com/2.5.1/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css">
    <script src="<?php bloginfo('template_directory'); ?>/main.js" type="text/javascript"></script>
</head>
<body>
<div id="hd">
    <form action="<?php bloginfo('url'); ?>/">
        <input value="Search the Argus" id="s" name="s">
    </form>
    <div id="logo"><a href="<?php bloginfo('url'); ?>/">Wesleyan Online Argus Est. 1868</a></div>
    <div id="unfortunatebar"></div>
    <ul>
        <li<?php if (is_home()) echo ' class="current"'; ?>><a href="<?php bloginfo('url'); ?>/">home</a></li>
        <li<?php curLink(3); ?>><a href="<?php bloginfo('url'); ?>/category/news/">news</a></li>
        <li<?php curLink(4); ?>><a href="<?php bloginfo('url'); ?>/category/features/">features</a></li>
        <li<?php curLink(13); ?>><a href="<?php bloginfo('url'); ?>/category/wespeaks/">wespeaks</a></li>
        <li<?php curLink(5); ?>><a href="<?php bloginfo('url'); ?>/category/sports/">sports</a></li>
        <li<?php curLink(6); ?>><a href="<?php bloginfo('url'); ?>/category/arts/">arts</a></li>
        <li<?php curLink(11); ?>><a href="<?php bloginfo('url'); ?>/category/blogs/">blogs</a></li>
    </ul>
    <ul id="subnav">
        <li><a href="about/">about</a></li>
        <li><a href="staff/">staff</a></li>
        <li><a href="submissions/">submissions</a></li>
        <li><a href="advertisers/">advertisers</a></li>
    </ul>
</div>
<div id="doc4" class="yui-t4">
    <div id="bd">
