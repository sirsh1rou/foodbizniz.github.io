<style>
    .with-border {
    border: 1px solid black; 
    padding: 5px; 
    }

    
    .with-border:hover {
        border-color: red; 
    }

</style>    
<body>
<?php include('partials-front/menu.php');?>
            <!-- fOOD sEARCH Section Starts Here -->
            <section class="food-search text-center">
                <div class="container">
            
                <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                    <input type="search" name="search" placeholder="Search for Food..">
                    <input type="submit" name="submit" value="Search" class="btn btn-primary">
                </form>

                 </div>
            </section>
            <!-- fOOD sEARCH Section Ends Here -->
    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>
        <!-- ------------------------------------------------- -->

        <?php
            //Display all categories that are active
            //SQL Query
            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                
            //Execute the Query
            $res = mysqli_query($conn, $sql);

            //Count rows 
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
        ?><!-- -->
                        
                        <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                        <div class="box-3 float-container with-border"> <!-- Added "with-border" class -->
                            <?php
                            // Check whether the image is available or not
                            if ($image_name == "") {
                                // Display Message
                                echo "<div class='error'>Image not found</div>";
                            } else {
                                // Image Available
                                ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="<?php echo $title; ?>"
                                    class="img-responsive img-curve" style="width: 330px; height: 250px;">
                                <?php
                            }
                            ?>

                            <h3 class="float-text text-white text-with-border"><?php echo $title; ?></h3>

                        </div>
                    </a>
                    <!-- -->
                    <?php

                    }
                }
                else
                {
                    //Categories not available
                    echo "<div class='error'>Category no found.</div>";
                }
        ?>
        <!-- ------------------------------------------------- -->
       
            <div class="clearfix"></div>
        </div>
    </section>
<body>
    <!-- Categories Section Ends Here -->
    <?php include('partials-front/footer.php');?>
