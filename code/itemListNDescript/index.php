<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="ProductList.css">
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

        <h1 id="directory"><a id="home" href="home.php">Home&nbsp;/</a>&nbsp;Handmade Soap</h1>


        <form id="search">
            <input id="searchBox" name="searchItem" type="text" placeholder="Aleppo Soap" onkeyup="search()">
        </form>

        <button id="cart-button"><a href="/WebAss/cart/index.php"><i class="fas fa-shopping-bag"></i></a></button>
    </div>

    <div id="productList">

    </div>

    <script>
        var soapProducts;

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



        $sql = "SELECT * FROM Product";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                $product = array(
                    'id' => $row['productID'],
                    'name' => $row['NAME'],
                    'quantity' => $row['quantity'],
                    'price' => $row['price'],
                    'imgSrc' => $row['imgLink']
                );
                $products[] = $product;
            }

            // convert PHP -> JSON
            $products_json = json_encode($products);
        } else {
            echo "no result";
        }

        $conn->close();
        ?>

        var soapProducts = <?php echo $products_json; ?>; //get product list from php

        // diplay product
        function populateProductList(products) {
            var productList = document.getElementById("productList");
            productList.innerHTML = ""; // Clear previous products

            products.forEach(function(soap) {
                var productBox = document.createElement("div");
                productBox.classList.add("productBox");

                var productLink = document.createElement("a");
                productLink.href = "Product.php?id=" + soap.id;

                var productPhoto = document.createElement("div");
                productPhoto.classList.add("productPhoto");
                var img = document.createElement("img");
                img.src = "img/" + soap.imgSrc;
                img.alt = soap.name;
                productLink.appendChild(img);
                productPhoto.appendChild(productLink);

                var productLink2 = document.createElement("a");
                productLink2.href = "Product.php?id=" + soap.id;
                productLink2.style.textDecoration = "none";

                var name = document.createElement("h2");
                name.classList.add("name")
                name.textContent = soap.name;
                productLink2.appendChild(name);

                var price = document.createElement("p");
                price.textContent = "RM" + soap.price;

                var addToCartButton = document.createElement("button");
                addToCartButton.classList.add("addToCart");
                addToCartButton.textContent = "ADD TO CART";

                // Add click event listener to the button
                addToCartButton.addEventListener("click", function() {

                    // Create an object to send as JSON data
                    const data = {
                        productID: soap.id,
                        quantity: 1,
                    };
                    console.log(data.productID);

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

                productBox.appendChild(productPhoto);
                productBox.appendChild(productLink2);
                productBox.appendChild(price);
                productBox.appendChild(addToCartButton);

                productList.appendChild(productBox);
            });
        }

        //loads product list
        populateProductList(soapProducts);

        //search product with key word
        function search() {
            var searchInput = document.getElementById("searchBox").value.toLowerCase();

            // create filtered array
            var filteredProducts = soapProducts.filter(function(soap) {
                return soap.name.toLowerCase().includes(searchInput);
            });

            //display filltered arry
            populateProductList(filteredProducts);
        }

        //listen for keyup in search box
        document.getElementById("searchBox").addEventListener("keyup", search);
    </script>

</body>

</html>