<?php

require_once __DIR__ . '/../config/database.php';
require_once 'User.php';
require_once 'Product.php';
require_once 'Bid.php';

session_start();

$pdo = new PDO('mysql:host=localhost;dbname=auction_system', 'root', 'Dev@2020'); // change credentials according to the sql workbench on your device

$userModel = new User($pdo);
$productModel = new Product($pdo);
$bidModel = new Bid($pdo);

// for registration
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if ($userModel->register($username, $email, $password)) {
        header('Location: login.php');
        exit();
    }
}

// for login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if ($userModel->login($username, $password)) {
        header('Location: auction.php');
        exit();
    }
}

// for admin- new product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_product']) && $_SESSION['role'] == 'admin') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $start_price = $_POST['start_price'];
    
    if ($productModel->createProduct($_SESSION['user_id'], $name, $description, $start_price)) {
        header('Location: admin.php');
        exit();
    }
}

// to place bid
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['place_bid'])) {
    $product_id = $_POST['product_id'];
    $amount = $_POST['amount'];
    
    $highestBid = $productModel->getHighestBid($product_id);

    if ($amount > $highestBid) {
        if ($bidModel->placeBid($product_id, $_SESSION['user_id'], $amount)) {
            header("Location: auction.php?product_id=$product_id");
            exit();
        }
    }
}

// to get bid and auction details
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $product = $productModel->getProductById($product_id);
    $bids = $bidModel->getBidsByProduct($product_id);
}
