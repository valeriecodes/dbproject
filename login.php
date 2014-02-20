<?php session_start();
if ($_REQUEST['username'] != ''){
	$_SESSION['user'] = ($_REQUEST['username']);
}
?>
<html>
<head>
        <title>User Login</title>
        <meta name="robots" content="noindex" />
</head>
<body>
<h1>Twitter Basic Plus</h1>

<?php

include 'auth.php';

$username = $_SESSION['user'];

$checkquery = "SELECT username FROM users WHERE username = '$username';";
$checkresult = mysqli_query($con, $checkquery)
  	or die('Query failed: ' . mysqli_error($con));
if (!isset($_SESSION['user'])) {
	print 'You are not logged in. Please <a href="final.html">log in or register.';
}
elseif (mysqli_num_rows($checkresult) == 0){
        print "Sorry, we couldn't find a user called <strong>$username</strong>. <a href='register.php?username=$username'>Register</a> or <a href='final.html'>try again</a>.";
}
else {
	print "<h3>Welcome <strong>$username</strong>. You're logged in.</h3>";
	print '<a href ="logout.php">Logout</a><br>';
	include 'main.php';
}

?>
</body>
</html>
