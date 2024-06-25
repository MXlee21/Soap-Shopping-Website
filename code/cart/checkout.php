<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Modal styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black with opacity */
        }
        
        /* Modal content */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 50%; /* Could be more or less, depending on screen size */
            text-align: center;
        }
        
        /* Close button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="checkout-section">
        <h2>Checkout</h2>
        <form id="checkout-form" method="post" action="checkout.php">
            <label for="first-name">First Name:</label>
            <input type="text" id="first-name" name="first-name" required placeholder="Your first name..">

            <label for="last-name">Last Name:</label>
            <input type="text" id="last-name" name="last-name" required placeholder="Your last name..">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required placeholder="Your email..">

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required placeholder="Your phone number..">

            <label for="shipping-address">Shipping Address:</label>
            <input type="text" id="shipping-address" name="shipping-address" required placeholder="Your shipping address..">

            <label for="payment-method">Payment Method:</label>
            <select id="payment-method" name="payment-method" required >
                <option value="credit-card">Credit Card</option>
                <option value="touch-n-go">Touch N Go eWallet</option>
                <option value="boost">Boost Wallet</option>
                <option value="cash-on-delivery">Cash On Delivery</option>
            </select>

            <button type="submit" class="checkout-btn">Place Order</button>
        </form>
    </div>

    <!-- Modal for success message -->
    <div id="success-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Your order has been placed successfully!</h3>
        </div>
    </div>

    <script>
        // Get the modal element
        var modal = document.getElementById("success-modal");

        // Get the button that closes the modal
        var closeButton = document.getElementsByClassName("close")[0];

        // Function to handle form submission
        document.getElementById("checkout-form").addEventListener("submit", function(event) {
            // Prevent default form submission
            event.preventDefault();

            // Show the modal
            modal.style.display = "block";
        });

        // Close the modal when the close button is clicked
        closeButton.onclick = function() {
            modal.style.display = "none";
        }

        // Close the modal when the user clicks outside of it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
