<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>
<body>
    <?php
        include('conn.php');

        if (isset($_POST['userID']) && isset($_POST['password'])) {
            $userid = $_POST['userID'];
            $passwd = $_POST['password'];

           
            $sql = "SELECT * FROM user WHERE userID = ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                
                mysqli_stmt_bind_param($stmt, "i", $userid);

                
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                
                if ($row = mysqli_fetch_assoc($result)) {
                    
                    if (password_verify($passwd, $row['password'])) {
                        echo "<h1>Welcome, " . htmlspecialchars($row['name']) . "!</h1>";
                        echo "<p>Email: " . htmlspecialchars($row['email']) . "</p>";
                        echo "<p>Phone: " . htmlspecialchars($row['phone']) . "</p>";
                        echo "<p>Address: " . htmlspecialchars($row['address']) . "</p>";
                    } else {
                        echo "Incorrect password.";
                    }
                } else {
                    echo "No user found.";
                }

                
                mysqli_stmt_close($stmt);
            }
        }
    ?>
</body>
</html>
