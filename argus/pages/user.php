<?php

require_once('../../../../wp-load.php');
require_once('../../../../wp-includes/registration.php');
require_once('../../../../wp-includes/user.php');

$username = $_GET['username'];
$uid = username_exists($username);

if ($uid) {
	$userinfo = get_userdata($uid);
    $arg_title = array('User', $userinfo->nickname);
}

get_header();

if($uid){
	$photo = "/wp-content/plugins/argus-staff/lib/images/$username.jpg";
	$bio = get_usermeta($uid, 'description');
	$position = get_usermeta($uid, '_arg_position');
	$active = get_usermeta($uid, '_arg_active');
	
	$query = <<<END
SELECT ID, post_title, post_date FROM wp_posts
	JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id
	WHERE wp_postmeta.meta_key = "_arg_author" 
		AND wp_postmeta.meta_value LIKE '%\"username\":\"{$username}\"}'
END;
	$posts = $wpdb->get_results($query, ARRAY_A);
}?>
        <div class="span-27 last">
			<h1><?=$userinfo->nickname?></h1>
			<a href="<?=$photo?>">Photo</a>
			<? if($position) { ?>
			<p id="argus-position">
				<strong>Position:</strong> <?=($active?'':'Former')?> <?=$position?>
			</p>
			<? } if($bio) { ?>
			<p id="argus-biography"><strong>Biography:</strong> <?=$bio?></p>
			<? } if($posts) { ?>
			<h2 id="argus-articlelist-title">Articles</h2>
			<ul id="argus-articlelist">
				<? foreach($posts as $post) { ?>
					<li>
						<a href="<?=get_permalink($post['ID'])?>"><?=$post['post_title']?></a>
					</li>
				<? } ?>
			</ul>
			<? } ?>
        </div>
<?php

get_footer();

?>
