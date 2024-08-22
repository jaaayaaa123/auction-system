<?php
require '../app/Product.php';
require '../app/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $amount = $_POST['amount'];
    $user_id = $_SESSION['user_id'] ?? null;

    if ($user_id) {
        $product = new Product();
        $product_id = 1;
        $product->placeBid($product_id, $user_id, $amount);
        $message = "Bid placed successfully!";
    } else {
        $message = "You must be logged in to place a bid.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Bids</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
        }
        input[type="number"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            margin: 10px 0;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Place a Bid</h1>
    </div>
    <div class="container">
        <?php if (isset($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <h2>Current Product</h2>
        <p>Product details here...</p>
        <form action="place_bids.php" method="POST">
            <label for="amount">Bid Amount:</label>
            <input type="number" name="amount" id="amount" required>
            <button type="submit">Place Bid</button>
        </form>
        <a href="index.php">Back to Home</a>
    </div>
</body>
</html>
