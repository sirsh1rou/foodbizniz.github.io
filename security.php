<?php
if (!(isset($_SESSION['User_ID'])))
{
session_destroy();
header ("location:index.php");

}
?>