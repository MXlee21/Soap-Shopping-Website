CREATE DATABASE soap CHARACTER SET utf8 COLLATE utf8_general_ci;

USE soap;

CREATE TABLE Customer(
    cusID INT(11) AUTO_INCREMENT PRIMARY KEY,
    NAME VARCHAR(255),
    address TEXT,
    PASSWORD VARCHAR(255),
    phoneNum VARCHAR(255),
    email VARCHAR(255)
);

CREATE TABLE Cart(
    productID INT(11),
    quantity INT(11),
    PRIMARY KEY(productID)
);

CREATE TABLE Product(
    productID INT(11) AUTO_INCREMENT PRIMARY KEY,
    NAME VARCHAR(255),
    quantity INT(11),
    price DOUBLE,
    description TEXT,
    imgLink VARCHAR(255)
);

CREATE TABLE `Order`(
    orderID INT(11) AUTO_INCREMENT,
    cusID INT(11),
    posted DATETIME,
    PRIMARY KEY(orderID),
    UNIQUE KEY(orderID, cusID)
);

CREATE TABLE OrderProduct(
    orderID INT(11),
    productID INT(11),
    quantity INT(11),
    PRIMARY KEY(orderID),
    UNIQUE KEY(orderID, productID)
);



