<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not authenticated']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = intval($_POST['product_id']);
    $bidAmount = floatval($_POST['bid_amount']);
    $userId = $_SESSION['user_id'];

    try {
       
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        
        $stmt = $conn->prepare("SELECT end_time, current_highest_bid FROM products WHERE id = :product_id");
        $stmt->execute(['product_id' => $productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            echo json_encode(['status' => 'error', 'message' => 'Product not found']);
            exit;
        }

        $currentDateTime = new DateTime();
        $auctionEndTime = new DateTime($product['end_time']);

        if ($currentDateTime >= $auctionEndTime) {
            echo json_encode(['status' => 'error', 'message' => 'Auction has ended']);
            exit;
        }

        if ($bidAmount <= $product['current_highest_bid']) {
            echo json_encode(['status' => 'error', 'message' => 'Bid must be higher than the current highest bid']);
            exit;
        }

       
        $stmt = $conn->prepare("INSERT INTO bids (product_id, user_id, bid_amount, bid_time) VALUES (:product_id, :user_id, :bid_amount, NOW())");
        $stmt->execute([
            'product_id' => $productId,
            'user_id' => $userId,
            'bid_amount' => $bidAmount
        ]);

       
        $stmt = $conn->prepare("UPDATE products SET current_highest_bid = :bid_amount WHERE id = :product_id");
        $stmt->execute([
            'bid_amount' => $bidAmount,
            'product_id' => $productId
        ]);

       
        $responseData = [
            'status' => 'success',
            'product_id' => $productId,
            'bid_amount' => $bidAmount,
            'user_id' => $userId,
            'bid_time' => date('Y-m-d H:i:s')
        ];

       
        $wsUrl = 'ws://localhost:8080';
        $wsData = json_encode($responseData);

        
        $fp = fsockopen("localhost", 8080, $errno, $errstr, 30);
        if ($fp) {
            fwrite($fp, $wsData);
            fclose($fp);
        }

       
        echo json_encode($responseData);

    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
