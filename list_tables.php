<?php
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

// Check if the drop_table action is triggered
if (isset($_GET['action']) && $_GET['action'] === 'drop' && isset($_GET['table_name'])) {
    $tableName = $_GET['table_name'];
    $sql = "DROP TABLE `" . $conn->real_escape_string($tableName) . "`";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Table dropped successfully.'); window.location.href='?database_name=" . urlencode($databaseName) . "';</script>";
        exit;
    } else {
        echo "<script>alert('Failed to drop table: " . $conn->error . "'); window.location.href='?database_name=" . urlencode($databaseName) . "';</script>";
        exit;
    }
}

// Get the list of tables
$sql = "SHOW TABLES";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tables in <?php echo htmlspecialchars($databaseName); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(192, 228, 236);
            margin: 20px;
        }
        h3 {
            color: #333;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin: 10px 0;
            padding: 10px;
            background-color: rgb(210, 237, 198);
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
            background-color: rgb(247, 41, 5);
        }
        .action-buttons {
            margin-top: 10px;
        }
        .action-buttons a {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            background-color: #007bff;
            border-radius: 3px;
            margin-right: 10px;
        }
        .action-buttons a:hover {
            background-color: rgb(247, 41, 5);
        }
    </style>
</head>
<body>
    <h3>Tables in Database: <?php echo htmlspecialchars($databaseName); ?></h3>
    <?php
    if ($result->num_rows > 0) {
        echo "<ul>";
        while ($row = $result->fetch_array()) {
            $tableName = htmlspecialchars($row[0]);
            echo "<li>" . $tableName . "</li>";
            echo "<div class='action-buttons'>";
            echo "<a href='?database_name=" . urlencode($databaseName) . "&table_name=" . urlencode($tableName) . "&action=drop' onclick='return confirm(\"Are you sure you want to drop this table?\");'>DROP</a>";
            echo "<a href='insert_value.php?database_name=" . urlencode($databaseName) . "&table_name=" . urlencode($tableName) . "'>INSERT VALUE</a>";
            echo "<a href='view_table.php?database_name=" . urlencode($databaseName) . "&table_name=" . urlencode($tableName) . "'>VIEW</a>";
            echo "</div>";
        }
        echo "</ul>";
    } else {
        echo "<p>No tables found in this database.</p>";
    }

    // Close connection
    $conn->close();
    ?>
    <a href="use_database.php?database_name=<?php echo urlencode($databaseName); ?>" class="back-link">Back</a>
</body>
</html>