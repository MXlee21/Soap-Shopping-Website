<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "soap";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if product cancellation request is made
if (isset($_GET['cancel']) && isset($_GET['productID'])) {
    $productID = $_GET['productID'];

    // Update the quantity in the cart to zero
    $sql_update = "UPDATE cart SET quantity = 0 WHERE productID = $productID";
    if ($conn->query($sql_update) === TRUE) {
        // Quantity updated successfully
        // Redirect to the index page
        header("Location: index.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Retrieve product ID from the cart table excluding canceled products
$sql = "SELECT productID FROM cart WHERE quantity > 0"; // Exclude products with quantity zero
$result = $conn->query($sql);

$productTable = ""; // Variable to store the product table HTML
$totalPrice = 0; // Variable to store the total price amount

if ($result && $result->num_rows > 0) {
    // Start table
    $productTable .= "<table border='1'>";
    $productTable .= "<tr><th>Product Name</th><th>Price</th><th>Image</th><th>Quantity</th><th>Subtotal</th><th>Action</th></tr>";

    // Loop through each product ID in the cart table
    while ($row = $result->fetch_assoc()) {
        $productID = $row['productID'];

        // Prepare and execute SQL query to get product details
        $sql_product = "SELECT p.NAME, p.price, p.imgLink, c.quantity 
                        FROM Product p
                        LEFT JOIN cart c ON p.productID = c.productID
                        WHERE p.productID = $productID";
        $result_product = $conn->query($sql_product);

        if ($result_product && $result_product->num_rows > 0) {
            // Fetch product data
            $row_product = $result_product->fetch_assoc();
            $name = $row_product["NAME"];
            $price = $row_product["price"];
            $imgLink = $row_product["imgLink"];
            $quantity = $row_product["quantity"]; // Quantity from the cart table

            // Calculate subtotal
            $subtotal = $price * $quantity;
            $totalPrice += $subtotal; // Add subtotal to total price amount

            // Output product data in table row with cancel button
            $productTable .= "<tr id='product-row-$productID'>"; // Assign unique ID to each row
            $productTable .= "<td>$name</td>";
            $productTable .= "<td>$price</td>";
            $productTable .= "<td><img src='img/$imgLink' alt='$name' style='width: 100px; height: auto;'></td>";
            $productTable .= "<td>$quantity</td>";
            $productTable .= "<td>$subtotal</td>";
            $productTable .= "<td><a href='index.php?cancel=true&productID=$productID' onclick='removeProductRow($productID)'>Cancel</a></td>"; // Cancel button with onclick event
            $productTable .= "</tr>";
        } else {
            $productTable .= "<tr><td colspan='6'>Product with ID $productID not found</td></tr>";
        }
    }

    // End table
    $productTable .= "</table>";

} else {
    $productTable .= "No products in the cart<br>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<nav>
    <ul>
        <li><a href="/WebAss/Homepage/">Home</a></li>
        <li><a href="/WebAss/itemListNDescript/">Products</a></li>
        <li><a href="/WebAss/contactUs/">Contact</a></li>
    </ul>
</nav>
<header>
    <h1>Shopping Cart</h1>
    <a href="/WebAss/itemListNDescript">Continue Shopping</a>
</header>

<!-- Display product table here -->
<div class="product-table">
    <?php echo $productTable; ?>
</div>

<!-- Display total price amount -->
<div style="font-size: 24px; font-weight: bold;">Total Price: <?php echo $totalPrice; ?></div>

<!-- Form for checkout -->
<form id="checkout-form" method="post" action="checkout.php">
    <!-- Your form fields here -->
    <button id="checkoutButton" type="submit">Proceed to Checkout</button>
</form>



<!-- JavaScript to remove product row -->
<script>
    function removeProductRow(productId) {
        var row = document.getElementById('product-row-' + productId);
        if (row) {
            row.parentNode.removeChild(row); // Remove the row from the table
        }
    }
</script>
<footer>
    <p>&copy; 2024 Handmade Soap Malaysia. All rights reserved.</p>
</footer>
</body>
</html>
