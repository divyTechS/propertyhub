<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/buy.css">
</head>
<body>
    
<?php
    include('conn.php');
    session_start();

    // Initialize state to prevent undefined variable warning
    $state = null;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Handle the form submission (user authentication and payment)
        $userID = $_POST['userID'];
        $password = $_POST['password'];
        $propertyID = $_POST['propertyID'];
        $price = $_POST['price'];

        // Check user credentials
        $sql = "SELECT * FROM user WHERE userID = ? AND password = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $userID, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            // Proceed with the payment and update ownerID
            $updateSQL = "UPDATE property SET state = 'sold', ownerID = ? WHERE propertyID = ?";
            $updateStmt = mysqli_prepare($conn, $updateSQL);
            mysqli_stmt_bind_param($updateStmt, "si", $userID, $propertyID);
            mysqli_stmt_execute($updateStmt);

            echo "<p>Payment successful! The property has been purchased and is now under your ownership.</p>";
        } else {
            echo "<p>Invalid User ID or Password. Please try again.</p>";
        }
    } else if (isset($_GET['propertyID'])) {
        // Display property details
        $propertyID = $_GET['propertyID'];
        $sql = "SELECT * FROM property WHERE propertyID='$propertyID'";

        $res = mysqli_query($conn, $sql);
        
        if ($result = mysqli_fetch_assoc($res)) {
            $title = $result['title'];
            $description = $result['description'];
            $price = $result['price'];
            $location = $result['location'];
            $state = $result['state'];  // Now defined here
            $ownerID = $result['ownerID'];
            $listingDate = $result['listingDate'];
            $imageURL = $result['imageURL'];
        }

        // Check if the property is available for sale
        if ($state == 'sold') {
            echo "<p>This property is already sold.</p>";
            exit;
        }

        // Display property details
        echo "<img src='" . htmlspecialchars($imageURL) . "' alt='Property Image'>";
        echo "<h3>" . htmlspecialchars($title) . "</h3>";
        echo "<p>" . htmlspecialchars($description) . "</p>";
        echo "<p><strong>Price:</strong> $" . number_format($price, 2) . "</p>";
        echo "<p><strong>Location:</strong> " . htmlspecialchars($location) . "</p>";
        echo "<p><strong>State:</strong> " . htmlspecialchars($state) . "</p>";
        echo "<p><strong>Listing Date:</strong> " . htmlspecialchars($listingDate) . "</p>";
    } else {
        echo "<p>Property not found.</p>";
        exit;
    }
?>

<?php if ($state == 'to sell'): ?>
<div>
    <h2>Please enter Credentials to proceed with the payment.</h2>
    <form method="post" action="" style="color: black;">
        <input type="hidden" name="propertyID" value="<?php echo $propertyID; ?>">
        <input type="hidden" name="price" value="<?php echo $price; ?>">

        <!-- User ID and Password Section -->
        <label for="userID">User ID:</label>
        <input type="text" id="userID" name="userID" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <br><br>
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" value="<?php echo $price; ?>" readonly>
        
        <button type="submit">Pay Now</button>
    </form>
</div>
<?php endif; ?>
</body>
</html>