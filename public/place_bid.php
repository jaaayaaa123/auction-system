<?php
session_start();
require '../app/Product.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$auctionId = $data['auction_id'] ?? null;
$userId = $_SESSION['user_id'] ?? null;

if ($auctionId && $userId) {
    $product = new Product();
    $success = $product->placeBid($auctionId, $userId);
    echo json_encode(['success' => $success]);
} else {
    echo json_encode(['success' => false]);
}
?>
