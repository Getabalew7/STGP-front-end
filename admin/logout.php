<?php
session_start();
session_destroy();
header("Location: index.html"); // Redirect to the login page after session destruction
exit();
?>
