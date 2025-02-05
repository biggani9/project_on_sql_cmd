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

// Query to get the list of databases
$sql = "SHOW DATABASES";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .buttons {
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 8px 15px;
            font-size: 14px;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-use {
            background-color: #4CAF50;
        }
        .btn-use:hover {
            background-color: #45a049;
        }
        .btn-drop {
            background-color: #f44336;
        }
        .btn-drop:hover {
            background-color: #e53935;
        }
        .btn-back {
            background-color: #008CBA;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
        .btn-back:hover {
            background-color: #007bb5;
        }
    </style>
</head>
<body>
    <h3>List of Databases</h3>
    <ul>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $databaseName = $row['Database'];
                echo '<li>';
                echo $databaseName;
                echo '<div class="buttons">';
                // USE button
                echo '<a href="use_database.php?database_name=' . urlencode($databaseName) . '" class="btn btn-use">USE</a>';
                // DROP button
                echo '<a href="drop_database.php?database_name=' . urlencode($databaseName) . '" class="btn btn-drop">DROP</a>';
                echo '</div>';
                echo '</li>';
            }
        } else {
            echo "<p>No databases found.</p>";
        }
        $conn->close();
        ?>
    </ul>

    <!-- BACK button -->
    <a href="menu.php" class="btn-back">BACK</a>
</body>
</html>
