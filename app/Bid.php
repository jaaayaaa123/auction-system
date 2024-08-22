<?php

class Bid {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function placeBid($product_id, $user_id, $amount) {
        $stmt = $this->pdo->prepare("INSERT INTO bids (product_id, user_id, amount) VALUES (:product_id, :user_id, :amount)");
        return $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id, 'amount' => $amount]);
    }

    public function getBidsByProduct($product_id) {
        $stmt = $this->pdo->prepare("SELECT b.*, u.username FROM bids b JOIN users u ON b.user_id = u.id WHERE b.product_id = :product_id ORDER BY b.created_at DESC");
        $stmt->execute(['product_id' => $product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
