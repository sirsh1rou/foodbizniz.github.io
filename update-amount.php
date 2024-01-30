<?php include('partials-front/menu.php');?>
<link rel="stylesheet" href="css/admin.css">
<head>
        <style>
                table tr td{
                    padding-left:20px; padding-right:20px
                    font-size: 20px;
                }
        </style>
        <style>
                table tr th{
                    padding-left:20px; padding-right:20px
                    font-size: 20px;
                }
        </style>
</head>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Quantity</h1>
        <br></br>

        <?php
        if (isset($_SESSION['table_num'])) {
            $table_num = $_SESSION['table_num'];
            
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
                }
                else
                {
                    //Detail not Available
                    //Redirect to Manage Order
                    header('location'.SITEURL.'cart.php');
                }
            }
            else
            {
                //Redirect to Manage Order Page
                header('location'.SITEURL.'cart.php');
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
                    <td><input type="number" name="qty" value="<?php echo $qty; ?>" min="1" max="10" maxlength="2"></td>
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

                //Update the values
                $sql2 = "UPDATE tbl_order SET
                        qty = $qty,
                        total = $total
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
                    header('location:'.SITEURL.'cart.php');
                }
                else
                {
                    //Failed to Update
                    $_SESSION['update'] = "<div class='error'>Sorry, Failed to Update Order.</div>";
                    header('location:');
                }
            }
        } else {
            // Handle the case where table_num is not set in the session
            echo "<font><b><div class='lbl-center'>Update Quantity Failed.</div></b></font>";
            header('location:'.SITEURL.'cart.php');
        }
   
        ?>
        </table>
    </div>
</div>   
<?php include('partials-front/footer.php'); ?>