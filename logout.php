<?php
session_start();
$_SESSION['loggedIn'] = false;
header("Location: https://badger.greenriverdev.com/Sprint5/login.php?msg= Logged out");