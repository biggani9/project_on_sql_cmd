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

// Check if database_name and query parameters are provided
if (isset($_GET['database_name']) && isset($_GET['query'])) {
    $databaseName = $_GET['database_name'];
    $query = $_GET['query'];

    echo "<h3>Database: " . htmlspecialchars($databaseName) . "</h3>";
    echo "<p>Executing query: <b>" . htmlspecialchars($query) . "</b></p>";

    // Logic for executing or displaying the query can be added here
    echo "<p>Feature under construction.</p>";
} else {
    echo "<p style='color: red;'>Missing required parameters.</p>";
}

$conn->close();
?>
<a href="use_database.php?database_name=<?php echo urlencode($databaseName); ?>">Back</a>
