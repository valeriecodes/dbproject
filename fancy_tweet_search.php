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
if (preg_match("/^\s*$/", $term)) {
	print 'Looks like your search term was empty. <a href="tbp.html">Try again</a>?';
}
else {
	$query = "SELECT content, username, time FROM tweets JOIN users USING (user_id) WHERE content LIKE '%$term%';";
	$result = mysqli_query($con, $query)
		or die('Query failed: ' . mysqli_error($con));
	print '<h2>Tweets matching your search:</h2>';
	print '<ul>';
	if ($tuple = mysqli_fetch_row($result)){
		print '<ul>';
    		print "<li>$tuple[0]<br>";
    		print "<sup>by <strong>$tuple[1]</strong> on $tuple[2]</sup></li>";
		while ($tuple = mysqli_fetch_row($result)){
			print "<li>$tuple[0]<br>";
			print "<sup>by <strong>$tuple[1]</strong> on $tuple[2]</sup></li>";
		}
		print '</ul>';
	}
	else {
		print 'We could not find any tweets matching your search. <a href="tbp.html">Try again?</a>';
	}
	mysqli_free_result($result);
}
mysqli_close($con);

?>

</body>
</html>
