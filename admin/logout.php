<?php
// File: admin/logout.php

session_start();

// Destroy all session variables
$_SESSION = array();

// Destroy Session
session_destroy();

// Redirect to public homepage
header('location: ../index.php');
exit();
?>