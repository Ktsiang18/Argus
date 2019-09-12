<?
require_once('../../../../wp-load.php');
require_once(ABSPATH.'wp-content/themes/argus/pages/swift/Swift.php');
require_once(ABSPATH.'wp-content/themes/argus/pages/swift/Swift/Connection/Sendmail.php');
?>
<style type="text/css">
body { margin: 1.5em; font-family: Helvetica, Arial, sans-serif; }
label { margin: 0 0 .3em; font-weight: bold; display: block; font-size: 13px; color: #444; }
input,select,textarea { margin: 0 0 1em; }
textarea { width: 30em; height: 20em; padding: .5em; }
</style>
<?
function showError($field, $name){
	global $values;
	global $errors;
	if(!$values[$field] && $errors)
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
if($_POST['submit']){
	global $values;
	$valid = true;
	
	$fields = array('fullname','classyear','email','phone','title','type','text');
	$values = array();
	foreach($fields as $field){
		$values[$field] = stripslashes($_POST[$field]);
		if(!$values[$field]){ $valid = false; }
	}
	if($valid){
		$flatFields = implode(',',$fields).',hash,confirmed';
		$flatPrepped = ':'.implode(',:',$fields).',:hash,:confirmed';
		$query = "INSERT INTO wp_arg_submissions($flatFields) VALUES($flatPrepped)";
		$db = new PDO('mysql:host=localhost;dbname=argus', 'vernon', 'tomcat');
		$stmt = $db->prepare($query);
		foreach($values as $k=>$v) $stmt->bindValue(":$k",$v);
		$hash = md5(microtime().implode(array_values($values)));
		$stmt->bindValue(':hash',$hash);
		$stmt->bindValue(':confirmed',0);
		$stmt->execute();

		$swift = new Swift(new Swift_Connection_Sendmail());
		$msg = "At " . date("g:i A") . " on " . date("M j, Y") . ", the following submission was made on the Wesleyan Argus website. This email address was entered as belonging to the author. Please review the content below. If you are the author of the piece, you MUST confirm this before it will be sent to the editorial board. To confirm, simply go to http://www.wesleyanargus.com/confirm/".$hash." and be sure you receive a message indicating successful confirmation. If you experience difficulties with this process, please reply to this email and explain the problem in detail.\n\nIf you did not write this piece, simply ignore this message and no action will be taken.\n\n-------------------------------\n\n";
		$msg .= $values['title'] .' by '.$values['fullname']."\n";
		$msg .= $values['text'];
		$msg = new Swift_Message('Argus Submission Confirmation',$msg);			
		if ($swift->send($msg, $values['email'], 'admin@wesleyanargus.com')) echo <<<END
<p>Thank you for submitting. In order for your submission to be sent to the editorial board, you must confirm that you own the email address you supplied. A message has been sent to your email address containing instructions and a link to confirm this. If you do not receive this email, please use the Site Comments link to report the problem to the site administrator.</p>
END;
		else echo "<p>Your submission failed. Please make sure you provided a valid email address.</p>";
	}else $errors = true;
}

if(!$valid){ ?>
<form method="POST">
	<? showError('fullname','Full Name'); ?>
	<label for="fullname">Full Name</label><input type="text" name="fullname" id="fullname" value="<? prevValue('fullname'); ?>" /><br />
	
	<? showError('classyear','Class Year or Title'); ?>
	<label for="classyear">Class Year or Title</label><input type="text" name="classyear" id="classyear" value="<? prevValue('classyear'); ?>" /><br />
	
	<? showError('email','Email'); ?>
	<label for="email">Email</label><input type="text" name="email" id="email" value="<? prevValue('email'); ?>" /><br />
	
	<? showError('phone','Phone'); ?>
	<label for="phone">Phone</label><input type="text" name="phone" id="phone" value="<? prevValue('phone'); ?>" /><br />
	
	<? showError('title','Submission Title'); ?>
	<label for="title">Submission Title</label><input type="text" name="title" id="title" value="<? prevValue('title'); ?>" /><br />
	
	<? showError('type','Submission Type'); ?>
	<label for="type">Submission Type</label>
	<select name="type" id="type">
		<option value="wespeak">Wespeak</option>
		<option value="letter">Letter to the Editor</option>
		<option value="announcement">Community Announcement</option>
	</select><br />
	
	<? showError('text','Submission Text'); ?>
	<label for="text">Your Submission</label>
	<textarea name="text" id="text"><? prevValue('text'); ?></textarea><br />
	
	<input type="submit" name="submit" value="Submit" />
</form>
<? } ?>