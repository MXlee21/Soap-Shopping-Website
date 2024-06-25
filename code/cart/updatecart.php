<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the productID is set in the request body
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data["productID"])) {
        // Connect to the database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "soap";
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Assuming cusID is 1 for example purposes
        $cusID = 1;
        $productID = $data["productID"];
        $quantity = 1; // You can set the quantity here or retrieve it from the product data

        // Prepare SQL statement to insert into Cart table
        $sql = "INSERT INTO Cart (cusID, productID, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $cusID, $productID, $quantity);

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            // Return success response
            echo "Product successfully added to cart!";
        } else {
            // Return error response
            echo "Error adding product to cart: " . $conn->error;
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    } else {
        // Return error response if productID is not set
        http_response_code(400);
        echo "Product ID is required!";
    }
} else {
    // Return error response if request method is not POST
    http_response_code(405);
    echo "Method Not Allowed!";
}
?>
