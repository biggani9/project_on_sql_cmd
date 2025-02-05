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
} else {
    die("No database or table specified.");
}

// Fetch data from the table
$sql = "SELECT * FROM $tableName";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Table: <?php echo htmlspecialchars($tableName); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h3 {
            margin-bottom: 20px;
            color: #444;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        table th {
            background-color: #007BFF;
            color: #fff;
            text-transform: uppercase;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: rgb(247, 41, 5);
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }
        .back-button:hover {
            background-color: rgb(247, 41, 5);
        }
        footer {
            text-align: center;
            margin-top: 20px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>View Table: <?php echo htmlspecialchars($tableName); ?></h3>
        <table>
            <thead>
                <tr>
                    <?php
                    // Display table columns
                    $fields = $result->fetch_fields();
                    foreach ($fields as $field) {
                        echo "<th>" . htmlspecialchars($field->name) . "</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $cell) {
                        echo "<td>" . htmlspecialchars($cell) . "</td>";
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="list_tables.php?database_name=<?php echo urlencode($databaseName); ?>&table_name=<?php echo urlencode($tableName); ?>" class="back-button">BACK</a>
    </div>
    <footer>
        &copy; <?php echo date('Y'); ?> Jahid Hasan
    </footer>
</body>
</html>
<?php
$conn->close();
?>
