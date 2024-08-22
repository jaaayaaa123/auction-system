<?php
require_once '../config/database.php';

class Product {
    private $conn;

    public function __construct() {
        $this->conn = getDbConnection(); 
    }

    //to get product details
    public function getProductDetails() {
        $sql = "SELECT * FROM products WHERE id = 1"; 
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    // to place a bid
    public function placeBid($userId, $amount) {
        $sql = "INSERT INTO bids (user_id, amount, timestamp) VALUES (?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("id", $userId, $amount);

        return $stmt->execute();
    }

    // to get all bids
    public function getAllBids() {
        $sql = "SELECT * FROM bids ORDER BY timestamp DESC";
        $result = $this->conn->query($sql);

        $bids = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bids[] = $row;
            }
        }
        return $bids;
    }
}
?>
