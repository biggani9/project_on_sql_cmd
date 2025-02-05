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

// Get the list of tables in the selected database
$sql = "SHOW TABLES";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tables in Database: <?php echo htmlspecialchars($databaseName); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h3 {
            color: #333;
        }
        .tables-list {
            list-style-type: none;
            padding: 0;
        }
        .tables-list li {
            margin: 10px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .back-link {
            margin-top: 20px;
            display: inline-block;
            padding: 10px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-link:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <h3>Tables in Database: <?php echo htmlspecialchars($databaseName); ?></h3>

    <?php
    if ($result->num_rows > 0) {
        echo "<ul class='tables-list'>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>" . htmlspecialchars($row['Tables_in_' . $databaseName]) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No tables found in this database.</p>";
    }

    // Close connection
    $conn->close();
    ?>
    
    <a href="list_databases.php" class="back-link">Back to Database List</a>
</body>
</html>
