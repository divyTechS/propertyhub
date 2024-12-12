<?php
// Include the database connection
include('conn.php');

// Get the property and payment details from the form
$propertyID = $_POST['propertyID'];
$price = $_POST['price'];
$userID = 1; // You can get this from the session if the user is logged in

// Example: Processing the payment (Here you should integrate with a payment gateway like PayPal, Stripe, etc.)
// For simplicity, assume payment is successful
$paymentSuccessful = true;

if ($paymentSuccessful) {
    // Step 1: Update property status to 'sold'
    $updateQuery = "UPDATE property SET state = 'sold' WHERE propertyID = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $propertyID);
    $stmt->execute();

    // Step 2: Insert the sales transaction record
    $transactionQuery = "INSERT INTO salesTransactions (propertyID, buyerID, sellerID, transactionDate, amount) 
                          VALUES (?, ?, (SELECT ownerID FROM property WHERE propertyID = ?), NOW(), ?)";
    $stmt = $conn->prepare($transactionQuery);
    $stmt->bind_param("iiii", $propertyID, $userID, $propertyID, $price);
    $stmt->execute();

    // Step 3: Redirect to a confirmation page (or show a success message)
    echo "Payment successful! The property has been purchased.";
} else {
    // If payment fails, show an error message
    echo "Payment failed. Please try again.";
}
?>
