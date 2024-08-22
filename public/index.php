<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auction System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }
        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 20px;
            width: 250px;
            text-align: center;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card h2 {
            margin: 0 0 10px;
            font-size: 1.5em;
        }
        .card a {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            color: white;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 4px;
        }
        .card a:hover {
            background-color: #0056b3;
        }
        .card img {
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome to the Auction System</h1>
    </div>
    <div class="container">
        
        <div class="card">
            <h2>Register</h2>
            <p>Sign up to start bidding and manage your account.</p>
            <a href="register.php">Register</a>
        </div>
        
        <div class="card">
            <h2>Admin</h2>
            <p>Access admin controls to monitor and manage auctions.</p>
            <a href="admin.php">Admin Panel</a>
        </div>
        
        <div class="card">
            <h2>Place Bids</h2>
            <p>View and place bids on ongoing auctions.</p>
            <a href="place_bids.php">Place Bids</a>
        </div>
       
        <div class="card">
            <h2>Real-Time Updates</h2>
            <p>View live updates on bid status and auction details.</p>
            <a href="real_time_updates.php">View Updates</a>
        </div>

        <div class="message">
                <p>or simply, <a href="login.php">LOGIN..</a> to access auction features.</p>
            </div>

    </div>
</body>
</html>
