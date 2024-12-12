<?php
// Include the database connection
include('conn.php');

// Ensure all necessary variables are set
if (isset($_POST['propertyID'], $_POST['price'], $_POST['landlordID'], $_POST['startDate'], $_POST['endDate'])) {
    $propertyID = $_POST['propertyID'];
    $price = $_POST['price'];
    $tenantID = ; // Replace with dynamic user session ID for logged-in tenant
    $landlordID = $_POST['landlordID'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    // Step 1: Update property status to 'rented'
    $updateQuery = "UPDATE property SET state = 'rented' WHERE propertyID = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $propertyID);
    $stmt->execute();

    // Step 2: Insert the tenancy record into the Tenancies table
    $tenancyQuery = "INSERT INTO Tenancies (propertyID, tenantID, landlordID, startDate, endDate, rentAmount) 
                     VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($tenancyQuery);
    $stmt->bind_param("iiissi", $propertyID, $tenantID, $landlordID, $startDate, $endDate, $price);
    $stmt->execute();

    // Step 3: Insert rental transaction record (for the first payment)
    $transactionQuery = "INSERT INTO rentalTransactions (propertyID, tenantID, landlordID, transactionDate, amount) 
                         VALUES (?, ?, ?, NOW(), ?)";
    $stmt = $conn->prepare($transactionQuery);
    $stmt->bind_param("iiis", $propertyID, $tenantID, $landlordID, $price);
    $stmt->execute();

    // Step 4: Redirect to a confirmation page (or show a success message)
    echo "Payment successful! The property has been rented.";
} else {
    // Error: Missing form data
    echo "Error: Missing form data.";
}
?>
