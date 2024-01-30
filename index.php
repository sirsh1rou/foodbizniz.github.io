    <?php include('partials-front/menu.php');?>

    <!-- FOOD SEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->
    <?php
        if(isset($_SESSION['order']))
        {
            echo($_SESSION['order']);
            unset($_SESSION['order']);

        }
    ?>
    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
                //Create SQL Query to Display Categories from Database
                $sql = "SELECT * FROM tbl_category WHERE active='Yes' LIMIT 3";
                //Execute the Query
                $res = mysqli_query($conn, $sql);
                //Count rows to check whether the category is available or not
                $count = mysqli_num_rows($res);

                if($count>0)
                {
                    //Categories Available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Get the Values like id, title, image_name
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>

                        <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                                <?php
                                    //Check whether the image is available or not
                                    if($image_name=="")
                                    {
                                        //Display Message
                                        echo "<div class='error'>Image not Available</div>";
                                    }
                                    else
                                    {
                                        //Image Available
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                        <?php
                                    }
									
                                ?>
                               <h3 class="float-text text-white text-with-border"><?php echo $title;?></h3>
                            </div>
                        </a>
                                
                        <?php

                    }
                }
                else
                {
                    //Categories not available
                    echo "<div class='error'>Category no Added.</div>";
                }
            ?>

            <div class="clearfix"></div>
        </div>
    </section>
	
    <!-- Categories Section Ends Here -->
    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>
            
            <?php

            //Getting Foods from database that are active 
            //SQL Query
            $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' LIMIT 6";

            //Execute the Query
            $res2 = mysqli_query($conn, $sql2);

            // Count Rows
            $count2 = mysqli_num_rows($res2);

            //Check whether the food is available or not
            if($count2>0)
                {
                    //Food Available
                    while($row=mysqli_fetch_assoc($res2))
                    {
                        //Get the Values like id, title, image_name
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
                        ?>
                         <!--/////////////////////////////////////////////////////////////////// -->  
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                            </div>

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
                                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve" width="150" height="300">
                                            <?php
                                        }
                                ?>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">RM<?php echo $price; ?></p>
                                <p class="food-detail"><?php echo $description; ?> </p>
                                <br>

                                <a href="<?php SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Add to Cart</a>
                            </div>
                        </div>
                        <?php

                    }
                }
                else
                {
                    //Food not available
                    echo "<div class='error'>Food not available.</div>";
                }
            ?>
            <!--/////////////////////////////////////////////////////////////////// -->  
            <div class="clearfix"></div>
        </div>

        <p class="text-center">
            <a href="foods.php">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>