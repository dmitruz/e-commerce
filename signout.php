
<?php
session_start();
session_unset();
session_destroy();

// Redirect to the homepage after signing out
header("Location: index.php");
exit();
?>