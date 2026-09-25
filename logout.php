<?php
session_start();
// Saare sessions khatam karna
session_unset();
session_destroy();

// Logout ke baad wapas home page par bhej dena
header("Location: index.php");
exit();
?>