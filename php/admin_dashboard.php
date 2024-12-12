<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
        }

        h1 {
            font-size: 3em;
            font-weight: 600;
            color: #fff;
            margin-bottom: 20px;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 1200px;
            text-align: center;
            margin-top: 30px;
        }

        .cards-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .card {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            flex: 1 1 calc(33% - 20px);
            min-width: 250px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card h3 {
            font-size: 2em;
            color: #333;
            margin: 0;
        }

        .card p {
            font-size: 1.2em;
            color: #2575fc;
            font-weight: bold;
            margin-top: 10px;
        }

        .card .icon {
            font-size: 2em;
            color: #6a11cb;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #6a11cb;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            color: #6a11cb;
            text-decoration: none;
            font-weight: 600;
        }

        a:hover {
            text-decoration: underline;
        }

        .logout {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            border-radius: 25px;
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .logout:hover {
            background-color: #c82333;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .logout:active {
            background-color: #bd2130;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .cards-container {
                flex-direction: column;
                align-items: center;
            }

            .card {
                flex: 1 1 100%;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <div class="container">
        <div class="cards-container">
            <!-- Total Users Card -->
            <div class="card">
                <div class="icon">👤</div>
                <h3>Total Users</h3>
                <?php
                    include('conn.php');
                    $sql1 = "SELECT count(*) AS total_users FROM user";
                    $total_user_res = mysqli_query($conn, $sql1);
                    $total_user = mysqli_fetch_assoc($total_user_res);
                    echo '<p>' . $total_user['total_users'] . '</p>';
                ?>
            </div>
            
            <!-- Total Properties Card -->
            <div class="card">
                <div class="icon">🏠</div>
                <h3>Total Properties</h3>
                <?php
                    $sql2 = "SELECT count(*) AS total_prop FROM property";
                    $total_prop_res = mysqli_query($conn, $sql2);
                    $total_prop = mysqli_fetch_assoc($total_prop_res);
                    echo '<p>' . $total_prop['total_prop'] . '</p>';
                ?>
            </div>

            <!-- Total Properties Sold Card -->
            <div class="card">
                <div class="icon">💸</div>
                <h3>Properties Sold</h3>
                <?php
                    $sql3 = "SELECT count(*) AS total_sales FROM property WHERE state='sold'";
                    $total_sales_res = mysqli_query($conn, $sql3);
                    $total_sales = mysqli_fetch_assoc($total_sales_res);
                    echo '<p>' . $total_sales['total_sales'] . '</p>';
                ?>
            </div>

            <!-- Total Properties Rented Card -->
            <div class="card">
                <div class="icon">🏘️</div>
                <h3>Properties Rented</h3>
                <?php
                    $sql4 = "SELECT count(*) AS total_rental FROM property WHERE state='rented'";
                    $total_rental_res = mysqli_query($conn, $sql4);
                    $total_rental = mysqli_fetch_assoc($total_rental_res);
                    echo '<p>' . $total_rental['total_rental'] . '</p>';
                ?>
            </div>
        </div>

        <!-- Registered Users Table -->
        <h2>Registered Users</h2>
        <?php
            $sql = "SELECT userID, email FROM user";
            $res = mysqli_query($conn, $sql);

            echo '<table><tr><th>UserID</th><th>Email</th><th>Details</th></tr>';
            while ($result = mysqli_fetch_assoc($res)) {
                echo '<tr><td>' . $result['userID'] . '</td><td>' . $result['email'] . '</td><td><a href="user_details.php?uname=' . $result['userID'] . '">View Details</a></td></tr>';
            }
            echo '</table>';
        ?>

        <!-- Properties Table -->
        <h2>Registered Properties</h2>
        <?php
            $sql5 = "SELECT propertyID, title, ownerID, price FROM property";
            $res = mysqli_query($conn, $sql5);

            echo '<table><tr><th>PropertyID</th><th>Title</th><th>Owner ID</th><th>Price</th><th>Details</th></tr>';
            while ($result = mysqli_fetch_assoc($res)) {
                echo '<tr>
                        <td>' . $result['propertyID'] . '</td>
                        <td>' . $result['title'] . '</td>
                        <td>' . $result['ownerID'] . '</td>
                        <td>' . $result['price'] . '</td>
                        <td><a href="property_details.php?propertyID=' . $result['propertyID'] . '">View Details</a></td>
                      </tr>';
            }
            echo '</table>';
            
            $sql5 = "SELECT propertyID, title, ownerID, price FROM property";
            $res = mysqli_query($conn, $sql5);
            
            echo '<table><tr><th>PropertyID</th><th>Title</th><th>Owner ID</th><th>Price</th><th>Details</th></tr>';
            
            while ($result = mysqli_fetch_assoc($res)) {
                echo '<tr>
                        <td>' . $result['propertyID'] . '</td>
                        <td>' . $result['title'] . '</td>
                        <td>' . $result['ownerID'] . '</td>
                        <td>' . $result['price'] . '</td>
                        <td><a href="property_details.php?propertyID=' . $result['propertyID'] . '">View Details</a></td>
                      </tr>';
            }
            echo '</table>';
            echo 'Bought  Transactions';
            
            $sql6 = "SELECT transactionID, propertyID, amount FROM salestransactions";
            $res6 = mysqli_query($conn, $sql6);
            echo '<table><tr><th>TransactionID</th><th>PropertyID</th><th>Amount</th><th>Details</th></tr>';

            while ($result = mysqli_fetch_assoc($res6)) {
                echo '<tr>
                        <td>' . $result['transactionID'] . '</td>
                        <td>' . $result['propertyID'] . '</td>
                        <td>' . $result['amount'] . '</td>
                        <td><a href="transaction_details.php?transactionID=' . $result['transactionID'] . '">View Details</a></td>
                      </tr>';
            }
            echo '</table>';

            echo 'Rental  Transactions';
            $sql7 = "SELECT transactionID, propertyID, amount FROM rentaltransactions";
            $res7 = mysqli_query($conn, $sql7);

            echo '<table><tr><th>TransactionID</th><th>PropertyID</th><th>Amount</th><th>Details</th></tr>';

            while ($result = mysqli_fetch_assoc($res7)) {
                echo '<tr>
                        <td>' . $result['transactionID'] . '</td>
                        <td>' . $result['propertyID'] . '</td>
                        <td>' . $result['amount'] . '</td>
                        <td><a href="transaction_details.php?transactionID=' . $result['transactionID'] . '">View Details</a></td>
                      </tr>';
            }
            echo '</table>';

        ?>

        <a href="../html/index.html" class="logout">Logout</a>
    </div>
</body>
</html>
