<?php
    #create variables with server details on
    $servername="localhost";
    $username="root";
    $password="PoliteDisaster45";
    #create a new database called CocoaRunners
    $conn= new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql="CREATE DATABASE IF NOT EXISTS CocoaRunners";
    $conn->exec($sql);
    $sql="USE CocoaRunners";
    $conn->exec($sql);
    echo("DB created successfully<br>");

    #create users table
    $stmt=$conn->prepare("DROP TABLE IF EXISTS tblusers;
    CREATE TABLE tblusers
    (UserID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(50) NOT NULL,
    Password VARCHAR(200) NOT NULL,
    Surname VARCHAR(20),
    Forename VARCHAR(20),
    Postcode VARCHAR(7),
    Address VARCHAR(20),
    PhoneNo INT(11),
    CardNo INT(16),
    Role TINYINT(0)
    );
    ");
    $stmt->execute();
    echo("tblusers created<br>");

    #create item table
    $stmt=$conn->prepare("DROP TABLE IF EXISTS tblitem;
    CREATE TABLE tblitem
    (ItemID INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ItemName VARCHAR(20) NOT NULL,
    ItemCategory VARCHAR(20) NOT NULL,
    ItemAllergens VARCHAR(100) NOT NULL,
    ItemDescription VARCHAR(200),
    ItemImage VARCHAR(100),
    ItemPrice DECIMAL(5,2) NOT NULL,
    ItemStock INT(4) NOT NULL
    );
    ");
    $stmt->execute();
    echo("tblitem created<br>");

    #create order table
    $stmt=$conn->prepare("DROP TABLE IF EXISTS tblorder;
    CREATE TABLE tblorder
    (OrderID INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    UserID INT(4) NOT NULL,
    OrderStatus  ENUM('PaymentMade', 'Shipped', 'Delivered') DEFAULT PaymentMade,
    Orderdate DATETIME,
    Method ENUM('Delivery', 'Collection') NOT NULL,
    CONSTRAINT fk_User
    FOREIGN KEY (UserID)
    REFERENCES tblusers(UserID)
    );
    ");
    $stmt->execute();
    echo("tblorder created<br>");

    #create review table
    $stmt=$conn->prepare("DROP TABLE IF EXISTS tblreview;
    CREATE TABLE tblreview
    (ReviewID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    UserID INT(4) NOT NULL,
    ItemID INT(5) NOT NULL,
    Stars INT(1) NOT NULL CHECK (Stars >= 1 AND Stars <= 5),
    ReviewText VARCHAR(200),
    CONSTRAINT fk_User
    FOREIGN KEY (UserID)
    REFERENCES tblusers(UserID),
    CONSTRAINT fk_Item
    FOREIGN KEY (ItemID)
    REFERENCES tblitem(ItemID)
    );
    ");
    $stmt->execute();
    echo("tblreview created<br>");

    #create basket table
    $stmt=$conn->prepare("DROP TABLE IF EXISTS tblbasket;
    CREATE TABLE tblbasket
    (OrderID INT(6) NOT NULL,
    ItemID INT(5) NOT NULL,
    Quantity INT(4) DEFAULT 1 CHECK (Quantity >= 1),
    PRIMARY KEY (OrderID, ItemID)
    );
    ");
    $stmt->execute();
    echo("tblbasket created<br>");

    #create wishlist table
    $stmt=$conn->prepare("DROP TABLE IF EXISTS tblwishlist;
    CREATE TABLE tblwishlist
    (OrderID INT(6) NOT NULL,
    ItemID INT(5) NOT NULL,
    PRIMARY KEY (OrderID, ItemID)
    );
    ");
    $stmt->execute();
    echo("tblwishlist created<br>");
?>

