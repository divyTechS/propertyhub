<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PropertyHub - User Registration</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="registration-form">
        <h2>You are registered successfully.</h2>
        <?php
            include('conn.php');
            if(isset($_POST['userID'])){
                $userID =$_POST["userID"];
                $name =$_POST["name"];
                $phone =$_POST["phone"];
                $email =$_POST["email"];
                $password =$_POST["password"];
                $regDate =$_POST["regDate"];
                $address =$_POST["address"];
                $sql="INSERT INTO user VALUES ('$userID','$name','$phone','$email','$password','$regDate','$address')";
                mysqli_query($conn,$sql);
                echo "Account is created succesfully.";
                echo "UserID:";
                echo $_POST["userID"];
                echo " ";
                echo "<br>";
                echo "Email:";
                echo $_POST["email"];
                echo " ";
                echo "<br>";
                echo "Password:";
                echo $_POST["password"];
                echo ".";
            }
            else{
                echo "Please enter the UserID.";
            }
        ?>
    </div>
</body>
</html>