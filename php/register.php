<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PropertyHub - User Registration</title>
    <style>
        /* General reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }

        /* Centering the registration form */
        .registration-form {
            width: 90%;
            max-width: 500px;
            padding: 30px;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            text-align: center;
            animation: fadeIn 1s ease-in-out;
            color: #333;
        }

        /* Fade-in animation */
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

        /* Heading styles */
        .registration-form h2 {
            font-size: 28px;
            font-weight: 600;
            color: #2575fc;
            margin-bottom: 20px;
            border-bottom: 2px solid #6a11cb;
            display: inline-block;
            padding-bottom: 5px;
        }

        /* Styling registration details */
        .registration-form p {
            font-size: 16px;
            line-height: 1.8;
            margin: 10px 0;
            color: #555;
        }

        /* Highlight key details */
        .registration-form span {
            font-weight: bold;
            color: #2575fc;
        }

        /* Interactive buttons and links */
        a, button {
            display: inline-block;
            background: #6a11cb;
            color: #fff;
            padding: 12px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        a:hover, button:hover {
            background: #2575fc;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }

        /* Divider line */
        .divider {
            margin: 20px 0;
            border-bottom: 1px solid #ddd;
        }

        /* Responsive adjustments */
        @media screen and (max-width: 600px) {
            .registration-form {
                padding: 20px;
            }

            .registration-form h2 {
                font-size: 24px;
            }

            .registration-form p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="registration-form">
        <h2>You are registered successfully.</h2>
        <div class="divider"></div>
        <?php
            include('conn.php');

            if (isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['address'])) {
                
                $name = $_POST['name'];
                $phone = $_POST['phone'];
                $email = $_POST['email'];
                $password = $_POST['password']; 
                $address = $_POST['address'];

                $regDate = date('Y-m-d');

                $sql = "INSERT INTO user (name, phone, email, password, regDate, address) VALUES (?, ?, ?, ?, ?, ?)";

                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, 'ssssss', $name, $phone, $email, $password , $regDate, $address);

                    if (mysqli_stmt_execute($stmt)) {
                        echo "<p><span>Name:</span> " . htmlspecialchars($name) . "</p>";
                        echo "<p><span>Email:</span> " . htmlspecialchars($email) . "</p>";
                        echo "<p><span>Phone:</span> " . htmlspecialchars($phone) . "</p>";
                        echo "<p><span>Address:</span> " . htmlspecialchars($address) . "</p>";
                        echo "<p><span>Registration Date:</span> " . $regDate . "</p>";
                        echo "<a href='../html/login.html'>Login</a>";
                        echo "<a href='../html/index.html' style='margin-left: 10px;'> Home</a>";
                    } else {
                        echo "<p>Error: Could not execute the query.</p>";
                    }

                    mysqli_stmt_close($stmt);
                } else {
                    echo "<p>Error: Could not prepare the query.</p>";
                }
            } else {
                echo "<h2>Please fill in all required fields.</h2>";
            }
        ?>
    </div>
</body>
</html>