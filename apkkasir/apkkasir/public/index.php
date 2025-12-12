<?php
// filepath: c:\xampp\htdocs\apkkasir\public\index.php

// Autoload dependencies
require_once '../config/database.php';

// Start session
session_start();

// Load header template
include '../templates/header.php';

// Redirect to the main page (kasir)
header('Location: ../src/kasir.php');
exit();
?>