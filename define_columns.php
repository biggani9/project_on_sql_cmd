<?php
// Ensure the required parameters are passed via GET
if (isset($_GET['table_name']) && isset($_GET['columns']) && isset($_GET['database_name'])) {
    $tableName = $_GET['table_name'];
    $columns = (int)$_GET['columns'];
    $databaseName = $_GET['database_name'];
} else {
    die("Invalid request.");
}

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

// Select the database
$conn->select_db($databaseName);

// Initialize the message variable
$message = "";

// Handle table creation when the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_table'])) {
    $columnsSql = [];
    $primaryKey = $_POST['primary_key'] ?? null;

    // Get column details from the form
    for ($i = 0; $i < $columns; $i++) {
        $columnName = $_POST["column_name_$i"];
        $dataType = $_POST["data_type_$i"];
        $length = $_POST["length_$i"];

        // Construct the column definition
        $columnDefinition = "`$columnName` $dataType($length)";
        if ($primaryKey === "column_$i") {
            $columnDefinition .= " PRIMARY KEY";
        }

        $columnsSql[] = $columnDefinition;
    }

    // Join the column definitions to form the complete SQL query
    $columnsSqlString = implode(", ", $columnsSql);

    // Create the SQL query to create the table
    $sql = "CREATE TABLE `$tableName` ($columnsSqlString)";

    // Execute the query to create the table
    if ($conn->query($sql) === TRUE) {
        $message = "Table \"$tableName\" created successfully!";

        // Include the JavaScript to show the message and redirect after a short delay
        echo "<script>
                alert('$message');
                setTimeout(function() {
                    window.location.href = 'use_database.php?database_name=" . urlencode($databaseName) . "';
                }, 2000); // Redirect after 2 seconds
              </script>";
        exit(); // Ensure no further code is executed after the redirection
    } else {
        $message = "Error creating table \"$tableName\": " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Define Columns for <?php echo htmlspecialchars($tableName); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:rgb(192, 228, 236);
            color: #333;
        }
        .container {
            max-width: 1020px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h3 {
            text-align: center;
            color: #444;
        }
        form {
            margin-top: 20px;
        }
        .form-group {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 6px;
            background-color: #e9ecef;
        }
        label {
            font-weight: bold;
            margin-right: 5px;
            min-width: 100px;
        }
        input[type="text"], input[type="radio"], button {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="text"] {
            width: 150px;
        }
        button {
            background-color: #28a745;
            
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 10px 472px;
        }
        button:hover {
            background-color: rgb(247, 41, 5);
        }
        .radio-group {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #007bff;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Define Columns for Table: <?php echo htmlspecialchars($tableName); ?></h3>

        <!-- Show success or error message -->
        <?php if (!empty($message)): ?>
            <p style="color: <?php echo strpos($message, 'successfully') !== false ? 'green' : 'red'; ?>; text-align: center;">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php endif; ?>

        <!-- Form to define columns for the table -->
        <form method="POST" action="">
            <input type="hidden" name="table_name" value="<?php echo htmlspecialchars($tableName); ?>">
            <input type="hidden" name="columns" value="<?php echo $columns; ?>">

            <?php for ($i = 0; $i < $columns; $i++): ?>
                <div class="form-group">
                    <label for="column_name_<?php echo $i; ?>">Column Name:</label>
                    <input type="text" id="column_name_<?php echo $i; ?>" name="column_name_<?php echo $i; ?>" required>

                    <label for="data_type_<?php echo $i; ?>">Data Type:</label>
                    <input type="text" id="data_type_<?php echo $i; ?>" name="data_type_<?php echo $i; ?>" required>

                    <label for="length_<?php echo $i; ?>">Length/Values:</label>
                    <input type="text" id="length_<?php echo $i; ?>" name="length_<?php echo $i; ?>" required>

                    <div class="radio-group">
                        <input type="radio" id="primary_key_<?php echo $i; ?>" name="primary_key" value="column_<?php echo $i; ?>">
                        <label for="primary_key_<?php echo $i; ?>">Primary Key</label>
                    </div>
                </div>
            <?php endfor; ?>

            <button type="submit" name="submit_table">Create Table</button>
        </form>

        <a href="create_table.php?database_name=<?php echo urlencode($databaseName); ?>" class="back-link">Back</a>
    </div>
</body>
</html>
