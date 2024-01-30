
<head>
<style>
    .text-whitetext-with-border{
    text-align: center;
}
</style>
</head>
<body>
<?php include('partials-front/menu.php'); ?>

    <?php
    //Check whether food id is set or not
    if(isset($_GET['food_id']))
    {
        //Get the food id and details of the selected food
        $food_id = $_GET['food_id'];

        //Get the details of the selected food
        $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
        //Execute the Query
        $res = mysqli_query($conn, $sql);
        //Count the rows
        $count = mysqli_num_rows($res);
        //Check whether the data is available or not
            if($count==1)
            {
                //get data from database
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $price = $row['price'];
                $image_name =$row['image_name'];
            }
            else
            {
                //food not available
                //redirect to home page
                header('location'.SITEURL);
            }
    }
    ?>
    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
        
            <h2 class="text-whitetext-with-border">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                    <?php
                                        //Check whether the image is available or not
                                        if($image_name=="")
                                        {
                                            //Image not available
                                            echo "<div class='error'>Image not found.</div>";
                                        }
                                        else
                                        {
                                            //Image Available
                                            ?>
                                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                            <?php
                                        }
                    ?>
                        
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title;?>">

                        <p class="food-price">RM<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price;?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" min="1" max="10" maxlength="2" required>
                        
                        <!--<div class="order-label">Table Number</div>-->
                        <!--Table is Set to Table no.1 -->
                    <input type="hidden" name="table_num" placeholder="E.g. 6" class="input-responsive" min="1" max="30" maxlength="2" value="1" required>
                
                    <input type="submit" name="submit" value="Add to Cart" class="btn btn-primary">
                    </div>


                </fieldset>
                
                
            </form>
                <?php
                //check whether submit button is clicked or not
                if(isset($_POST['submit']))
                {
                    //get all the details from the menu form
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];
                    //math operation
                    $total = $price * $qty;
                    //order date
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    $order_date = date("Y-m-d h:i:sa");
                    //food status
                    $status = "Ordered";
                    //
                    $table_num = $_POST['table_num'];
                    //
                    //Save order details in database
                    $sql2 = "INSERT INTO tbl_order SET 
                     food = '$food',
                     price = $price,
                     qty = $qty,
                     total = $total,
                     order_date = '$order_date',
                     status = '$status', 
                     
                     table_num = '$table_num'
                    ";
                    //
                    //
                    //
                    $_SESSION['table_num'] = $table_num; 
                    //echo $sql2; die();

                    //Execute Query
                    $res2 = mysqli_query($conn, $sql2);
                    //check whether query executed successfully or not
                    if($res2==true)
                    {
                        //query executed and order saved
                        $_SESSION['order']="<div class='success text-center'>Food has been added to cart.</div>";
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        //Failed to save order
                        $_SESSION['order']="<div class='error text-center'>System failed, please try again.</div>";
                        header('location:'.SITEURL);
                    }
                }
                ?>
        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
</body>