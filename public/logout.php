<?php
// session_start();
use Models\Databse;
session_unset();
session_destroy();
header('Location: /Plateforme-de-Cours-en-Ligne-Youdemy/public/sign-in.php');
exit;
