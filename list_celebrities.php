<!DOCTYPE html>
<html>
<head>
	<title>TBP Celebrities</title>
	<meta name="robots" content="noindex" />
</head>
<body>
<h1>Twitter Basic Plus</h1>

<?php

include 'auth.php';

$query = "SELECT username FROM users JOIN celebrities USING (user_id);";
$result = mysqli_query($con, $query)
	or die('Query failed: ' . mysqli_error($con));
print '<h2>Celebrities</h2>';
print '<ul>';
while ($tuple = mysqli_fetch_row($result)){
        print "<li>$tuple[0]</li>";
}
print '</ul>';
mysqli_free_result($result);
mysqli_close($con);

?>

</body>
</html>
