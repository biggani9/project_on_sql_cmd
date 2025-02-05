<?php
if (isset($_POST['submit'])) {
    $servername = "localhost";
    $username = "root"; // Change if needed
    $password = ""; // Change if needed

    $dbname = $_POST['dbname'];

    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Create database
    $sql = "CREATE DATABASE $dbname";

    if ($conn->query($sql) === TRUE) {
        $successMessage = "Database '$dbname' created successfully.";
    } else {
        $errorMessage = "Error creating database: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Database</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(192, 228, 236);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        input[type="submit"]:hover {
            background-color: rgb(247, 41, 5);
        }

        .message {
            margin-top: 15px;
            font-size: 14px;
        }

        .message.success {
            color: green;
        }

        .message.error {
            color: red;
        }

        .menu-button {
            display: block;
            margin-top: 20px;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .menu-button:hover {
            background-color: rgb(247, 41, 5);
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Create Database</h2>
        <form method="POST" action="">
            <label for="dbname">Enter Database Name:</label>
            <input type="text" id="dbname" name="dbname" required>
            <input type="submit" name="submit" value="Create Database">
        </form>

        <?php if (isset($successMessage)) : ?>
            <div class="message success">
                <?php echo $successMessage; ?>
            </div>
            <a href="menu.php" class="menu-button">Go to Menu</a>
        <?php elseif (isset($errorMessage)) : ?>
            <div class="message error">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
