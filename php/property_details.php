<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PropertyHub - Property Details</title>
    <link rel="stylesheet" href="../css/property_details.css">
</head>
<body>
    <nav>
        <img src="../images/logo.jpeg" alt="logo">
        <ul>
            <li><a href="../html/index.html">Home</a></li>
            <li><a href="../html/about_us.html">About</a></li>
            <li><a href="../html/contact.html">Contact</a></li>
            <li><a href="../html/admin.html">Admin</a></li>
        </ul>
    </nav>
    <div class="container">
        <div class="property-details-container">
            <?php
                include('conn.php');

                if (isset($_GET['propertyID'])) {
                    $propertyID = $_GET['propertyID'];

                    // Prepare the SQL statement
                    $sql = "SELECT title, price, description, location, ownerID, listingDate, state, imageURL FROM property WHERE propertyID = ?";

                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        // Bind the variables to the prepared statement
                        mysqli_stmt_bind_param($stmt, "i", $propertyID);

                        // Execute the prepared statement
                        mysqli_stmt_execute($stmt);

                        // Bind the result variables
                        mysqli_stmt_bind_result($stmt, $title, $price, $description, $location, $ownerID, $listingDate, $state, $imageURL);

                        // Fetch the result
                        if (mysqli_stmt_fetch($stmt)) {
                            echo "<h2>" . htmlspecialchars($title) . "</h2>";
                            echo "<p><strong>Price:</strong> $" . htmlspecialchars($price) . "</p>";
                            echo "<p><strong>Description:</strong> " . htmlspecialchars($description) . "</p>";
                            echo "<p><strong>Location:</strong> " . htmlspecialchars($location) . "</p>";
                            echo "<p><strong>Owner ID:</strong> " . htmlspecialchars($ownerID) . "</p>";
                            echo "<p><strong>Listing Date:</strong> " . htmlspecialchars($listingDate) . "</p>";
                            echo "<p><strong>State:</strong> " . htmlspecialchars($state) . "</p>";
                            if ($imageURL) {
                                echo "<img src='" . htmlspecialchars($imageURL) . "' alt='Property Image'>";
                            }
                        } else {
                            echo "<p>Property not found.</p>";
                        }

                        // Close the statement
                        mysqli_stmt_close($stmt);
                    } else {
                        echo "<p>Error preparing the query: " . mysqli_error($conn) . "</p>";
                    }
                } else {
                    echo "<p>No property ID provided.</p>";
                }

                // Close the database connection
                mysqli_close($conn);
            ?>
        </div>
    </div>
</body>
</html>
