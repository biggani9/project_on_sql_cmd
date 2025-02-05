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

if (isset($_POST['sql_query']) && isset($_POST['database_name'])) {
    $databaseName = $_POST['database_name'];
    $sqlQuery = $_POST['sql_query'];

    $conn->select_db($databaseName);  // Select the database

    $result = $conn->query($sqlQuery);

    echo "<style>
            body {
                background-color: #f4f4f9;
                font-family: Arial, sans-serif;
                margin: 20px;
            }
            h3 {
                color: #333;
            }
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
            p {
                font-size: 16px;
            }
            .success {
                color: green;
            }
            .error {
                color: red;
            }
        </style>";

    echo "<h3>Query Result:</h3>";

    if ($result === TRUE) {
        echo "<p class='success'>Query executed successfully.</p>";
    } elseif ($result) {
        echo "<table>";
        echo "<tr>";
        while ($field = $result->fetch_field()) {
            echo "<th>" . htmlspecialchars($field->name) . "</th>";
        }
        echo "</tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='error'>Error: " . htmlspecialchars($conn->error) . "</p>";
    }
} else {
    echo "<p class='error'>No query or database provided.</p>";
}
?>
