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

// Initialize variables
$databaseName = "";
$tables = [];
$queryResult = "";
$queryError = "";

// Check if the database_name parameter is provided
if (isset($_GET['database_name'])) {
    $databaseName = $_GET['database_name'];
    $conn->select_db($databaseName);  // Select the database

    // Fetch all table names in the selected database
    $result = $conn->query("SHOW TABLES");
    if ($result) {
        while ($row = $result->fetch_array()) {
            $tables[] = $row[0];
        }
    }
} else {
    echo "<p style='color: red;'>No database selected.</p>";
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sql_query']) && isset($_POST['database_name'])) {
    $databaseName = $_POST['database_name'];
    $sqlQuery = $_POST['sql_query'];

    $conn->select_db($databaseName);  // Select the database

    $result = $conn->query($sqlQuery);

    // Store result or error
    if ($result === TRUE) {
        $queryResult = "<p class='success'>Query executed successfully.</p>";
    } elseif ($result) {
        $queryResult = "<table>";
        $queryResult .= "<tr>";
        while ($field = $result->fetch_field()) {
            $queryResult .= "<th>" . htmlspecialchars($field->name) . "</th>";
        }
        $queryResult .= "</tr>";

        while ($row = $result->fetch_assoc()) {
            $queryResult .= "<tr>";
            foreach ($row as $value) {
                $queryResult .= "<td>" . htmlspecialchars($value) . "</td>";
            }
            $queryResult .= "</tr>";
        }
        $queryResult .= "</table>";
    } else {
        $queryError = "<p class='error'>Error: " . htmlspecialchars($conn->error) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alter Table</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color:rgb(192, 228, 236);
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1, h3, h4 {
            color: #2e3a59;
            text-align: center;
        }

        h1 {
            margin-top: 40px;
            font-size: 36px;
            font-weight: bold;
        }

        h3 {
            font-size: 24px;
        }

        .info-box, .form-container, .table-list {
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            margin: 20px auto;
            width: 80%;
            max-width: 900px;
        }

        .info-box h3 {
            margin-bottom: 10px;
            font-size: 20px;
            color: #4CAF50;
        }

        .info-box p, .form-container p {
            font-size: 16px;
            line-height: 1.5;
            color: #555;
        }

        .form-container textarea {
            width: 100%;
            height: 150px;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            resize: vertical;
        }

        .table-list ul {
            list-style: none;
            padding: 0;
        }

        .table-list li {
            padding: 8px 0;
            font-size: 16px;
            color: #555;
            border-bottom: 1px solid #ddd;
        }

        .table-list li:last-child {
            border-bottom: none;
        }

        .btn {
            padding: 12px 24px;
            font-size: 16px;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: rgb(247, 41, 5);
        }

        .btn-secondary {
            background-color: #5a6268;
            margin-left: 10px;
        }

        .btn-secondary:hover {
            background-color: rgb(247, 41, 5);
        }

        .btn-reload {
            padding: 12px 24px;
            font-size: 16px;
            color: #fff;
            background-color: #2196F3;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-left: 10px;
        }

        .btn-reload:hover {
            background-color: rgb(247, 41, 5);
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            color: #777;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .info-box, .form-container, .table-list {
                width: 100%;
                margin: 20px 0;
            }

            h1 {
                font-size: 28px;
            }

            h3 {
                font-size: 20px;
            }
        }

        /* Styling for table result */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #eaeaea;
        }
    </style>
    <script>
        function reloadPage() {
            // Set a flag in sessionStorage indicating the page was reloaded
            sessionStorage.setItem('reloaded', 'true');
            // Reload the page
            location.reload(true);
        }

        window.onload = function() {
            // Check if the page was reloaded
            if (sessionStorage.getItem('reloaded')) {
                // Remove the result part
                document.getElementById('queryResultContainer').style.display = 'none';
                // Remove the flag after reload
                sessionStorage.removeItem('reloaded');
            }
        }
    </script>
</head>
<body>

    <h1>AND</h1>

    <!-- Box 1: Define Select Distribution -->
    <div class="info-box">
        <h3>What is AND?</h3>
        <p>The AND operator in SQL is used to combine multiple conditions in a WHERE clause. It allows you to specify that all conditions must be true for a row to be included in the result.</p>
    </div>

    <!-- Box 2: General Query for Select Distribution -->
    <div class="info-box">
        <h3>General SQL Query for AND </h3>
        <pre>
        SELECT column1, column2, ...
        FROM table_name
        WHERE condition1 AND condition2;
        </pre>
    </div>

    <h3>Database Name: <?php echo htmlspecialchars($databaseName); ?></h3>

    <div class="table-list">
        <h4>Existing Tables:</h4>
        <ul>
            <?php if (!empty($tables)): ?>
                <?php foreach ($tables as $table): ?>
                    <li><?php echo htmlspecialchars($table); ?></li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No tables found in the database.</li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="form-container">
        <form method="post">
            <textarea name="sql_query" placeholder="Write your SQL query here..."></textarea>
            <input type="hidden" name="database_name" value="<?php echo htmlspecialchars($databaseName); ?>">
            <div style="text-align: center;">
                <button type="submit" class="btn">Run</button>
                <button type="button" class="btn-reload" onclick="reloadPage()">Reload</button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='querys.php?database_name=<?php echo urlencode($databaseName); ?>'">Back</button>
            </div>
        </form>
    </div>

    <!-- Display query result -->
    <div id="queryResultContainer">
        <?php if ($queryResult): ?>
            <div class="info-box">
                <h3>Query Result:</h3>
                <?php echo $queryResult; ?>
            </div>
        <?php elseif ($queryError): ?>
            <div class="info-box">
                <h3>Error:</h3>
                <?php echo $queryError; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="footer">
        <p>&copy; 2025 Jahid Hasan. All Rights Reserved.</p>
    </div>

</body>
</html>
