<?php
session_start();
session_destroy();
header('Location: /Plateforme-de-Cours-en-Ligne-Youdemy/public/sign-in.php');
exit;
