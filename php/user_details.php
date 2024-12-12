<?php
// user_details.php - To fetch details of a specific user

// Include the database connection
include('conn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
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
            background: linear-gradient(135deg, #6a11cb, #2575fc);
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

        /* User Details Styling */
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

        /* No User Styling */
        .no-user {
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
        // Check if the user ID is passed as a query parameter
        if(isset($_GET['uname'])) {
            $userID = $_GET['uname'];

            // SQL query to fetch user details based on userID
            $sql = "SELECT * FROM user WHERE userID = '$userID'";
            $res = mysqli_query($conn, $sql);

            // Check if the query returns any data
            if (mysqli_num_rows($res) > 0) {
                // Fetch and display the user's details
                $user = mysqli_fetch_assoc($res);
                echo "<h2>User Details</h2>";
                echo "<p><strong>User ID:</strong> " . $user['userID'] . "</p>";
                echo "<p><strong>Email:</strong> " . $user['email'] . "</p>";
                echo "<p><strong>Name:</strong> " . $user['name'] . "</p>";
                echo "<p><strong>Phone:</strong> " . $user['phone'] . "</p>";
                // Add more user fields as needed
            } else {
                echo "<p class='no-user'>No user found with ID: $userID</p>";
            }
        } else {
            echo "<p class='no-user'>No user ID specified!</p>";
        }
        ?>
    </div>
</body>
</html>
