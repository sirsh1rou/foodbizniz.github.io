<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
	
	<br><br>
	
	<?php 	    
	    if(isset($_SESSION['upload']))
	    {
		echo $_SESSION['upload'];
		unset($_SESSION['upload']);
	    }
	?>
	
	<form action="" method="POST" enctype="multipart/form-data">

	    <table class="tbl-30">
	        
		<tr>
		    <td>Title: </td>
		    <td>
		        <input type="text" name="title" placeholder="Title Of The Food">
		    </td>
	        </tr>
		
	        <tr>
		    <td>Description: </td>
		    <td>
		        <textarea name="description" cols="30" rows="5" placeholder="Description Of The Food"></textarea>
		    </td>
	        </tr>
	        
		<tr>
		    <td>Price: </td>
		    <td>
		        <input type="number" name="price">
		    </td>
	        </tr>
		
	        <tr>
		    <td>Select Image: </td>
		    <td>
		        <input type="file" name="image">
		    </td>
	        </tr>
		
	        <tr>
		    <td>Category: </td>
		    <td>
		        <select name="category">
			
			    <?php
			        //create php code to display categories from db
				//1. create sql query to get all active categories from db
				$sql = "SELECT * FROM tbl_category WHERE active='Yes'";
				
				//executing query
				$res = mysqli_query($conn, $sql);
				
				//count rows to check whether we have category or not
				$count = mysqli_num_rows($res);
				
				//if sount is greater than zero we have categories else we dont have
				if($count>0)
				{
				    //we have categories
                                    while($row=mysqli_fetch_assoc($res))
				    {
				        //get the details of category
					$id = $row['id'];
					$title = $row['title'];
					
					?>
					
					<option value="<?php echo $id; ?>"><?php echo $title; ?></option>
					
					<?php
				    }
				}
				else
				{
				    //we dont have categories
				    ?>
				    <option value="0">No Category Found</option>
				    <?php
				}
				
				
				//2. display on dropdown 
			    ?>
		            	
			</select>
		    </td>
	        </tr>		
		
		<tr>
		    <td>Featured: </td>
		    <td>
		        <input type="radio" name="featured" value="Yes"> Yes
			<input type="radio" name="featured" value="No"> No
		    </td>
	        </tr>
		
		<tr>
		    <td>Active: </td>
		    <td>
		        <input type="radio" name="active" value="Yes"> Yes
			<input type="radio" name="active" value="No"> No
		    </td>
	        </tr>
		
		<tr>
		    <td colspan="2">
		        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
		    </td>
		</tr>
	    
	    </table>  
	
	</form>
	
	
	<?php
	    
	    //check whether the button is clicked or not
	    if(isset($_POST['submit']))
	    {
	        //add the food in db
		//echo "clicked";
		
		//1. get the data from form
		$title = $_POST['title'];
		$description = $_POST['description'];
		$price = $_POST['price'];
		$category = $_POST['category'];
		
		//check whether radio button for featured & active are checked or not
		if(isset($_POST['featured']))
		{
		     $featured = $_POST['featured'];
		}
		else
		{
		     $featured = "No"; //setting the ddefault value
		}
		
		if(isset($_POST['active']))
		{
		     $active = $_POST['active'];
		}
		else
		{
		     $active = "No";
		}
		
		//2. upload the image if selected
		//check whether the select image is clicked or not n upload image if only image selected
		if(isset($_FILES['image']['name']))
		{
		    //get the details of selected image
		    $image_name = $_FILES['image']['name'];
		    
		    //check whether image is selected or not and upload image only if selected
		    if($image_name != "")
		    {
		        //image is selected
			//A. rename the image
			//get the extension of selected image
			$ext = end(explode('.', $image_name));
			
			//create new name for image
			$image_name = "Food-Name-".rand(000, 999).'.'.$ext;
			
			//B. Upload the image
			//get the source path and destination path
			
			//source path is the current location of image
			$src = $_FILES['image']['tmp_name'];
			
			//destination path for image to be uploaded
			$dst = "../images/food/".$image_name;
			
			//finally upload food image
			$upload = move_uploaded_file($src, $dst); 
			
			//check whether image uploaded or not
		        if($upload==false)
		        {
		     	    //failed to upload image
			    //redirect to add food page with message
			    $_SESSION['upload'] = "<div class='error'>Failed to Upload Image. </div>";
			    header("location:".SITEURL.'admin/add-food.php');
			    //stop the process
			    die();
		        }
			
		    }   
		
		}
		else
		{
		    $image_name = ""; //setting default value as blank
		}
		
		//3. insert data into db
		
		//create sql query to save or add food
		//for numerical value no need to pass value inside quote ''
	        $sql2 ="INSERT INTO tbl_food SET 
	            title='$title',
		    description='$description',
		    price= $price,
		    image_name='$image_name',
		    category_id='$category',
		    featured='$featured',
		    active='$active'
	        ";
		
		//execute the query
		$res2 = mysqli_query($conn, $sql2);
		
		//check whether data inserted or not
		//4. redirect with message to manage food page
	        if($res2 == TRUE)
	        {
	             //data inserted successfully
		     $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
		     header("location:".SITEURL.'admin/manage-food.php');
	        }
	        else
	        {
	             //failed to insert data
		     $_SESSION['add'] = "<div class='error'>Failed To Add Food.</div>";
		     header("location:".SITEURL.'admin/manage-food.php');
	        }
		
		
	    }
	    
	?>
	
    </div>
</div>    	

<?php include('partials/footer.php'); ?>