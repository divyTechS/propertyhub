<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PropertyHub - Property Registration</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="registration-form">
        <h2>Property Registration.</h2>
        <?php
            include('conn.php');
            if(isset($_POST['propertyID'])){
                $propertyID =$_POST["propertyID"];
                $title =$_POST["title"];
                $price =$_POST["price"];
                $description =$_POST["description"];
                $location =$_POST["location"];
                $ownerID =$_POST["ownerID"];
                $listingDate =$_POST["listingDate"];
                $state = $_POST["type"];
                $imageURL =$_POST["imageURL"];

                $sql="INSERT INTO property VALUES ('$propertyID','$title','$price','$description','$location','$ownerID','$listingDate','$state','$imageURL',NULL)";

                mysqli_query($conn,$sql);
                echo "Property is registered successfully.";
                echo "Property ID:";
                echo $_POST["propertyID"];
                echo " ";
                echo "<br>";
                echo "Title:";
                echo $_POST["title"];
                echo " ";
                echo "<br>";
                echo "Description:";
                echo $_POST["description"];
                echo " ";
                echo "<br>";
                echo "Location:";
                echo $_POST["location"];
                echo ".";
            }
            else{
                echo "Please enter the Property ID.";
            }
        ?>
    </div>
</body>
</html>