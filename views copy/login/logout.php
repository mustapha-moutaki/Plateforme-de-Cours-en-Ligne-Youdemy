<?php
use App\Models\Databse;
session_unset();
session_destroy();
header("Location: http://localhost/devblog_dashboard/views/login/login.php");
exit();
?>

