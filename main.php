<?php
$username = $_SESSION['user'];

print '<a href="stats.php">TBP stats</a><br>';
print "<a href='messages.php'>Check private messages</a><br><br>";
print 'Search TBP:<br>';
print "<form method=get action='search.php'><input type='text' name='term'><input type='submit' name='type' value='Users'><input type='submit' name='type' value='Tweets'></form>";
print "<form method=get action='tweet.php'><input type='text' name='text' maxlength='140'><br><input type='submit' value='Tweet!'></form>";
print "<form method=get action='follow.php'><input type='text' name='followee'><br><input type='submit' value='Follow'></form>";
print "<h4>Your stream</h4>";
$streamquery = "SELECT content, time, username, tweet_id
FROM tweets JOIN users USING (user_id)
WHERE username ='$username' OR tweets.user_id IN
	(SELECT followee FROM follows WHERE follower =
		(SELECT user_id FROM users WHERE username ='$username'))
	OR tweet_id IN (SELECT tweet_id
		FROM retweets
		WHERE user_id IN (SELECT followee FROM follows WHERE follower =
			(SELECT user_id FROM users WHERE username = '$username'))
			OR user_id = (SELECT user_id FROM users WHERE username = '$username'))
ORDER BY time DESC LIMIT 100;";
$stream = mysqli_query($con, $streamquery)
        or die('Query failed: ' . mysqli_error($con));
if (mysqli_num_rows($stream) > 0){
	print '<ul>';
	while($tuple = mysqli_fetch_row($stream)){
		print "<li>$tuple[0]<br>";
		print "<sup>by <strong>$tuple[2]</strong> at $tuple[1]</sup><br>";
		print "<form style='display: inline-block;' method=get action='favorite.php'><input type='hidden' name='tweet_id' value='$tuple[3]'><input type='submit' value='Favorite'></form>";
		print "<form style='display: inline-block;' method=get action='retweet.php'><input type='hidden' name='tweet_id' value='$tuple[3]'><input type='submit' value='Retweet'></form></li>";
	}
	print '</ul>';
}
else {
	print 'No tweets in your stream. Use the links above to send out tweets or follow new users.<br>';
}
mysqli_close($con);
?>
