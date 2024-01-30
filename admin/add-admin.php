<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Manager</h1>
	
	<br><br>
	
	<?php 
	    if(isset($_SESSION['add'])) //checking whether the session is et or not
	    {
	        echo $_SESSION['add']; //display the message if set
	        unset($_SESSION['add']); //remove session message
	    }
	?>
	
	<form action="" method="POST">
	
	    <table class="tbl-30">
	        <tr>
		    <td>Full Name: </td>
		    <td>
		        <input type="text" name="full_name" placeholder="Enter Your Name">
		    </td>
	        </tr>
		
		<tr>
		    <td>Username: </td>
		    <td>
		        <input type="text" name="username" placeholder="Your Username">
		    </td>
		</tr>
		
		<tr>
		    <td>Password: </td>
		    <td>
		        <input type="password" name="password" placeholder="Your Password">
		    </td>
		</tr>
		
		<tr>
		    <td colspan="2">
		        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
		    </td>
		</tr>
		
	    </table>	
	
	</form>
	
	
    </div>		
</div>

<?php include('partials/footer.php'); ?>


<?php
	//process the value form and save it in database
	
	//check whether the submit button is clicked or or not
	
	if(isset($_POST['submit']))
	{
	    //button clicked
	    //echo "Button Clicked";
	    
	    //1.get the data from form
	    $full_name = $_POST['full_name'];
	    $username = $_POST['username'];
	    $password = md5($_POST['password']); //password encryption with MD5
	    
	    //2.sql query to save to database
	    $sql ="INSERT INTO tbl_admin SET 
	        full_name='$full_name',
		username='$username',
		password='$password'
	    ";
	    
	    //3.executing query and saving data into database 
	    $res = mysqli_query($conn, $sql) or die(mysqli_error());
	    
	    //4.check whether the (query is executed) data is inserted or not and display right message
	    if($res==TRUE)
	    {
	     //Data inserted
		 //echo "Data Inserted";
		 //create a session variable to display message
		 $_SESSION['add'] = "Admin Added Successfully";
		 //redirect page to Manage admin
		 header("location:".SITEURL.'admin/manage-admin.php');
	    }
	    else
	    {
	     //failed to insert data
		 //echo "Fail to Insert Data";
		 //create a session variable to display message
		 $_SESSION['add'] = "Failed To Add Admin";
		 //redirect page to Add admin
	 	 header("location:".SITEURL.'admin/add-admin.php');
	    }
	
	}	

?>