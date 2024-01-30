<head>
    <style>
        .order-header {
            font-size: 1.5em; 
            margin-bottom: 10px; 
        }
        .center{
            text-align: center;
        }
        .lbl-centerv2 {
        margin: auto;
        width: 50%;
        height: 25%;
        margin-top: 5px;
        margin-bottom: 20px;
        padding: 5px;
        }
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

        
        .lbl-centerv2 td {
            padding: 5px; /* Adjust the padding as needed */
            text-align: center;
        }
</style>
</head>
<body>
<link rel="stylesheet" href="css/admin.css">
<?php
    // Include the necessary files and start the session
    include('partials-front/menu.php');

    if (isset($_SESSION['table_num'])) {
        // Retrieve the table number from the session
        $table_num = $_SESSION['table_num'];

        // Fetch and display order details
        $sql = "SELECT * FROM tbl_order WHERE table_num = $table_num AND status != 'Paid' ORDER BY order_date DESC";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);

        if ($count > 0) {
            // Display content only if there is at least one row
        ?>
            <div class="main-content">
                <div class="wrapper">
                    <h2 class="center">THANK YOU FOR ORDERING, PLEASE PAY AT COUNTER</h2>
                    <?php
                    // Loop through all orders and display their details
                    while ($row = mysqli_fetch_assoc($res)) {
                        $order_date = $row['order_date'];
                        $table_num = $row['table_num'];
        ?>
                    <div>
                        <h1 class="order-header">Table Number: <?php echo $table_num; ?> <br> Order Date: <?php echo $order_date; ?></h1>
                    </div>
                    <br /><br /> <br />

                <table class="lbl-centerv2">
                    <tr>
                        <th>No.</th>
                        <th>Food</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        
                    </tr>
                    <?php
                    $sn = 1;
                    $grand_total = 0; 
                    // Loop through order details and display them
                    $res = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($res)) {
                        $food = $row['food'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $total = $row['total'];

                        $grand_total += $total;
                    ?>
                        <tr>
                            <td><?php echo $sn++; ?>.</td>
                            <td><?php echo $food; ?></td>
                            <td><?php echo $price; ?></td>
                            <td><?php echo $qty; ?></td>
                            <td><?php echo $total; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <th colspan="4">Total Payment:</th>
                        <td colspan="3">RM<?php echo $grand_total; ?></td>
                    </tr>
                </table>

                <p>
                        <form method="post" action="index.php">
                            <br>
                            <input type="submit" value="Return Main Menu">
                        </form>
                </p>
                <?php
                }
                ?>
                </div>
            </div>
        <?php
        } else {
            // If no rows are found, show the pop-up message and redirect
        ?>
            <script>
                alert("Please start ordering first.");
                window.location.href = "cart.php";
            </script>
            <?php
        }
    } else {
        // If 'table_num' is not set, only include menu.php
        include('partials-front/menu.php');
    }
    ?>
    <!-- Your existing HTML and footer inclusion goes here -->
    <?php include('partials-front/footer.php'); ?>
</body>
