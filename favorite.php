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
$checkquery = "SELECT tweet_id FROM tweets WHERE tweet_id = $tweet_id;";
$checkresult = mysqli_query($con, $checkquery)
  	or die('Query failed: ' . mysqli_error($con));
if (mysqli_num_rows($checkresult) == 0){
	print "Oops, looks like the tweet you're trying to favorite doesn't exist.<br>";
}
else {
	$checkquery = "SELECT * FROM favorite WHERE tweet_id = $tweet_id AND user_id = $user_id;";
	$checkresult = mysqli_query($con, $checkquery)
        	or die('Query failed: ' . mysqli_error($con));
	if (mysqli_num_rows($checkresult) >= 1){
		print 'You already favorited that tweet.<br>';
	}
	else {
		$favoritequery = "INSERT INTO favorite (tweet_id, user_id) VALUES ($tweet_id, $user_id);";
		$favorie =  mysqli_query($con, $favoritequery)
	                or die('Query failed: ' . mysqli_error($con));
		print '<h2>Favorited sucessfully!</h2>';
	}
	print "<a href = 'lookup_user.php?user=$username'>Your profile</a><br>";
	include 'main.php';
	include 'footer.html';
}
?>

</body>
</html>
