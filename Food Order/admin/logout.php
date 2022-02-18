<?php 
    // Include constants
    include('../config/constants.php');

    // Destroy the session 
    session_destroy(); // Unsets $_SESSION['user]
    
    //Redirect to the login page
    header('location:' . SITEURL . 'admin/login.php');
?>