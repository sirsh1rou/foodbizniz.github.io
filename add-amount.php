<?php include('partials-front/menu.php');?>
<?php

    if (isset($_SESSION['table_num'])) {
        $table_num = $_SESSION['table_num'];
        header('location:'.SITEURL.'cart.php?table_num='.$table_num); // Pass table_num as a query parameter
    }

    //1. get the id of admin to be deleted
    $id = $_GET['id'];
    
    //2. create sql query to delete admin
    $sql = "ALTER TABLE tbl_order WHERE id=$id AN"; 
    
    //execute the query
    $res = mysqli_query($conn, $sql);
    
    //check whether the query executed successfully or not
    if($res==true)
    {
        //query executed successfully and admin deleted
	//echo "Admin Deleted";
	//create session variable to display message
	$_SESSION['delete'] = "<div class='success'></div>";
    
    //redirect to manage admin page
    $table_num = $_SESSION['table_num'];
    header('location:'.SITEURL.'cart.php?table_num='.$table_num); // Pass table_num as a query parameter

    }
    else
    {
        //failed to delete admin
	//echo "Failed to Delete Admin";
	
	$_SESSION['delete'] = "<div class='error'>Failed to Add Amount.</div>";
	header('location:index.php');
    }
    
    //3. redirect to manage admin page  with message

?>