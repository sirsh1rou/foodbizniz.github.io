<?php include('partials/menu.php'); ?>

<div class="main-content">
	<div class="wrapper">
		<h1>Manage Order</h1>
		     		    	
		<br /><br /> <br />   
		<?php
			if(isset($_SESSION['update']))
			{
				echo $_SESSION['update'];
				unset($_SESSION['update']);
			}
		?>    
		<br><br>
		<table class="tbl-full">
		    <tr>
		    	<th>No.</th>
			<th>Food</th>
			<th>Price</th>
			<th>Quantity</th>
			<th>Total</th>
			<th>Order Date</th>
			<th>Status</th>
			<th>Table Number</th>
			<th>Actions</th>
		    </tr>

		    <?php
				//Get all the orders from database, display the latest order at first
				$sql = "SELECT * FROM tbl_order ORDER BY id DESC";
				//Execute Query
				$res = mysqli_query($conn, $sql);
				//Count the Rows
				$count = mysqli_num_rows($res);
				//Create a Serial Number and set its initial values
				$sn = 1; 
				if($count>0)
				{
					//Order Available
					while($row=mysqli_fetch_assoc($res))
					{
						//Get all the order details
						$id = $row['id'];
						$food = $row['food'];
						$price = $row['price'];
						$qty = $row['qty'];
						$total = $row['total'];
						$order_date = $row['order_date'];
						$status = $row['status'];
						$table_num = $row['table_num'];

						?>
						<tr>
							<td><?php echo $sn++; ?>.</td>
							<td><?php echo $food; ?></td>
							<td><?php echo $price; ?></td>
							<td><?php echo $qty; ?></td>
							<td><?php echo $total; ?></td>
							<td><?php echo $order_date; ?></td>
							<td>
							<?php
							    //Each status will display different color, for example status 'Delivered' will be green.
								if($status=="Ordered")
								{
									echo "<b><label style='color: red;'><br>$status</label>";
								}
								
								elseif($status=="Completed")
								{
									echo "<b><label style='color: blue;'><br>$status</label>";
								}

								elseif($status=="Paid")
								{
									echo "<b><label style='color: green;'><br>$status</label>";
								}
							?>
							</td>
							<td><?php echo $table_num; ?></td>
							<td>
								<a href="<?php echo SITEURL;?>admin/update-order.php?id=<?php echo $id ?>" class="btn-secondary"> Update Order</a>
							
							</td>
						</tr>
						<?php
					}
				}
				else
				{
					//Order not Available
					echo "<tr><td colspan='12' class='error'>Orders not Available</td></tr>";
				}
			?>
		</table>
	</div>
</div>

<?php include('partials/footer.php'); ?>