<?php
require 'config/database.php'; // Make sure this path is correct

$conn = getDbConnection();

if ($conn) {
    echo "Database connection successful!<br>";

    // Optional: Run a simple query to verify the connection
    $sql = "SHOW TABLES";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "Tables in the database:<br>";
        while ($row = $result->fetch_array()) {
            echo $row[0] . "<br>";
        }
    } else {
        echo "No tables found in the database.";
    }
} else {
    echo "Database connection failed.";
}

$conn->close();
?>
