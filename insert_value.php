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

// Handle form submission for inserting data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $columns = explode(",", $_POST['columns']); // Split column names into an array
    $values = $_POST['values']; // Get the array of values from the form

    // Escape values to prevent SQL injection
    $escapedValues = array_map(function ($value) use ($conn) {
        return "'" . $conn->real_escape_string($value) . "'";
    }, $values);

    // Prepare the SQL INSERT statement
    $columnsString = implode(", ", $columns);
    $valuesString = implode(", ", $escapedValues);
    $sql = "INSERT INTO $tableName ($columnsString) VALUES ($valuesString)";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Record inserted successfully.</p>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch columns from the table to generate the form fields
$sql = "DESCRIBE $tableName";
$result = $conn->query($sql);
$columns = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $columns[] = $row['Field'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Values into <?php echo htmlspecialchars($tableName); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
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
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
        }
        input[type="submit"] {
            padding: 10px 15px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .back-button {
            display: block;
            margin: 20px 0;
            text-align: center;
        }
        .back-button a {
            padding: 10px 15px;
            background-color: #6c757d;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
        }
        .back-button a:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Insert Values into Table: <?php echo htmlspecialchars($tableName); ?></h3>
        <form method="POST">
            <?php foreach ($columns as $column): ?>
                <label for="value_<?php echo $column; ?>"><?php echo htmlspecialchars($column); ?>:</label>
                <input type="text" id="value_<?php echo $column; ?>" name="values[]" required>
            <?php endforeach; ?>
            <input type="hidden" name="columns" value="<?php echo htmlspecialchars(implode(",", $columns)); ?>">
            <input type="submit" value="Insert">
        </form>
        <div class="back-button">
            <a href="list_tables.php?database_name=<?php echo urlencode($databaseName); ?>&table_name=<?php echo urlencode($tableName); ?>">BACK</a>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>
