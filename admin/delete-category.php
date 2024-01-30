<?php 
    //include constants file
    include('../config/constants.php');
    
    //echo "Delete Page";
    //check whether the id and image_name value is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
         //get the value and delete
	 //echo "Get Value and Delete";
	 $id = $_GET['id'];
	 $image_name = $_GET['image_name'];
	 
	 //remove the physical image file if available
	 if($image_name != "")
	 {
	      //image is available, so remove it
	      $path = "../images/category/".$image_name;
	      //remove the image
	      $remove = unlink($path);
	      
	      //if fail to reove image then add error message and stop process
	      if($remove==false)
	      {
	           //set the session message
		   $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image.</div>";
		   //redirect to manage category page
		   header("location:".SITEURL.'admin/manage-category.php');
		   //stop process
		   die();
	      }
	 }
	 
	 //delete data from db
	 //sql query delete data from db
	 $sql = "DELETE FROM tbl_category WHERE id=$id";
	 
	 //execute the qquery
	 $res = mysqli_query($conn, $sql);
	 
	 //check whether data is deleted from db or not
	 if($res==true)
	 {
	     //set success message and redirect
	     $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully.</div>";
	     //redirect to manage category
	     header("location:".SITEURL.'admin/manage-category.php');
	 }
	 else
	 {
	     //set fail message and redirect
	     $_SESSION['delete'] = "<div class='error'>Failed to Delete Category.</div>";
	     //redirect to manage category
	     header("location:".SITEURL.'admin/manage-category.php');
	 }
	 

	  
    }
    else
    {
         //redirect to manage category page
	 header("location:".SITEURL.'admin/manage-category.php');
    }
?>