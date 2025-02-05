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

// Initialize $databaseName
$databaseName = "";

// Check if the database_name parameter is provided
if (isset($_GET['database_name'])) {
    $databaseName = $_GET['database_name'];
    $conn->select_db($databaseName);  // Select the database
} else {
    die("<p style='color: red;'>No database selected.</p>");
}

// Initialize variables
$message = "";

// Handle form submission for next step
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['table_name']) && isset($_POST['columns']) && isset($_POST['submit_next'])) {
    // Get the table name and number of columns
    $tableName = $_POST['table_name'];
    $columns = $_POST['columns'];
    // Redirect to define_columns.php, passing the required parameters in the URL
    header("Location: define_columns.php?database_name=" . urlencode($databaseName) . "&table_name=" . urlencode($tableName) . "&columns=" . urlencode($columns));
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Table in <?php echo htmlspecialchars($databaseName ? $databaseName : "unknown database"); ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color:rgb(192, 228, 236);
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h3 {
            color: #444;
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: 600;
        }
        input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
        }
        button:hover {
            background-color: rgb(247, 41, 5);
        }
        .success-message {
            color: green;
            font-weight: bold;
            text-align: center;
        }
        .error-message {
            color: red;
            font-weight: bold;
            text-align: center;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            color: white;
            background-color: #6c757d;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-link:hover {
            background-color: rgb(247, 41, 5);
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Create a Table in <?php echo htmlspecialchars($databaseName ? $databaseName : "unknown database"); ?></h3>

        <?php if (!empty($message)): ?>
            <p class="<?php echo strpos($message, 'successfully') !== false ? 'success-message' : 'error-message'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php endif; ?>

        <!-- Step 1: Get Table Name and Number of Columns -->
        <form method="POST">
            <label for="table_name">Table Name:</label>
            <input type="text" id="table_name" name="table_name" placeholder="Enter table name" required>

            <label for="columns">Number of Columns:</label>
            <input type="number" id="columns" name="columns" min="1" placeholder="Enter number of columns" required>

            <button type="submit" name="submit_next">Next</button>
        </form>

        <a href="list_of_database.php" class="back-link">Back to Database List</a>
    </div>
</body>
</html>
