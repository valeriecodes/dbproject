<!DOCTYPE html>
<html>
<head>
	<title>Top Tweeters</title>
	<meta name="robots" content="noindex" />
</head>
<body>
<h1>Twitter Basic Plus</h1>

<?php

include 'auth.php';

$query = "SELECT username FROM users JOIN (SELECT user_id FROM tweets GROUP BY user_id ORDER BY COUNT(*) DESC LIMIT 10) a USING (user_id);";
$result = mysqli_query($con, $query)
	or die('Query failed: ' . mysqli_error($con));
print "<h2>Top 10 users by tweet count</h2>";
print "<ul>";
while ($tuple = mysqli_fetch_row($result)){
    print "<li>$tuple[0]</li>";
}
print "</ul>";
mysqli_free_result($result);
mysqli_close($con);

?>

</body>
</html>
