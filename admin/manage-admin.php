<?php include('partials/menu.php'); ?>
	

	<!-- Main Content Starts -->
	<div class="main-content">
	    <div class="wrapper">
	    	<h1>Manager List</h1>
		
		<br /><br />     
		
		<?php 
		    if(isset($_SESSION['add']))
		    {
		        echo $_SESSION['add']; //displaying session message
			unset($_SESSION['add']); //removing session message
		    }
		    
		    if(isset($_SESSION['delete']))
		    {
		        echo $_SESSION['delete'];
			unset($_SESSION['delete']);
		    }
		    
		    if(isset($_SESSION['update']))
		    {
		        echo $_SESSION['update'];
			unset($_SESSION['update']);
		    }
		    
		    if(isset($_SESSION['user-not-found']))
		    {
		        echo $_SESSION['user-not-found'];
			unset($_SESSION['user-not-found']);
		    }
		    
		    if(isset($_SESSION['pwd-not-match']))
		    {
		        echo $_SESSION['pwd-not-match'];
			unset($_SESSION['pwd-not-match']);
		    }
		    
		    if(isset($_SESSION['change-pwd']))
		    {
		        echo $_SESSION['change-pwd'];
			unset($_SESSION['change-pwd']);
		    }  
		?>
		<br><br><br>
		    
		<!-- Button to add admin -->
		<a href="add-admin.php" class="btn-primary"> Add New Manager</a>
		
		<br /><br /> <br />   
		    
		<table class="tbl-full">
		    <tr>
		    <th>No.</th>
			<th>Full Name</th>
			<th>Username</th>
			<th>Actions</th>
		    </tr>
		    
		    
		    <?php
		        //query to get all admin from database
		        $sql = "SELECT * FROM tbl_admin";
			//execute the query
			$res = mysqli_query($conn, $sql);
			
			//check whether the query is executed or not
			if($res==TRUE)
			{
			    //count rows to check whether we hv data in database or not
			    $count = mysqli_num_rows($res); //get all rows in db
			    
			    $sn=1; //create a variable and assign the value
			    
			    //check the no of rows
			    if($count>0)
			    {
			        //we have data in db
				while($rows=mysqli_fetch_assoc($res))
				{
				    //using while loop to get all data from db
				    //and while loop will run as long as we have data in db
				    
				    //get individual data
				    $id=$rows['id'];
				    $full_name=$rows['full_name'];
				    $username=$rows['username'];
				    
				    //display the values in table
				    ?>
				    
				    <tr>
				       <td><?php echo $sn++; ?></td>
				       <td><?php echo $full_name; ?></td>
				       <td><?php echo $username; ?></td>
				       <td>
				           <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary"> Change Password</a>
				           <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary"> Update Admin</a> 
				       </td>
				    </tr>
				    
				    <?php
				     
				}
			    }
			    else
			    {
			        //we dont have data in db
			    }
			}
			
		    ?>
		    
		</table>

	    </div>
	</div>
	<!-- Main Content Ends --> 

<?php include('partials/footer.php'); ?>