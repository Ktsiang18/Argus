<?php

require_once('../../../../wp-load.php');

$arg_title = array('Alumni');

get_header();

?>
        <div class="span-27 last">
<?php
$rs = arg_inactive_staff(ARRAY_A);
if($rs){
?>
			<ul>
			<? foreach($rs as $row){ ?>
				<li>
					<a href="/wp-content/plugins/argus-staff/lib/images/<?=$row['user_login']?>.jpg">Image</a>
					- <a href="/user/<?=$row['user_login']?>/"><?=$row['meta_value']?></a>
				</li>	
			<? } ?>
			</ul>
<? } ?>
        </div>
<?php

get_footer();

?>

