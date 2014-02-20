<?php session_start();
?>

<html>
<head>
        <title>Retweet</title>
        <meta name="robots" content="noindex" />
</head>
<body>
<h1>Twitter Basic Plus</h1>

<?php

include 'auth.php';
$username = $_SESSION['user'];
$tweet_id = $_REQUEST['tweet_id'];
$checkquery = "SELECT user_id FROM users WHERE username = '$username';";
$checkresult = mysqli_query($con, $checkquery)
        or die('Query failed: ' . mysqli_error($con));
$tuple = mysqli_fetch_row($checkresult);
$user_id = $tuple[0];
$checkquery = "SELECT tweet_id, user_id FROM tweets WHERE tweet_id = $tweet_id;";
$checkresult = mysqli_query($con, $checkquery)
  	or die('Query failed: ' . mysqli_error($con));
$tuple = mysqli_fetch_row($checkresult);
$tweetauthor = $tuple[1];
if (mysqli_num_rows($checkresult) == 0){
	print "Oops, looks like the tweet you're trying to retweet doesn't exist.<br>";
}
elseif ($user_id == $tweetauthor){
	print "You can't retweet your own tweet.<br>";
}
else {
	$checkquery = "SELECT * FROM retweets WHERE tweet_id = $tweet_id AND user_id = $user_id;";
	$checkresult = mysqli_query($con, $checkquery)
        	or die('Query failed: ' . mysqli_error($con));
	if (mysqli_num_rows($checkresult) >= 1){
		print 'You already retweeted that tweet.<br>';
	}
	else {
		$retweetquery = "INSERT INTO retweets (tweet_id, user_id) VALUES ($tweet_id, $user_id);";
		$retweet =  mysqli_query($con, $retweetquery)
	                or die('Query failed: ' . mysqli_error($con));
		print '<h2>Retweeted sucessfully!</h2>';
		print "<a href = 'tweets_by_user.php?user=$username'>Your tweets</a><br>";
	}
}
include 'main.php';
include 'footer.html';
?>
</body>
</html>
