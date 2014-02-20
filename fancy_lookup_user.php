<?php
session_start();
$username = $_SESSION['user'];

include "lookup_user.php?user=$username";
include 'footer.html';
?>
