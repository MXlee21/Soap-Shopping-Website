<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="Product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div id="navigation">
        <nav>
            <ul>
                <li><a href="/WebAss/Homepage/">Home</a></li>
                <li><a href="/WebAss/itemListNDescript/">Products</a></li>
                <li><a href="/WebAss/contactUs/">Contact</a></li>
            </ul>
        </nav>
    </div>

    <div id="directoryBox">

        <h1 id="directory"><a id="home" href="home.php">Home /</a> &nbsp;
            <a href="index.php">Handmade Soap</a>
            &nbsp;/ Product
        </h1>
        <button id="cart-button"><a href="/WebAss/cart/index.php"><i class="fas fa-shopping-bag"></i></a></button>
    </div>

    <div id="product">

    </div>

    <script>
        // Get the URL parameters
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);

        // Get the productID parameter value
        const productID = urlParams.get('id');

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

        // Retrieve product ID
        $productID = $_GET['id'];

        if ($productID !== null) {
            // Prepare and execute SQL query
            $sql = "SELECT * FROM Product WHERE productID = $productID";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                // Fetch product data
                $row = $result->fetch_assoc();
                $id = $row["productID"];
                $name = $row["NAME"];
                $quantity = $row["quantity"];
                $price = $row["price"];
                $description = $row["description"];
                $imgLink = $row["imgLink"];

                // Output product data as JavaScript object
                echo "var productData = { id: $id, name: '$name', quantity: $quantity, price: $price, description: '$description', imgLink: '$imgLink' };";
            } else {
                echo "console.log('Product not found');";
            }
        } else {
            echo "console.log('No product ID specified');";
        }

        $conn->close();
        ?>

        function loadProduct() {
            const soap = {
                name: productData.name,
                quantity: productData.quantity,
                price: productData.price,
                description: productData.description,
                imgSrc: "img/" + productData.imgLink,
            }

            var product = document.getElementById("product");

            var imgSrc = document.createElement("img");
            imgSrc.src = soap.imgSrc;
            imgSrc.alt = soap.name;
            product.appendChild(imgSrc);


            var productInfo = document.createElement("div");
            productInfo.id = "productInfo";

            var name = document.createElement("p");
            name.textContent = soap.name;
            name.id = "name";
            productInfo.appendChild(name);

            var price = document.createElement("p");
            price.textContent = "RM" + soap.price;
            price.id = "price";
            productInfo.appendChild(price);



            // Create quantity counter
            var quantitySelector = document.createElement("div");
            quantitySelector.id = "quantitySelector";

            var decreaseBtn = document.createElement("button");
            decreaseBtn.textContent = "-";
            decreaseBtn.addEventListener("click", function() {
                var currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });

            var quantityInput = document.createElement("input");
            quantityInput.type = "text";
            quantityInput.value = "1";

            var increaseBtn = document.createElement("button");
            increaseBtn.textContent = "+";
            increaseBtn.addEventListener("click", function() {
                var currentValue = parseInt(quantityInput.value);
                quantityInput.value = currentValue + 1;
            });

            var addToCartButton = document.createElement("button");
            addToCartButton.classList.add("addToCart");
            addToCartButton.textContent = "ADD TO CART";

            // Add click event listener to the button
            addToCartButton.addEventListener("click", function() {
                // Extract product ID from the URL
                const urlParams = new URLSearchParams(window.location.search);
                const productID = urlParams.get('id');
                const quantity = parseInt(quantityInput.value);
                console.log(productID);
                console.log(quantity);

                // Create an object to send as JSON data
                const data = {
                    productID: productID,
                    quantity: quantity
                };

                // Send an AJAX request to addToCart.php
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "addToCart.php", true);
                xhr.setRequestHeader("Content-Type", "application/json");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        console.log("Response from server:", xhr.responseText);
                    }
                };
                xhr.send(JSON.stringify(data));



                // Redirect the user to the cart page with the product ID
                window.location.href = "/WebAss/cart/index.php?productID=" + productID;
            });


            // Append elements to quantity counter
            quantitySelector.appendChild(decreaseBtn);
            quantitySelector.appendChild(quantityInput);
            quantitySelector.appendChild(increaseBtn);

            productInfo.appendChild(quantitySelector);
            productInfo.appendChild(addToCartButton);

            product.appendChild(productInfo);
        }

        loadProduct();
    </script>

    <div id="description">

    </div>

    <script>
        function loadDes() {
            let itemDescript = "great soap for sentitive skin........";

            var description = document.getElementById("description");

            var heading = document.createElement("h1");
            heading.textContent = "DESCRIPTION";
            heading.id = "heading";
            description.appendChild(heading);

            var text = document.createElement("p");
            text.textContent = itemDescript;
            text.id = "text";
            description.appendChild(text);
        }

        loadDes();
    </script>



</body>

</html>