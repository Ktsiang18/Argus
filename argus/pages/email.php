<?

require_once('../../../../wp-load.php');
require_once(ABSPATH.'wp-content/themes/argus/pages/swift/Swift.php');
require_once(ABSPATH.'wp-content/themes/argus/pages/swift/Swift/Connection/Sendmail.php');

function showError($field, $name){
	global $values;
	global $fields;
	global $errors;
	if(!$values[$field] && $fields[$field] && $errors)
		echo "<span class='argus-error'>The <strong>$name</strong> field must be completed and valid.</span>";
}

function prevValue($field){
	global $values;
	global $errors;
	if($errors)
		echo $values[$field];
}

$valid = false;
global $errors;
$errors = false;
if($_REQUEST['submit']){
	global $values;
	global $fields;
	$valid = true;
	
	$id = $_REQUEST['post_id'];

	$post = get_post($id); setup_postdata($post); 
		
	$_REQUEST['link'] = get_permalink();
	$_REQUEST['title'] = the_title('','',false);
	
	$fields = array('yourname'=>true,'youremail'=>true,'friendsemail'=>true,'note'=>false,'link'=>true,'title'=>true);
	$values = array();
	foreach($fields as $field=>$v){
		$values[$field] = stripslashes($_REQUEST[$field]);
		if(!$values[$field] && $v){ $valid = false; }
	}
		
	if($valid){
		$swift = new Swift(new Swift_Connection_Sendmail());
		$msg = "Your friend {$values['yourname']} has recommended an article in the Wesleyan Argus to you.\n\n";
		$msg .= "To view the article entitled {$values['title']}, "
				. "click or navigate to {$values['link']}\n\n";
		$msg .=	"Enjoy,\nThe Wesleyan Argus";
		
		$msg = new Swift_Message("{$values['yourname']} has recommended an article",$msg);			
		if ($swift->send($msg, $values['friendsemail'], 'admin@wesleyanargus.com'))
			echo '<p>The article has been recommended to your friend. <a href="javascript:window.close()">Close this window.</a></p>';
		else
			echo '<p>Your message failed to send. Please make sure you provided valid email addresses.</p>';
	}else $errors = true;
}

if(!$valid){
?>

<form method="post">
	<? showError('yourname','Your Name'); ?>
	<label for="yourname">Your Name</label><input type="text" name="yourname" id="yourname" />
	
	<? showError('youremail','Your Email Address'); ?>
	<label for="youremail">Your Email Address</label><input type="text" name="youremail" id="youremail" />
	<? showError('friendsemail','Friend\' Email Address'); ?>
	<label for="friendsemail">Friend's Email Address</label><input type="text" name="friendsemail" id="friendsemail" />
	<label for="note">Personalized Note</label><textarea name="note" id="note"></textarea>
	
	<input type="submit" name="submit" value="Send Email" />
</form>
<? } ?>