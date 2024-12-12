<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/rent.css">
</head>
<body>
 
<?php
// Include the database connection
include('conn.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $userID = $_POST['userID'];
    $password = $_POST['password'];
    $propertyID = $_POST['propertyID'];
    $price = $_POST['price'];
    $landlordID = $_POST['landlordID'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    // Step 1: Verify the user's credentials
    $sql = "SELECT * FROM user WHERE userID = ? AND password = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $userID, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User authentication successful
            // Step 2: Update property status to 'rented'
            $updateQuery = "UPDATE property SET state = 'rented' WHERE propertyID = ?";
            if ($updateStmt = $conn->prepare($updateQuery)) {
                $updateStmt->bind_param("i", $propertyID);
                $updateStmt->execute();
            } else {
                echo "Error: Could not update property status.";
                exit;
            }

            // Step 3: Insert the tenancy record into the Tenancies table
            $tenancyQuery = "INSERT INTO Tenancies (propertyID, tenantID, landlordID, startDate, endDate, rentAmount) 
                             VALUES (?, ?, ?, ?, ?, ?)";
            if ($tenancyStmt = $conn->prepare($tenancyQuery)) {
                $tenantID = $userID; // Use the provided userID as the tenantID
                $tenancyStmt->bind_param("iiissi", $propertyID, $tenantID, $landlordID, $startDate, $endDate, $price);
                $tenancyStmt->execute();
            } else {
                echo "Error: Could not insert tenancy record.";
                exit;
            }

            // Step 4: Insert rental transaction record (for the first payment)
            $transactionQuery = "INSERT INTO rentalTransactions (propertyID, tenantID, landlordID, transactionDate, amount) 
                                 VALUES (?, ?, ?, NOW(), ?)";
            if ($transactionStmt = $conn->prepare($transactionQuery)) {
                $transactionStmt->bind_param("iiis", $propertyID, $tenantID, $landlordID, $price);
                $transactionStmt->execute();
            } else {
                echo "Error: Could not record rental transaction.";
                exit;
            }

            // Step 5: Show success message and countdown to redirect
            echo "Payment successful! The property has been rented.";
            echo '<p>You will be redirected to the properties page in 3 seconds...</p>';
            header("refresh:3; url=properties.php"); // Redirect to the properties page after 3 seconds
        } else {
            // Invalid user credentials
            echo "Invalid User ID or Password. Please try again.";
        }
    } else {
        echo "Error: Could not verify user credentials.";
    }
} else {
    // Display the rental form if not submitted
    if (isset($_GET['propertyID'])) {
        $propertyID = $_GET['propertyID'];

        // Fetch property details
        $sql = "SELECT * FROM property WHERE propertyID = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $propertyID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($property = $result->fetch_assoc()) {
                $title = $property['title'];
                $description = $property['description'];
                $price = $property['price'];
                $location = $property['location'];
                $state = $property['state'];
                $ownerID = $property['ownerID'];

                // Check if the property is available for rent
                if ($state != 'to let') {
                    echo "<p>This property is already rented or not available for rent.</p>";
                    exit;
                }

                // Display property details
                echo "<h2>Property Details</h2>";
                echo "<h3>" . htmlspecialchars($title) . "</h3>";
                echo "<p>" . htmlspecialchars($description) . "</p>";
                echo "<p><strong>Price:</strong> $" . number_format($price, 2) . " / month</p>";
                echo "<p><strong>Location:</strong> " . htmlspecialchars($location) . "</p>";

                // Show rental form
                echo '
                <form method="POST" action="">
                    <input type="hidden" name="propertyID" value="' . $propertyID . '">
                    <input type="hidden" name="price" value="' . $price . '">
                    <input type="hidden" name="landlordID" value="' . $ownerID . '">
                    <input type="hidden" name="startDate" value="' . date('Y-m-d') . '">
                    <input type="hidden" name="endDate" value="' . date('Y-m-d', strtotime('+1 year')) . '">

                    <h3>Please enter your credentials to proceed with the rental.</h3>
                    <label for="userID">User ID:</label>
                    <input type="text" name="userID" required>

                    <label for="password">Password:</label>
                    <input type="password" name="password" required>

                    <br><br>
                    <label for="amount">Amount:</label>
                    <input type="number" name="amount" value="' . $price . '" readonly>

                    <button type="submit">Pay Now</button>
                </form>';
            } else {
                echo "Property not found.";
            }
        } else {
            echo "Error fetching property details.";
        }
    } else {
        echo "Property ID is missing.";
    }
}
?>
   
   </body>
</html>