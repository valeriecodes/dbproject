<?php
session_start();
?>
<html>
<head>
        <title>Follow</title>
        <meta name="robots" content="noindex" />
</head>
<body>
<h1>Twitter Basic Plus</h1>

<?php

include 'auth.php';

$follower = $_SESSION['user'];
$followee = $_REQUEST['followee'];

$getidquery = "SELECT user_id FROM users WHERE username='$follower';";
$result = mysqli_query($con, $getidquery)
        or die('Query failed: ' . mysqli_error($con));
$follower_id = mysqli_fetch_row($result);
$getidquery = "SELECT user_id FROM users WHERE username='$followee';";
$result = mysqli_query($con, $getidquery)
        or die('Query failed: ' . mysqli_error($con));
$followee_id = mysqli_fetch_row($result);
if ($followee_id and $follower_id){
	$checkquery = "SELECT * FROM follows WHERE follower = $follower_id[0] AND followee = $followee_id[0];";
	$checkresult = mysqli_query($con, $checkquery)
        	or die('Query failed: ' . mysqli_error($con));
	if (mysqli_num_rows($checkresult) == 0){
		$insertquery = "INSERT INTO follows(followee, follower) VALUES ($followee_id[0], $follower_id[0]);";
		$insert = mysqli_query($con, $insertquery)
	        	or die('Query failed: ' . mysqli_error($con));
		print "<h3>Success! You now follow $followee.</h3>";
	}
	else {
		print "You already follow $followee.<br>";
	}
	mysqli_free_result($checkresult);
}
else {
	print "Oops! Either $follower or $followee is an invalid username.<br>";
}
include 'main.php';
include 'footer.html';
mysqli_free_result($result);
?>
