<!DOCTYPE html>
<html>
<head>
	<title>Tweet Search</title>
	<meta name="robots" content="noindex" />
</head>
<body>
<h1>Twitter Basic Plus</h1>

<?php

include 'auth.php';

$term = $_REQUEST['term'];
$type = $_REQUEST['type'];

if (preg_match("/^\s*$/", $term)) {
	print 'Looks like your search term was empty. <br>';
}
else {
	if ($type == 'Tweets'){
		$query = "SELECT content, username, time, tweet_id FROM tweets JOIN users USING (user_id) WHERE content LIKE '%$term%';";
		$result = mysqli_query($con, $query)
			or die('Query failed: ' . mysqli_error($con));
		print '<h2>Tweets matching your search:</h2>';
		print '<ul>';
		if (mysqli_num_rows($result) > 0){
			while ($tuple = mysqli_fetch_row($result)){
				print "<li>$tuple[0]<br>";
				print "<sup>by <strong>$tuple[1]</strong> on $tuple[2]</sup><br>";
				print "<form style='display: inline-block;' method=get action='favorite.php'><input type='hidden' name='tweet_id' value='$tuple[3]'><input type='submit' value='Favorite'></form>";
                		print "<form style='display: inline-block;' method=get action='retweet.php'><input type='hidden' name='tweet_id' value='$tuple[3]'><input type='submit' value='Retweet'></form>";
                		print "<form style='display: inline-block;' method=get action='follow.php'><input type='hidden' name='followee' value='$tuple[1]'><input type='submit' value='Follow $tuple[1]'></form>";
				print '</li>';
			}
		print '</ul>';
		}
		else {
			print 'We could not find any tweets matching your search<br>';
		}
	}
	else{
		$query = "SELECT username FROM users WHERE username LIKE '%$term%';";
		$result = mysqli_query($con, $query)
                        or die('Query failed: ' . mysqli_error($con));
                print '<h2>Users matching your search:</h2>';
                print '<ul>';
                if (mysqli_num_rows($result) > 0){
                        while ($tuple = mysqli_fetch_row($result)){
                                print "<li>$tuple[0]<br>";
                		print "<form style='display: inline-block;' method=get action='follow.php'><input type='hidden' name='followee' value='$tuple[0]'><input type='submit' value='Follow $tuple[0]'></form>";
				print "</li>";
                        }
                print '</ul>';
		}
		else {
			print 'We could not find any users matching your search<br>';
		}
	}
	mysqli_free_result($result);
}
mysqli_close($con);

include 'footer.html';
?>

</body>
</html>
