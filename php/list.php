<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PropertyHub - List Property</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script>
        // This script will redirect after 3 seconds
        setTimeout(function() {
            window.location.href = "properties.php"; // Change to your desired redirect page
        }, 3000); // Redirect after 3 seconds
    </script>
</head>
<body>
    <div class="registration-form">
        <h2>List Your Property</h2>
        <?php
            include('conn.php');

            if (isset($_POST['title']) && isset($_POST['price']) && isset($_POST['description']) && isset($_POST['location']) && isset($_POST['ownerID']) && isset($_POST['state']) && isset($_POST['password'])) {
                $title = $_POST["title"];
                $price = $_POST["price"];
                $description = $_POST["description"];
                $location = $_POST["location"];
                $ownerID = $_POST["ownerID"];
                $listingDate = date('Y-m-d');
                $state = $_POST["state"];
                $password = $_POST["password"];
                $imageURL = '';

                // Handle file upload
                if (isset($_FILES['imageURL']) && $_FILES['imageURL']['error'] == UPLOAD_ERR_OK) {
                    $target_dir = "../uploads/";
                    $target_file = $target_dir . basename($_FILES["imageURL"]["name"]);
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    // Check if image file is a actual image or fake image
                    $check = getimagesize($_FILES["imageURL"]["tmp_name"]);
                    if ($check !== false) {
                        if (move_uploaded_file($_FILES["imageURL"]["tmp_name"], $target_file)) {
                            $imageURL = $target_file;
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                            exit();
                        }
                    } else {
                        echo "File is not an image.";
                        exit();
                    }
                }

                $sql = "INSERT INTO property (title, price, description, location, ownerID, listingDate, state, imageURL) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "sdssssss", $title, $price, $description, $location, $ownerID, $listingDate, $state, $imageURL);

                    if (mysqli_stmt_execute($stmt)) {
                        // Success message displayed on the page before redirection
                        echo "<p>Property is registered successfully! Redirecting to Properties page.</p>";
                    } else {
                        echo "Error registering the property.";
                    }

                    mysqli_stmt_close($stmt);
                } else {
                    echo "Error preparing the query.";
                }
            } else {
                echo "Please fill in all required fields.";
            }

            mysqli_close($conn);
        ?>
    </div>
</body>
</html>
