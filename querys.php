<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";

// Connect to the MySQL server
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the database_name parameter is provided
if (isset($_GET['database_name'])) {
    $databaseName = $_GET['database_name'];
    $conn->select_db($databaseName);  // Select the database
} else {
    die("<p style='color: red;'>No database selected.</p>");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Query Options</title>
    <style>
        body {
            background-color:rgb(192, 228, 236);
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h3 {
            text-align:center ;
            weight:bold;
            color: #333;
        }
        .buttons {
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }
        .btn {
            text-align: center;
            padding: 10px 15px;
            font-size: 14px;
            color: white;
            text-decoration: none;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color:rgb(247, 41, 5);
        }
        .btn-back {
            text-align: center;
            width: 50%;
            margin-left: 25%;
            background-color: #5a6268;
        }
        .btn-back:hover {
            background-color: rgb(247, 41, 5);
        }
    </style>
</head>
<body>
    <h3>Query Options for Database: <?php echo htmlspecialchars($databaseName); ?></h3>
    <div class="buttons">
        <a href="select_distinct.php?database_name=<?php echo urlencode($databaseName); ?>" class="btn">SELECT DISTINCT</a>
        <a href="alter_table.php?database_name=<?php echo urlencode($databaseName); ?>" class="btn">ALTER TABLE</a>
        <a href="and.php?database_name=<?php echo urlencode($databaseName); ?>" class="btn">AND</a>
        <a href="foreign_key.php?database_name=<?php echo urlencode($databaseName); ?>" class="btn">FOREIGN KEY</a>
        <a href="count.php?database_name=<?php echo urlencode($databaseName); ?>" class="btn">COUNT</a>
        <a href="having.php?database_name=<?php echo urlencode($databaseName); ?>" class="btn">HAVING</a>
        <a href="left_join.php?database_name=<?php echo urlencode($databaseName); ?>" class="btn">LEFT JOIN</a>
        <a href="create_view.php?database_name=<?php echo urlencode($databaseName); ?>" class="btn">CREATE VIEW</a>
        <a href="all.php?database_name=<?php echo urlencode($databaseName); ?>" class="btn">ALL</a>
        
        <!-- Back button -->
        <a href="use_database.php?database_name=<?php echo urlencode($databaseName); ?>" class="btn btn-back">BACK</a>
    </div>
</body>
</html>
