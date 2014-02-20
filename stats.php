<!DOCTYPE html>
<html>
<head>
	<title>TBP Stats</title>
	<meta name="robots" content="noindex" />
</head>
<body>
<h1>Twitter Basic Plus</h1>

<?php
include 'auth.php';
$query = 'SELECT COUNT(*) FROM users;';
$result = mysqli_query($con, $query)
        or die('Query failed: ' . mysqli_error($con));
$tuple = mysqli_fetch_row($result);
print "<h2>TBP has $tuple[0] users";
$query = 'SELECT COUNT(*) FROM tweets;';
$result = mysqli_query($con, $query)
        or die('Query failed: ' . mysqli_error($con));
$tuple = mysqli_fetch_row($result);
print " who have sent $tuple[0] tweets.</h2>";
$query = "SELECT username FROM users JOIN (SELECT user_id FROM tweets GROUP BY user_id ORDER BY COUNT(*) DESC LIMIT 10) a USING (user_id);";
$result = mysqli_query($con, $query)
	or die('Query failed: ' . mysqli_error($con));
print '<h2>Top Tweeters</h2>';
print '<ul>';
while ($tuple = mysqli_fetch_row($result)){
	print "<li>$tuple[0]<br>";
	print "<form style='display: inline-block;' method=get action='follow.php'><input type='hidden' name='followee' value='$tuple[0]'><input type='submit' value='Follow $tuple[0]'></form></li>";
}
print '</ul>';

mysqli_free_result($result);
mysqli_close($con);
include 'footer.html';
?>
