<?php session_start();
$_SESSION['user']= $_REQUEST['username'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>User Registration</title>
	<meta name="robots" content="noindex" />
</head>
<body>
<h1>Twitter Basic Plus</h1>

<?php

include 'auth.php';

$username = $_SESSION['user'];

$checkquery = "SELECT username FROM users WHERE username = '$username';";
$checkresult = mysqli_query($con, $checkquery)
	or die('Query failed: ' . mysqli_error($con));
if (mysqli_num_rows($checkresult) == 0 and preg_match("/^[a-zA-Z0-9]+$/", $username)) {
	$insert = "INSERT INTO users (username, joinDate) VALUES ('$username', CURRENT_TIMESTAMP);";
	$insertuser = mysqli_query($con, $insert)
		or die('Query failed: ' . mysqli_error($con));
	print "Success! You are now <strong>$username</strong>.";
	print "<form method=get action='tweet.php'><input type='text' name='text'><br><input type='submit' value='Tweet!'><br>";
	print "<form method=get action='follow.php'><input type='text' name='followee'><br><input type='submit' value='Follow'><br>";
}
else {
	print "The username <strong>$username</strong> is already in use or invalid (only letters and numbers allowed). <a href='final.html'>Try again</a>?<br>";
}
mysqli_free_result($checkresult);
mysqli_close($con);

include 'footer.html';

?>
