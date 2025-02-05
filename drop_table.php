<?php
$servername = "localhost";
$username = "root";
$password = "";

// Connect to the MySQL server
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the database and table names from the query parameters
if (isset($_GET['database_name']) && isset($_GET['table_name'])) {
    $databaseName = $_GET['database_name'];
    $tableName = $_GET['table_name'];
    $conn->select_db($databaseName);
    
    // Drop the table
    $sql = "DROP TABLE IF EXISTS $tableName";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Table '$tableName' has been dropped successfully.</p>";
    } else {
        echo "<p>Error dropping table: " . $conn->error . "</p>";
    }
} else {
    echo "<p>No table specified to drop.</p>";
}

$conn->close();
?>
