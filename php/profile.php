<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        /* Global Reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* Body Styling */
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #4a0dcb, #1854fc);
            color: #6a11cb;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding: 0;
        }

        /* Navbar Styling */
        nav {
            width: 100%;
            background: rgba(255, 255, 255, 0.35);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        nav img {
            height: 40px;
            width: auto;
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            margin-left: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: #6a11cb;
        }

        /* Profile Container */
        .profile-container {
            width: 90%;
            max-width: 500px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            padding: 40px;
            margin-top: 20px;
            text-align: center;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .profile-container h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #4a0dcb;
        }

        .profile-container p {
            margin: 10px 0;
            font-size: 1.1em;
            color: #333;
        }

        /* Buttons */
        .profile-container a {
            display: inline-block;
            margin: 15px 10px;
            padding: 12px 20px;
            background: linear-gradient(90deg, #6a11cb, #2575fc);
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            border-radius: 25px;
            transition: transform 0.2s ease, box-shadow 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .profile-container a:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .profile-container a:active {
            transform: translateY(0);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        /* Responsive Design */
        @media screen and (max-width: 500px) {
            .profile-container {
                padding: 20px;
            }

            .profile-container h1 {
                font-size: 2em;
            }

            .profile-container p {
                font-size: 1em;
            }

            .profile-container a {
                padding: 10px 15px;
                font-size: 0.9em;
            }

            nav ul li {
                margin-left: 10px;
            }

            nav ul li a {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav>
        <img src="../images/logo.jpeg" alt="logo">
        <ul>
            <li><a href="../html/index.html">Home</a></li>
            <li><a href="../html/about_us.html">About</a></li>
            <li><a href="../html/contact.html">Contact</a></li>
            <li><a href="../html/admin.html">Admin</a></li>
        </ul>
    </nav>

    <?php
    include('conn.php');

    $userid = $_POST['email'];
    $passwd = $_POST['password'];
    
    // Query to fetch user details
    $sql = "SELECT * FROM user WHERE email = '$userid' AND password = '$passwd'";
    $res = mysqli_query($conn, $sql);

    $user_name = '';
    $user_id = '';
    $phone = '';
    $email = '';
    $regDate = '';
    $address = '';

    if ($result = mysqli_fetch_assoc($res)) {
        $user_name = $result['name'];
        $user_id = $result['userID'];
        $phone = $result['phone'];
        $email = $result['email'];
        $regDate = $result['regDate'];
        $address = $result['address'];
    } else {
        echo "No user found.";
        exit();
    }

    // Fetch properties owned by the user
    $properties_sql = "SELECT * FROM property WHERE ownerID = '$user_id'";
    $properties_res = mysqli_query($conn, $properties_sql);

    // Fetch sales transactions of the user
    $sales_sql = "SELECT * FROM salestransactions WHERE sellerID = '$user_id'";
    $sales_res = mysqli_query($conn, $sales_sql);

    // Fetch rental transactions of the user
    $rental_sql = "SELECT * FROM rentaltransactions WHERE landlordID = '$user_id'";
    $rental_res = mysqli_query($conn, $rental_sql);

    // Fetch tenancies (either as tenant or landlord)
    $tenancy_sql_as_tenant = "SELECT * FROM tenancies WHERE tenantID = '$user_id'";
    $tenancy_sql_as_landlord = "SELECT * FROM tenancies WHERE landlordID = '$user_id'";
    
    $tenancy_res_as_tenant = mysqli_query($conn, $tenancy_sql_as_tenant);
    $tenancy_res_as_landlord = mysqli_query($conn, $tenancy_sql_as_landlord);
?>

<div class="profile-container">
    <h1>Welcome, <?php echo $user_name; ?>!</h1>
    <p>Email: <?php echo $email; ?></p>
    <p>UserID: <?php echo $user_id; ?></p>
    <p>Phone: <?php echo $phone; ?></p>
    <p>Registration Date: <?php echo $regDate; ?></p>
    <p>Address: <?php echo $address; ?></p>

    <!-- Displaying Properties -->
    <h2>Your Properties</h2>
    <?php if (mysqli_num_rows($properties_res) > 0) { ?>
        <ul>
        <?php while ($property = mysqli_fetch_assoc($properties_res)) { ?>
            <li>Property ID: <?php echo $property['propertyID']; ?>, Price: <?php echo $property['price']; ?></li>
        <?php } ?>
        </ul>
    <?php } else { echo "<p>No properties found.</p>"; } ?>

    <!-- Displaying Sales Transactions -->
    <h2>Your Sales Transactions</h2>
    <?php if (mysqli_num_rows($sales_res) > 0) { ?>
        <ul>
        <?php while ($transaction = mysqli_fetch_assoc($sales_res)) { ?>
            <li>Transaction ID: <?php echo $transaction['transactionID']; ?>, Property ID: <?php echo $transaction['propertyID']; ?>, Date: <?php echo $transaction['transactionDate']; ?>, Amount: <?php echo $transaction['amount']; ?></li>
        <?php } ?>
        </ul>
    <?php } else { echo "<p>No sales transactions found.</p>"; } ?>

    <!-- Displaying Rental Transactions -->
    <h2>Your Rental Transactions</h2>
    <?php if (mysqli_num_rows($rental_res) > 0) { ?>
        <ul>
        <?php while ($transaction = mysqli_fetch_assoc($rental_res)) { ?>
            <li>Transaction ID: <?php echo $transaction['transactionID']; ?>, Property ID: <?php echo $transaction['propertyID']; ?>, Date: <?php echo $transaction['transactionDate']; ?>, Amount: <?php echo $transaction['amount']; ?></li>
        <?php } ?>
        </ul>
    <?php } else { echo "<p>No rental transactions found.</p>"; } ?>

    <!-- Displaying Tenancies -->
    <h2>Your Tenancies (As Tenant)</h2>
    <?php if (mysqli_num_rows($tenancy_res_as_tenant) > 0) { ?>
        <ul>
        <?php while ($tenancy = mysqli_fetch_assoc($tenancy_res_as_tenant)) { ?>
            <li>Landlord ID: <?php echo $tenancy['landlordID']; ?>, Start Date: <?php echo $tenancy['startDate']; ?>, End Date: <?php echo $tenancy['endDate']; ?>, Rent Amount: <?php echo $tenancy['rentAmount']; ?></li>
        <?php } ?>
        </ul>
    <?php } else { echo "<p>No tenancies found as tenant.</p>"; } ?>

    <h2>Your Tenancies (As Landlord)</h2>
    <?php if (mysqli_num_rows($tenancy_res_as_landlord) > 0) { ?>
        <ul>
        <?php while ($tenancy = mysqli_fetch_assoc($tenancy_res_as_landlord)) { ?>
            <li>Tenant ID: <?php echo $tenancy['tenantID']; ?>, Start Date: <?php echo $tenancy['startDate']; ?>, End Date: <?php echo $tenancy['endDate']; ?>, Rent Amount: <?php echo $tenancy['rentAmount']; ?></li>
        <?php } ?>
        </ul>
    <?php } else { echo "<p>No tenancies found as landlord.</p>"; } ?>

    <a href="../php/properties.php">Explore Properties</a>
    <a href="../html/list.html">List a Property</a>
</div>

    
   
</body>
</html>
