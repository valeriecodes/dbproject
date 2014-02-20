<?php session_start();
?>
<html>
<head>
        <title>Message Sent</title>
        <meta name="robots" content="noindex" />
</head>
<h1>Twitter Basic Plus</h1>

<?php

include 'auth.php';

$username = $_SESSION['user'];
$recipient = $_REQUEST['recipient'];
$content = $_REQUEST['text'];
$checkquery = "SELECT user_id FROM users WHERE username = '$recipient';";
$checkresult = mysqli_query($con, $checkquery)
  	or die('Query failed: ' . mysqli_error($con));
$userquery = "SELECT user_id FROM users WHERE username = '$username';";
$userresult =  mysqli_query($con, $userquery)
        or die('Query failed: ' . mysqli_error($con));
if (mysqli_num_rows($checkresult) == 0){
        print "Sorry, we couldn't find a user called <strong>$recipient</strong>.<br>";
}
else {
	$tuple = mysqli_fetch_row($userresult);
	$sender_id = $tuple[0];
	$tuple = mysqli_fetch_row($checkresult);
	$recipient_id = $tuple[0];
	$sendquery = "INSERT INTO privateMessage (sender, recipient, content) VALUES ('$sender_id', '$recipient_id', '$content');";
	$send = mysqli_query($con, $sendquery)
	        or die('Query failed: ' . mysqli_error($con));
	print '<h2>Message sent!</h2>';
}
mysqli_free_result($userresult);
mysqli_free_result($checkresult);
include 'main.php';
include 'footer.html';

?>
</body>
</html>
