<?php
// transaction_details.php - To fetch details of a specific transaction

// Include the database connection
include('conn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Details</title>
    <style>
        /* Global Reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* Body Styling */
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #6a1b9a, #8e24aa); /* Purple Gradient */
            color: #f9f9f9;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* Container Styling */
        .container {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            padding: 40px;
            width: 90%;
            max-width: 600px;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header Styling */
        h2 {
            text-align: center;
            color: #fff;
            margin-bottom: 20px;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
        }

        /* Details Styling */
        p {
            background: rgba(255, 255, 255, 0.8);
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            color: #333;
            text-shadow: none;
        }

        p strong {
            color: #6a1b9a; /* Matching Purple Accent */
        }

        /* No Data Styling */
        .no-data {
            text-align: center;
            color: #fff;
            background: rgba(255, 0, 0, 0.7);
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Check if the transaction ID is passed as a query parameter
        if(isset($_GET['transactionID'])) {
            $transactionID = $_GET['transactionID'];

            // SQL query to fetch transaction details based on transactionID
            $sql = "SELECT * FROM salestransactions WHERE transactionID = '$transactionID'";
            $res = mysqli_query($conn, $sql);

            // Check if the query returns any data
            if (mysqli_num_rows($res) > 0) {
                // Fetch and display the transaction's details
                $transaction = mysqli_fetch_assoc($res);
                echo "<h2>Transaction Details</h2>";
                echo "<p><strong>Transaction ID:</strong> " . $transaction['transactionID'] . "</p>";
                echo "<p><strong>Property ID:</strong> " . $transaction['propertyID'] . "</p>";
                echo "<p><strong>Amount:</strong> $" . number_format($transaction['amount'], 2) . "</p>";
                // Add more transaction fields as needed
            } else {
                echo "<p class='no-data'>No transaction found with ID: $transactionID</p>";
            }
        } else {
            echo "<p class='no-data'>No transaction ID specified!</p>";
        }
        ?>
    </div>
</body>
</html>
