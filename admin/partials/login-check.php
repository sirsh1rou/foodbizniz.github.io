<?php
    
    //authorization - access control
    //check whether user is login or not
    if(!isset($_SESSION['user'])) //if user session is not set
    {
        //user is not logged in
	//redirect to login page with message
	$_SESSION['no-login-message'] = "<div class='error tex-center'>Please Log In to access Admin Panel.</div>";
        //redirect to login page
	header('location:'.SITEURL.'admin/login.php');
    }

?>