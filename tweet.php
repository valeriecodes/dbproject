<?php session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sending tweet..</title>
	<meta name="robots" content="noindex" />
</head>
<body>
<h1>Twitter Basic Plus</h1>

<?php

include 'auth.php';

$username = $_SESSION['user'];
$text = $_REQUEST['text'];

$finduserid = "SELECT user_id FROM users WHERE username='$username';";
$request = mysqli_query($con, $finduserid)
	or die('Query failed: ' . mysqli_error($con));
if (mysqli_num_rows($request) == 1){
	$tuple = mysqli_fetch_row($request);
	$insert_statement = "INSERT INTO tweets (content, user_id, time) VALUES ('$text', '$tuple[0]', CURRENT_TIMESTAMP);";
	$insert_request = mysqli_query($con, $insert_statement)
        	or die('Query failed: ' . mysqli_error($con));
	print '<h3>Tweet sent!</h3>';
	print "<a href='tweets_by_user.php?user=$username'>Your tweets</a>.<br><br>";
	mysqli_free_result($request);
	include 'main.php';
}
else {
	print 'Sorry, we could not find your user_id. <a href="final.html">Try again?</a>';
	mysqli_free_result($request);
	mysqli_close($con);
}

include 'footer.html';
?>
</body>
</html>
