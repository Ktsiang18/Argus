<?
require_once('../../../../wp-load.php');
require_once(ABSPATH.'wp-content/themes/argus/pages/swift/Swift.php');
require_once(ABSPATH.'wp-content/themes/argus/pages/swift/Swift/Connection/Sendmail.php');

$db = new PDO('mysql:host=localhost;dbname=argus', 'vernon', 'tomcat');
$hash = $_GET['code'];

$query = 'SELECT * FROM wp_arg_submissions WHERE hash = :hash';
$query2 = 'UPDATE `wp_arg_submissions` SET `confirmed` = "1" WHERE `hash` = :hash';

$s = $db->prepare($query);
$s->bindValue(':hash',$hash);
$s->execute();
$rs = $s->fetch();

if($rs && !$rs['confirmed']){
	$s = $db->prepare($query2);
	$s->bindValue(':hash',$hash);
	$s->execute();
	
	$msg = <<<END
Note: The email address of this person is the ONLY verified piece of information. Cross-reference accordingly.\n\n
Type: {$rs['type']}\n
Author: {$rs['fullname']}\n
Class: {$rs['classyear']}\n
Verified Email: {$rs['email']}\n
Phone: {$rs['phone']}\n
Title: {$rs['title']}\n
Text: {$rs['text']}
END;
	
	$swift = new Swift(new Swift_Connection_Sendmail());
	$msg = new Swift_Message('Verified Argus Submission',$msg);		
	$swift->send($msg, 'argus@wesleyan.edu', 'admin@wesleyanargus.com');
	echo <<<END
<h1>Submission Confirmed</h1>
<p>Your submission has been confirmed and sent to the editorial board. We appreciate your participation. You may be contacted prior to publication. If your submission was not from a Wesleyan email address, you should expect a phone call to verify that you wrote the submission.</p>
END;
}
?>