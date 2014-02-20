<?php
session_start();
?>

<html>
<head>
        <title>Messages</title>
        <meta name="robots" content="noindex" />
</head>
<body>
<h1>Twitter Basic Plus</h1>

<?php

include 'auth.php';

$username = $_SESSION['user'];
print '<h2>Private Messages</h2>';
if ($username){
	print "<form method=get action='send.php'>Recipient's username: <input type='type' name='recipient'><br>Message: <input type='text' name='text'><br><input type='submit' value='Send'></form>";
	$query = "SELECT content, username AS sender FROM privateMessage JOIN users ON privateMessage.sender = users.user_id WHERE recipient = (SELECT user_id FROM users WHERE username= '$username');";
	$result = mysqli_query($con, $query)
	  	or die('Query failed: ' . mysqli_error($con));
	if (mysqli_num_rows($result) == 0){
		print 'You have no messages.<br>';
	}
	else {
		if (mysqli_num_rows($result) > 0){
		print '<ul>';
		while($tuple = mysqli_fetch_row($result)){
			print "<li>$tuple[0]<br>";
			print "<sup>from <strong>$tuple[1]</strong></sup></li>";
		}
		print '</ul>';
		}
	}
	mysqli_free_result($result);
}
else {
	print 'Oops, something went wrong. <a href="final.html">Try logging in again.</a>';
}
include 'footer.html';
mysqli_close($con);
?>
</body>
</html>
