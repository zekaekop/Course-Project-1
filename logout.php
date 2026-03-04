<?php

session_start(); // apperantly we need to start it, for this logout to work

session_unset();
session_destroy();

header("Location: login.php");
exit();

?>