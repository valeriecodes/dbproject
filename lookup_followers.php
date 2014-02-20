<!DOCTYPE html>
<html>
<head>
	<title>User Lookup</title>
	<meta name="robots" content="noindex" />
</head>
<body>
<h1>Twitter Basic Plus</h1>

<?php

include 'auth.php';

$term = $_REQUEST['user'];
$find_user = "SELECT username FROM users WHERE username = '$term';";
$preresult = mysqli_query($con, $find_user)
		or die('Query failed: ' . mysqli_error($con));
if (mysqli_fetch_row($preresult)){
	$query = "SELECT username FROM follows JOIN users ON users.user_id = follows.follower WHERE followee = (SELECT user_id FROM users WHERE username = '$term');";
	$result = mysqli_query($con, $query)
		or die('Query failed: ' . mysqli_error($con));
	print "<h2>$term's followers:</h2>";
	if ($tuple = mysqli_fetch_row($result)){
		print '<ul>';
		print "<li>$tuple[0]</li>";
		while ($tuple = mysqli_fetch_row($result)){
			print "<li>$tuple[0]</li>";
		}
		print '</ul>';
	}
	else {
		print "$term has no followers.";
	}
	mysqli_free_result($result);
}
else {
	print "We couldn't find the user $term. <a href='tbp.html'>Try again</a>?";
}
mysqli_free_result($preresult);
mysqli_close($con);

?>

</body>
</html>
