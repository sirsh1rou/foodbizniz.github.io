<?php
    //include constants page
    include('../config/constants.php');
    
    //echo "Delete Food Page";
    
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //process to delete
	//echo "Process to delete";
	
	//1. get id and image name
	$id = $_GET['id'];
	$image_name = $_GET['image_name'];
	
	//2. remove the image if available
	//check if image is available or not and delete only if available
	if($image_name != "")
	{
	    //it has image and need to remove from folder
	    //get the image path
	    $path = "../images/food/".$image_name;
	    
	    //remove image file from folder
	    $remove = unlink($path);
	    
	    //check whether image is successfully removed or not
	    if($remove==false)
	    {
	        //failed to remove image
		$_SESSION['upload'] = "<div class='error'>Failed to Remove Image File.</div>";
		//redirect to manage food page
		header("location:".SITEURL.'admin/manage-food.php');
		//stop process
		die();
	   }
	    
	}
	
	//3. delete food from db
	$sql = "DELETE FROM tbl_food WHERE id=$id";
	//execute the query
	$res = mysqli_query($conn, $sql);
	
	//check whether query executed or not and set the session message
	//4. redirect to manage food with session message
	if($res==true)
	{
	    //food deleted
	    $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
	    header("location:".SITEURL.'admin/manage-food.php');
	}
	else
	{
	    //failed to delete food
	    $_SESSION['delete'] = "<div class='error'>Failed to Delete Food.</div>";
	    header("location:".SITEURL.'admin/manage-food.php');
	}
	
	
	
    }
    else
    {
        //redirect to manage food page
	//echo "redirect";
	$_SESSION['unauthorize'] = "<div class='error'>Unathorized Access.</div>";
	header("location:".SITEURL.'admin/manage-food.php');
    }

?>