<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require '../app/Product.php';

$product = new Product();
$auctions = $product->getAuctions();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auctions</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Active Auctions</h1>

    <div id="auction-list">
        <?php foreach ($auctions as $auction): ?>
            <div class="auction-item" data-id="<?php echo $auction['id']; ?>">
                <h2><?php echo htmlspecialchars($auction['name']); ?></h2>
                <p>Current Bid: $<span class="current-bid"><?php echo htmlspecialchars($auction['current_bid']); ?></span></p>
                <p>Ends at: <?php echo htmlspecialchars($auction['end_time']); ?></p>
                <?php if ($auction['owner_id'] != $_SESSION['user_id'] && strtotime($auction['end_time']) > time()): ?>
                    <button class="bid-button" onclick="placeBid(<?php echo $auction['id']; ?>)">Place Bid</button>
                <?php else: ?>
                    <p class="closed">Auction Closed</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="script.js"></script>
</body>
</html>
