<?php

session_start();

$_SESSION = [];

session_destroy();

header("Location: /escuelas/login.php");
exit;