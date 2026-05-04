<?php
// logout.php — terminates the current user session and redirects to the homepage.
session_start();
session_destroy();
header("Location: index.php");
exit();
?>
