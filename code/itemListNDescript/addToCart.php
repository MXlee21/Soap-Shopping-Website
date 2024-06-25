<?php
// Get the JSON data sent from the client
$data = json_decode(file_get_contents("php://input"));

// Extract productID and quantity from the JSON data
$productID = $data->productID;
$quantity = $data->quantity;

// Your database connection code
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "soap";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the productID already exists in the table
$stmt = $conn->prepare("SELECT quantity FROM cart WHERE productID = ?");
$stmt->bind_param("i", $productID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // If productID exists, update the quantity
    $row = $result->fetch_assoc();
    $newQuantity = $row["quantity"] + $quantity;
    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE productID = ?");
    $stmt->bind_param("ii", $newQuantity, $productID);
    $stmt->execute();
    echo "Quantity updated successfully";
} else {
    // If productID doesn't exist, insert a new row
    $stmt = $conn->prepare("INSERT INTO cart (productID, quantity) VALUES (?, ?)");
    $stmt->bind_param("ii", $productID, $quantity);
    $stmt->execute();
    echo "Data inserted successfully";
}

// Close connection
$stmt->close();
$conn->close();
