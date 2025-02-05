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
    <title>Database: <?php echo htmlspecialchars($databaseName); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color:rgb(192, 228, 236);
            color: #343a40;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        h3 {
            margin-bottom: 20px;
            font-size: 1.8rem;
            color: #495057;
        }
        .buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 20px;
            align-items: center;
        }
        .btn {
            padding: 12px 25px;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-align: center;
            width: 400px;
        }
        .btn-list-tables {
            background-color: #007bff;
        }
        .btn-list-tables:hover {
            background-color: rgb(247, 41, 5);
        }
        .btn-create-table {
            background-color: #28a745;
        }
        .btn-create-table:hover {
            background-color: rgb(247, 41, 5);
        }
        .btn-query {
            background-color: #ffc107;
            color: #343a40;
        }
        .btn-query:hover {
            background-color:rgb(247, 41, 5);
        }
        .back-link {
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .back-link:hover {
            background-color:rgb(247, 41, 5);
        }
        footer {
            margin-top: 30px;
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <h3>Database: <?php echo htmlspecialchars($databaseName); ?></h3>
    
    <div class="buttons">
        <!-- Create a Table Button -->
        <a href="create_table.php?database_name=<?php echo urlencode($databaseName); ?>" class="btn btn-create-table">Create a Table</a>

        <!-- List of Tables Button -->
        <a href="list_tables.php?database_name=<?php echo urlencode($databaseName); ?>" class="btn btn-list-tables">List of Tables</a>
        
        <!-- Query Button -->
        <a href="querys.php?database_name=<?php echo urlencode($databaseName); ?>" class="btn btn-query">Query</a>
    </div>
    
    <a href="list_of_database.php" class="back-link">Back to Database List</a>

    <footer>
        &copy; <?php echo date('Y'); ?> Jahid Hasan. All Rights Reserved.
    </footer>
</body>
</html>
