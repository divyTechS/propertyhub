<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Properties</title>
    <link rel="stylesheet" href="../css/properties.css">
</head>
<body>
    <!-- Navbar -->
    <nav>
        <img src="../images/logo.jpeg" alt="logo">
        <ul>
            <li><a href="../html/index.html">Home</a></li>
            <li><a href="../html/login.html">Login</a></li>
            <li><a href="../html/register.html">Register</a></li>
            <li><a href="../html/list.html">List Property</a></li>
            <li><a href="../html/about_us.html">About</a></li>
            <li><a href="../html/contact.html">Contact</a></li>
            <li><a href="../html/admin.html">Admin</a></li>
        </ul>
    </nav>

    <!-- Content Container -->
    <div class="container">
        <h1>Available Properties</h1>
        <?php
            include('conn.php');

            // Fetch all properties from the database
            $sql = "SELECT * FROM property";
            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res) > 0) {
                while ($result = mysqli_fetch_assoc($res)) {
                    echo '<div class="property-card">';
                    echo '<div class="property-img">';
                    echo '<img src="' . htmlspecialchars($result['imageURL']) . '" alt="Property Image">';
                    echo '</div>';
                    echo '<div class="property-info">';
                    echo '<h2>' . htmlspecialchars($result['title']) . '</h2>';
                    echo '<p>' . htmlspecialchars($result['description']) . '</p>';
                    echo '<p><strong>Price:</strong> $' . htmlspecialchars($result['price']) . '</p>';
                    echo '<p><strong>Location:</strong> ' . htmlspecialchars($result['location']) . '</p>';
                    echo '<a href="../php/property_details.php?propertyID=' . htmlspecialchars($result['propertyID']) . '">View Details</a>';

                    // Show appropriate button based on the property state
                    if ($result['state'] === 'to let') {
                        echo '<button onclick="location.href=\'../php/rent.php?propertyID=' . htmlspecialchars($result['propertyID']) . '\'">Rent</button>';
                    } elseif ($result['state'] === 'to sell') {
                        echo '<button onclick="location.href=\'../php/buy.php?propertyID=' . htmlspecialchars($result['propertyID']) . '\'">Buy</button>';
                    } else {
                        echo '<p><em>Not available for sale or rent.</em></p>';
                    }

                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No properties available at the moment.</p>';
            }

            // Close the database connection
            mysqli_close($conn);
        ?>
    </div>
</body>
</html>
