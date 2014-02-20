<!DOCTYPE html>
<html>
<head>
	<title>Private Message Count</title>
	<meta name="robots" content="noindex" />
</head>
<body>
<h1>Twitter Basic Plus</h1>

<?php

include 'auth.php';

$query = "SELECT COUNT(*) FROM privateMessage;";
$result = mysqli_query($con, $query)
	or die('Query failed: ' . mysqli_error($con));
$tuple = mysqli_fetch_row($result);
print "<h2>Private Message Count: $tuple[0]</h2>";
mysqli_free_result($result);
mysqli_close($con);

?>

</body>
</html>
