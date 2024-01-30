<?php include('partials/menu.php'); ?>

<?php
    //check whether id is set or not
    if(isset($_GET['id']))
    {
       //get all the details
       $id = $_GET['id'];
       
       //sql query to get selected food
       $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
       //execute the query
       $res2 = mysqli_query($conn, $sql2);
       
       //get the value based on query executed
       $row2 = mysqli_fetch_assoc($res2);
       
       //get the individual value of selected food
       $title = $row2['title'];
       $description = $row2['description'];
       $price = $row2['price'];
       $current_image = $row2['image_name'];
       $current_category = $row2['category_id'];
       $active = $row2['active'];
       
    }
    else
    {
       //redirect to manage food
       header("location:".SITEURL.'admin/manage-food.php');
    }
?>


<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
	<br><br>
	
	<form action="" method="POST" enctype="multipart/form-data">
	
	<table class="tbl-30">
	
	   <tr>
	       <td>Title: </td>
	       <td>
		   <input type="text" name="title" value="<?php echo $title; ?>">
	       </td>
	   </tr>
	   
	   <tr>
	       <td>Description: </td>
	       <td>
		   <textarea name="description" cols="30" rows="5" ><?php echo $description; ?></textarea>
	       </td>
           </tr>
	   
	   <tr>
	       <td>Price: </td>
	       <td>
	           <input type="number" name="price" value="<?php echo $price; ?>">
	       </td>
           </tr>
	   
           <tr>
	       <td>Current Image: </td>
	       <td>
	           <?php
	               if($current_image == "")
	               {
		           //image not available
		           echo "<div class='error'>Image Not Available.</div>";
		       }
		       else
		       {
			   //image available
			   ?>
			   <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
			   <?php
		       }
	           ?>
	       </td>
           </tr>
	   
           <tr>
	       <td>Select New Image: </td>
	       <td>
	           <input type="file" name="image">
	       </td>
           </tr>
	   
           <tr>
	       <td>Category: </td>
	       <td>
	           <select name="category">
		       
		       <?php 
		           //query to get active from db
		           $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
			   //execute the query
			   $res = mysqli_query($conn, $sql);
			   //count the rows
			   $count = mysqli_num_rows($res);
			   
			   //check whether categories available or not
			   if($count>0)
			   {
			       //category available
			       while($row=mysqli_fetch_assoc($res))
			       {
			           $category_title = $row['title'];
			           $category_id = $row['id'];
				   
				   //echo "<option value='$category_id'>$category_title</option>";
				   ?>
				   <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
				   <?php
			       }
			   }
			   else
			   {
			       // category not available
			       echo "<option value='0'>Category Not available</option>";
			   }
			   
		       ?>
		       
		   </select>
	       </td>
           </tr>
	   
	   
	   <tr>
	       <td>Display Food: </td>
	       <td>
	           <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
		   <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No
	       </td>
           </tr>
	   
	   <tr>
	       <td>
	           <input type="hidden" name="id" value="<?php echo $id; ?>">
	           <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
	           
		   <input type="submit" name="submit" value="Update Food" class="btn-secondary">
	       </td>
	   </tr>
	
	</table>
	
	</form>
	
	<?php
	
	    if(isset($_POST['submit']))
	    {
	        //echo "button clicked";
		
		//1.get all details from the from
		$id = $_POST['id'];
		$title = $_POST['title'];
		$description = $_POST['description'];
		$price = $_POST['price'];
		$current_image = $_POST['current_image'];
		$category = $_POST['category'];
		$active = $_POST['active'];
		
		//2. upload the image if selected
		
		//check whether upload button is clicked or not
		if(isset($_FILES['image']['name']))
		{
		    //upload button clicked
		    $image_name = $_FILES['image']['name']; //new image name
		    
		    //check whether file is available or not
		    if($image_name != "")
		    {
		        //image available
			//A. uploading new image
			
			//rename the image
			$ext = end(explode('.', $image_name)); //gets the xetension of the image
			
			$image_name = "Food-Name-".rand(0000, 9999).'.'.$ext;
			
			//get the source path and destination path
			$src_path = $_FILES['image']['tmp_name'];
			$dest_path = "../images/food/".$image_name;
			
			//upload the image
			$upload = move_uploaded_file($src_path, $dest_path);
			
			//check whether image is uploaded or not
			if($upload==false)
			{
			   //failed to upload
			   $_SESSION['upload'] = "<div class='error'>Failed to Upload New Image. </div>";
			   //redirect to manage food page
			   header("location:".SITEURL.'admin/manage-food.php');
			   //stop the process
			   die();
			}
			//3.remove the image if new image is uploaded and current image exists
			//B. Remove current image if available
			if($current_image != "")
			{
			    //current image is available
			    //remove the image
			    $remove_path = "../images/food/".$current_image;
			    
			    $remove = unlink($remove_path);
			    
			    //check whether the image is removed or not
			    if($remove==false)
			    {
			        //failed to remove current image
					$_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image. </div>";
					//redirect to manage food page
					header("location:".SITEURL.'admin/manage-food.php');
					//stop the process
					die();
			    }
			}
		}
		else
		{
			$image_name = $current_image; // Default Image when image is not selected
		}	
	}
	else
	{
		$image_name = $current_image; // Default image when button is not clicked
	}
		
		
		//4. update the food in db
		$sql3 = "UPDATE tbl_food SET 
			title='$title',
			description='$description',
			price=$price,
			image_name = '$image_name',
			category_id='$category',
			active='$active'
			WHERE id=$id
		";
		
		//execute the query
		$res3 = mysqli_query($conn, $sql3);
		
		//check whether query is executed or not						
		if($res3==TRUE)
		{
		    //query executed and food updated
		    $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
		    header("location:".SITEURL.'admin/manage-food.php');
		}
		else
		{
		    //failed to update food
		    $_SESSION['update'] = "<div class='error'>Failed To Update Food.</div>";
		    header("location:".SITEURL.'admin/manage-food.php');
		}
		
		
	    }
	
	?>
	
    </div>
</div>

<?php include('partials/footer.php'); ?>