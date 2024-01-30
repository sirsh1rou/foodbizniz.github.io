<?php include('partials-front/menu.php'); ?>
<link rel="stylesheet" href="css/admin.css">

<head>
    <style>
        /* CSS START */
        table tr td {
            text-align: center;
            padding-left: 20px;
            padding-right: 20px;
        }

        table tr th {
            text-align: center;
            padding-left: 20px;
            padding-right: 20px;
        }

        .btn-secondary {
            text-align: center;
            align-items: center;
            width: 100%;
        }

        .lbl-center {
            text-align: center;
            align-items: center;
            width: 100%;
        }

        .font {
            font-size: 20px;
        }
        .submit-order-btn {
            text-align: left;
            width: auto; 
            display: inline-block; 
    }
    </style>
</head>

<body>
    <?php
    // Session Start
    if (isset($_SESSION['table_num'])) {
        $table_num = $_SESSION['table_num'];
    ?>
        <div class="main-content">
            <div class="wrapper">
                <h1>Cart List</h1>

                <br /><br /> <br />
                <?php
                //start session for update, table_num and delete
                if (isset($_SESSION['update'])) {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
                if (isset($_SESSION['table_num'])) {
                    echo 'Your Table Number is ';
                    echo $_SESSION['table_num'];
                }
                if (isset($_SESSION['delete'])) {
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }
                ?>
                <br><br>
                
                <table class="lbl-center">
                    <tr>
                        <th>No.</th>
                        <th>Food</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Order Date</th>
                        <th>Table Number</th>
                        <th>Action</th>
                    </tr>

                    <?php
                    // Fetch and display orders that are not Paid(means the customer is still dining)
                    $sql = "SELECT * FROM tbl_order WHERE table_num = $table_num AND status != 'Paid' ORDER BY order_date DESC";
                    $res = mysqli_query($conn, $sql);
                    $count = mysqli_num_rows($res);
                    $sn = 1;

                    if ($count > 0) {
                        // Display Orders that are not paid yet
                        while ($row = mysqli_fetch_assoc($res)) {
                            $id = $row['id'];
                            $food = $row['food'];
                            $price = $row['price'];

                            // Fetch updated quantity from the database
                            $updated_qty_query = "SELECT qty FROM tbl_order WHERE id = $id";
                            $updated_qty_result = mysqli_query($conn, $updated_qty_query);
                            $updated_qty_row = mysqli_fetch_assoc($updated_qty_result);
                            $qty = $updated_qty_row['qty'];

                            $total = $row['total'];
                            $order_date = $row['order_date'];
                            $table_num = $row['table_num'];
                            $status = $row['status']; // To get the order status

                            // Check if the order status is Paid(means the customer has already paid their food)
                            if ($status != 'Paid') {
                    ?>
                            <!-- Get Data -->
                                <tr>
                                    <td><?php echo $sn++; ?>.</td>
                                    <td><?php echo $food; ?></td>
                                    <td><?php echo $price; ?></td>
                                    <td><?php echo $qty; ?></td>
                                    <td><?php echo $total; ?></td>
                                    <td><?php echo $order_date; ?></td>
                                    <td><?php echo $table_num; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>delete-order.php?id=<?php echo $id ?>" class="btn-secondary"> Delete Item</a>
                                        <br><br><a href="<?php echo SITEURL; ?>update-amount.php?id=<?php echo $id ?>" class="btn-secondary">Update Amount</a>
                                    </td>
                                </tr>

                    <?php
                            }
                        }
                    } else {
                        echo "<tr><td colspan='12' class='error'>No Food Added to Cart</td></tr>";
                    }
                    ?>
                </table>

                <?php
                //  Check if there are no orders available
                if ($count <= 0) {
                    echo "<b><p>Orders are not available. Please add items to your cart first.</p></b>";
                    echo "<br>";
                    echo "<form method='post' action='foods.php'><input type='submit' value='Order Now'></form>";
                } else {
                    // If orders are available, show the Submit Order and Browse More Foods buttons
                    echo "<p><a id='submitOrderBtn' href='" . SITEURL . "submit-order.php?id=" . $id . "' class='btn-secondary'>Submit Order</a></p>";
                    echo "<br>";
                    echo "<form method='post' action='index.php'><input type='submit' value='Browse More Foods'></form>";
                }
                ?>

            </div>
        </div>

    <?php include('partials-front/footer.php');
    } else {
        echo "<font><b><div class='lbl-center'>You Have to start ordering first to see the cart .</div></b></font>";
    }
    ?>
</body>

