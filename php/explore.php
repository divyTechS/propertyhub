<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Properties</title>
    <link rel="stylesheet" href="../css/explore.css">
</head>
<body>
    <div class="container">
        <h1>Available Properties</h1>
        <?php
            include('conn.php');
            $sql = "SELECT * FROM property";
            $res = mysqli_query($conn, $sql);

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
                echo '</div>';
                echo '</div>';
            }
        ?>
    </div>
</body>
</html>