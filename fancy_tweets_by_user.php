<!DOCTYPE html>
<html>
<head>
	<title>Tweets by User</title>
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
	$query = "SELECT content, time, author, tweet_id
	FROM
	(SELECT content, time, username AS author, tweet_id FROM tweets JOIN users USING (user_id) WHERE username = '$term'
	UNION
	SELECT content, time, author, retweets.tweet_id FROM retweets JOIN (SELECT username AS author, content, time, tweet_id FROM tweets JOIN users USING (user_id)) a ON a.tweet_id = retweets.tweet_id WHERE retweets.user_id = (SELECT user_id FROM users WHERE username = '$term')) b
	ORDER BY time;";
	$result = mysqli_query($con, $query)
		or die('Query failed: ' . mysqli_error($con));
	print "<h2>Tweets by $term:</h2>";
	print "<ul>";
	if (mysqli_num_rows($result) > 0){
		while ($tuple = mysqli_fetch_row($result)){
    			print "<li>$tuple[0]<br>";
			print '<sup>';
			if ($tuple[2] != $term){
				print "Retweet of tweet by <strong>$tuple[2]</strong>";
			}
			print " at $tuple[1]</sup></li>";
		}
		print '</ul>';
	}
	else {
		print "$term hasn't tweeted yet";
	}
	mysqli_free_result($result);
}
else {
	print "We can't find user $term. <a href='tbp.html'>Try again</a>?";
}
mysqli_free_result($preresult);
mysqli_close($con);

?>

</body>
</html>
