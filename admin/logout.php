<?php
    //include constants.php for siteurl
    include('../config/constants.php');
    
    //1. destroy the session
    session_destroy(); //unsets $_SESSION[''user]
    
    //2. redirect to login page
    header('location:'.SITEURL.'index.php');
    
?>