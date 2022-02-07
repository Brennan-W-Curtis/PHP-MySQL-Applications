<?php 
    // Authorization - Access Control
    // Check whether the user is logged in
    if (!isset($_SESSION['user'])) { 
        // Login error message
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access admin panel.</div>";
        // Redirect to login page
        header('location:' . SITEURL . 'admin/login.php');
    }
