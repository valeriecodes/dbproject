<?php

include 'auth.php';

$query = "SELECT 'users' AS table_name, count(*) AS table_size
FROM users
UNION
SELECT 'tweets' AS table_name, count(*) AS table_size
FROM tweets
UNION
SELECT 'follows' AS table_name, count(*) AS table_size
FROM follows
UNION
SELECT 'has' AS table_name, count(*) AS table_size
FROM has
UNION
SELECT 'celebrities' AS table_name, count(*) AS table_size
FROM celebrities
UNION
SELECT 'mentions' AS table_name, count(*) AS table_size
FROM mentions
UNION
SELECT 'privateMessage' AS table_name, count(*) AS table_size
FROM privateMessage
UNION
SELECT 'favorite' AS table_name, count(*) AS table_size
FROM favorite;";
$result = mysqli_query($con, $query)
	or die('Query failed: ' . mysqli_error());
print '<h2>Table: Row Count</h2>';
print '<ul>';
while ($tuple = mysqli_fetch_row($result)){
	print "<li> $tuple[0]: $tuple[1]</li>";
}
print '</ul>';

mysqli_free_result($result);
mysqli_close($con);

?>
