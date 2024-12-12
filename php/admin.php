<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PropertyHub Admin Login</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="login-container">
        <?php
            include('conn.php');
            $username=$_POST['username'];
            $password=$_POST['password'];
            $sql="SELECT * FROM admin WHERE username='$username' and
            password='$password' ";
            $res=mysqli_query($conn,$sql);
            if($result=mysqli_fetch_assoc($res)){ 
                header('Location: ../php/admin_dashboard.php');
            }
            else{
                echo 'You are not the admin.';
            }
        ?>
    </div>
</body>
</html>