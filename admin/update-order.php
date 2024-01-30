<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</hr>
        <br></br>

        <?php
            //Check whether id is set or not 
            if(isset($_GET['id']))
            {
                //Get all Order Details
                $id=$_GET['id'];
                //Get all other deatils based on this id
                //SQL Query to get the order details
                $sql = "SELECT * FROM tbl_order WHERE id = $id";
                //Execute Query
                $res = mysqli_query($conn, $sql);
                //Count Rows
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //Detail Available
                    $row=mysqli_fetch_assoc($res);
                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $status = $row['status'];
                    $table_num = $row['table_num'];
                }
                else
                {
                    //Detail not Available
                    //Redirect to Manage Order
                    header('location'.SITEURL.'admin/manage-order.php');
                }
            }
            else
            {
                //Redirect to Manage Order Page
                header('location'.SITEURL.'admin/manage-order.php');
            }
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <!---- --->
                <tr>
                    <td>Food Name</td>
                    <td><b> <?php echo $food; ?></b></td>
                </tr>
                <!---- --->
                <tr>
                    <td>Price</td>
                    <td><b>RM<?php echo $price; ?></b></td>
                </tr>
                <!---- --->
                <tr>
                    <td>Quantity</td>
                    <td><input type="number" name="qty" value="<?php echo $qty;?>"min="0" max="10" maxlength="2"></td>
                </tr>
                <!---- --->
                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status">
                            <option <?php if($status=="Ordered"){echo "selected";}?>value="Ordered">Ordered</option>
                            <option <?php if($status=="Completed"){echo "selected";}?>value="Completed">Completed</option>
                            <option <?php if($status=="Paid"){echo "selected";}?>value="Paid">Paid</option>
                        </select>   
                    </td>
                </tr>
                <!---- --->
                <tr>
                    <td>Table Number: </td>
                    <td>
                        <input type="number" name="table_num" value="<?php echo $table_num; ?>" min="0" max="30" maxlength="2">
                    </td>
                </tr>
                <!---- --->
                <tr>
                    <td clospan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                </tr>
        </form>
        <?php
            //Check whether update Button is Clicked or Not
            if(isset($_POST['submit']))
            {
                //echo "Clicked";
                //Get all the values from the order form
                $id=$_POST['id'];
                $price=$_POST['price'];
                $qty=$_POST['qty'];
                $total = $price * $qty;

                $status = $_POST['status'];
                $table_num = $_POST['table_num'];

                //Update the values
                $sql2 = "UPDATE tbl_order SET
                        qty = $qty,
                        total = $total,
                        status = '$status',
                        table_num = '$table_num'
                        WHERE id=$id
                ";
                //Execute the Query
                $res2 = mysqli_query($conn, $sql2);

                //Check update or not
                //Redirect to manage order with message
                if($res2==true)
                {
                    //Update
                    $_SESSION['update'] = "<div class='success'>Order Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
                else
                {
                    //Failed to Update
                    $_SESSION['update'] = "<div class='error'>Sorry, Failed to Update Order.</div>";
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
            }
        ?>
        </table>
    </div>
</div>   
<?php include('partials/footer.php'); ?>