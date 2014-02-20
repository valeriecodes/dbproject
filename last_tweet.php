<!DOCTYPE html>
<html>
<head>
	<title>Most Recent Tweets</title>
	<meta name="robots" content="noindex" />
</head>
<body>
<h1>Twitter Basic Plus</h1>

<?php

include 'auth.php';
$query = 'SELECT content, time FROM tweets WHERE time = (SELECT MAX(time) FROM tweets);';
$result = mysqli_query($con, $query)
	or die('Query failed: ' . mysqli_error($con));
print '<h2>Most Recent Tweet(s)</h2>';
while ($tuple = mysqli_fetch_row($result)){
	print "$tuple[0]";
	print '<br>';
	print "<sup>at $tuple[1]</sup>";
	print '<br><br>';
}
?>
