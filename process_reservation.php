<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Haiveen's</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgba(34, 34, 34, 0.8);
            background-image: url("https://images.unsplash.com/photo-1584169506626-325741ce84ec?q=80&w=1854&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D");
            background-size: cover;
            background-position: center;
            color: #fff;
        }

        header {
            background-color: #b76e79;
            padding: 20px;
            text-align: center;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        #logo {
            width: 110px;
            margin-right: 10px;
        }

        h1 {
            margin: 0;
            padding: 10px;
            font-family: 'Playfair Display', serif;
            font-size: 1.3em;
            font-weight: bold;
            color: #fff;
            border: 3px solid #FFD700;
            border-radius: 8px;
            display: block;
            text-align: center; 
        }

        section {
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 20px;
            text-align: left;
            border-radius: 8px;
            margin: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 15px;
            color: #fff;
            text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.8);
            font-size: 1.2em;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0 20px 0;
            display: inline-block;
            font-family: Candara, Arial, sans-serif;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1em;
            background-color: #fff;
            color: #555;
            transition: border-color 0.3s ease;
        }

        input:hover,
        input:focus {
            border-color: #555;
        }

        .divider {
            border-top: 1px solid #ffd700;
            margin: 20px 0;
        }

        input[type="submit"] {
            background-color: #b76e79;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }

        .reservation-details {
            border: 2px solid #FFD700;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            font-size: 1.0em;
            font-weight: bold;
            text-align: left; 
        }

        footer {
            background-color: #b76e79;
            padding: 10px;
            text-align: center;
            color: #fff;
        }
    </style>
</head>

<body>
    <header>
        <img src="Home image/Logo.webp" alt="Logo.webp" id="logo">
        <h1>Haiveen's Online Table Reservation And Ordering System</h1>
        <img src="Home image/Logo.webp" alt="Logo.webp" id="logo">
    </header>

    <section>
        <h2>Payment Details:</h2>

        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $name = $_POST['name'];
                $contact = $_POST['contact'];
                $email = $_POST['email'];
                $num_people = $_POST['num_people'];
                $date = $_POST['date'];
                $time = $_POST['time'];
                $selectedRestaurant = $_POST['restaurant'];
                $selectedMenus = $_POST['menu']; 
                $bookingID = $_POST['booking_id'];

                echo "<div class='reservation-details'>";
                echo "<p>Name: $name</p>";
                echo "<p>Contact: $contact</p>";
                echo "<p>Email: $email</p>";
                echo "<p>Number of People: $num_people</p>";
                echo "<p>Date: $date</p>";
                echo "<p>Time: $time</p>";
                echo "<p>Selected Restaurant: $selectedRestaurant</p>";
                
                echo "<p>Selected Menus: ";
                foreach ($selectedMenus as $menu) {
                    echo "$menu, ";
                }
                echo "</p>";

                echo "<p>Reservation Fee is RM5</p>";
                echo "<p>Booking ID: $bookingID</p>";
                echo "</div>";
            }
        ?>

        


<?php
       
        function getQrImageForRestaurant($restaurant)
        {
            
            $qrImages = [
                'Rohavin\'s Roti Canai' => 'Payment/Qr.jpg',
                'Jessleen\'s Punjabi Cuisine' => 'Payment/Qr.jpg',
                'Durkesh\'s Spicy India' =>'Payment/Qr.jpg',
                'Jack\'s Sweet Cafe' => 'Payment/Qr.jpg',
                'Malbir\'s Wonton' => 'Payment/Qr.jpg',
                'Dapur Ika' => 'Payment/Qr.jpg',
                'Jey\'s Spicy Tomyum' => 'Payment/Qr.jpg',
                'Bal\'s Desert Cafe' => 'Payment/Qr.jpg',
                'Dalip\'s Yummy Seafood' => 'Payment/Qr.jpg',
                
            ];

            
            if (isset($qrImages[$restaurant])) {
                return $qrImages[$restaurant];
            } else {
                return 'path/to/generic_qr.jpg';        
            }
        }

       
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
            $selectedRestaurant = $_POST['restaurant'];
            $qrImage = getQrImageForRestaurant($selectedRestaurant);    

        }
        ?>

        <form action="process_payment.php" method="post">
            <br>
            <label for="qr">QR Payment:</label>
            <img src="<?php echo $qrImage; ?>" alt="QR Code for Payment" style="max-width: 70%; height: auto;">
            <br>
            <br>
            <label for="image">Upload Receipt Image File (Proof Of Payment)</label>
            <input type="file" id="image" name="image" accept="image/*">
            <input type="submit" value="Make Payment">
        </form>
    </section>

    <footer>
        &copy; 2023 Haiveen's Online Table Reservation And Ordering System
    </footer>
</body>

</html>

<?php

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "haiveen_reservation";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $num_people = $_POST['num_people'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $selectedRestaurant = $_POST['restaurant'];
    $selectedMenus = implode(', ', $_POST['menu']);

    // Prepare the SQL statement
    $sql = "INSERT INTO reservations (booking_id, name, contact, email, num_people, date, time, menu, restaurant)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Check for SQL errors
    if ($stmt === false) {
        die('Error in SQL query: ' . $conn->error);
    }

    // Bind parameters
    $bindResult = $stmt->bind_param("ssssissss", $bookingID, $name, $contact, $email, $num_people, $date, $time, $selectedMenus, $selectedRestaurant);

    // Check if binding parameters was successful
    if ($bindResult === false) {
        die('Error binding parameters: ' . $stmt->error);
    }

    // Execute the statement
    $executeResult = $stmt->execute();

    // Check if execution was successful
    if ($executeResult === false) {
        die('Error executing query: ' . $stmt->error);
    }

    

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
