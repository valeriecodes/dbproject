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
$query = "SELECT username, displayName, DATE(joinDate), COUNT(*) FROM users JOIN tweets USING (user_id) WHERE username = '$term';";
$result = mysqli_query($con, $query)
	or die('Query failed: ' . mysqli_error($con));
print "<h2>All about $term:</h2>";
$tuple = mysqli_fetch_row($result);
if ($tuple[0] != NULL){
	print "<ul>";
	print "<li>Username: $tuple[0]</li>";
	print "<li>Display Name: $tuple[1]</li>";
	print "<li>Join Date: $tuple[2]</li>";
	print "<li>Tweet Count: $tuple[3]</li>";
	print "<li><a href='tweets_by_user.php?user=$term'>$term's tweets</a></li>";
	mysqli_free_result($result);
	$fav_query = "SELECT content FROM tweets JOIN favorite USING (tweet_id) WHERE favorite.user_id = (SELECT user_id FROM users WHERE username = '$term');";
	$result =  mysqli_query($con, $fav_query)
		or die('Query failed: ' . mysqli_error($con));
	print "<li>$term's favorite tweets:";
	print '<ul>';
	if ($tuple =  mysqli_fetch_row($result)){
		print "<li>$tuple[0]</li>";
		while ($tuple =  mysqli_fetch_row($result)){
			print "<li>$tuple[0]</li>";
		}
	}
	else {
		print "<li>$term has no favorite tweets :(</li>";
	}
	print "</ul></ul>";
}
else {
	print "Couldn't find user $term. <a href='tbp.html'>Try again</a>?<br>";
}
mysqli_free_result($result);
mysqli_close($con);

include 'footer.html';
?>

</body>
</html>
