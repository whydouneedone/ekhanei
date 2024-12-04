<?php
session_start();
include 'config.php';  // Include database connection

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    echo "Access denied.";
    exit;
}

// Admin dashboard content
echo "Welcome to the Admin Dashboard!";
?>
