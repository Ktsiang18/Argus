<?php

require_once('../../../../wp-load.php');

$arg_title = array('Staff');

get_header();

global $order;
$order = array('Editor-in-Chief','Managing Editor','Executive Editor',
	'Production Manager','News Editor','Assistant News Editor',
	'Features Editor','Assistant Features Editor','Sports Editor',
	'Assistant Sports Editor','Arts Editor','Assistant Arts Editor',
	'Wespeaks Editor','Photo Editor','Head Layout','Subscriptions Manager',
	'Layout','Business Manager','Advertising Manager','Online Editor',
	'Assistant Online Editor','Comics Editor','Ampersand Editor',
	'Head Copy Editor','Copy Editor','Distribution Manager');

function arg_positions($rs){
	global $order;
	$positions = array();
	foreach($order as $o){
		$positions[$o] = array();
		foreach($rs as $r){
			$pos = explode(' and ',get_usermeta($r['ID'],'_arg_position'));
			foreach($pos as $p)
				if($p == $o) $positions[$o][] = $r;
		}
	}
	foreach($rs as $r){
		$pos = explode(' and ',get_usermeta($r['ID'],'_arg_position'));
		foreach($pos as $p){
			if(!array_search($p,$order)){
				if(array_search($p,array_keys($positions)))
					$positions[$p][] = $r;
				else
					$positions[$p] = array($r);
			}
		}
	}
	return $positions;
}

?>
       <div class="span-27 last">
<?php
$rs = arg_active_staff(ARRAY_A);
$positions = arg_positions($rs);
		foreach($positions as $pos=>$peeps) {
?>
			<div class="argus-position">
				<h1><?=$pos?></h1>
				<ul>
				<? foreach($peeps as $p) { ?>
					<li>
						<a href="/wp-content/plugins/argus-staff/<?=$p['user_login']?>">Image</a>
						<a href="/user/<?=$p['user_login']?>/"><?=$p['meta_value']?></a>
					</li>
				<? } ?>
				<ul>
			</div>
			

		<? } ?>
		</div>
<?php

get_footer();

?>
