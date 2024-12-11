<?php
session_start();
$conn = new mysqli("localhost", "root", "", "Lab_5b");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; // To store the error message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matric = $_POST['matric'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE matric = ?");
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            echo "Login successful! Welcome, " . $user['name'];
            exit; // Stop further execution after successful login
        } else {
            $message = "Invalid username or password, try <a href='login.php'>login</a> again.";
        }
    } else {
        $message = "Invalid username or password, try <a href='login.php'>login</a> again.";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h2 {
            color: #5a5a5a;
            text-align: center;
            margin-top: 50px;
        }
        form {
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            color: #555;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            background-color: #5cb85c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #4cae4c;
        }
        .error-message {
            color: red;
            font-size: 16px;
        }
        .success-message {
            color: green;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h2>Login</h2>
    <form method="post">
        <label>Matric:</label>
        <input type="text" name="matric" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
    <p><a href="register.php">Register</a> here if you have not.</p>
    <!-- Display the error message below the login button -->
    <?php if (!empty($message)) : ?>
        <p class="error-message"><?php echo $message; ?></p>
    <?php endif; ?>
</body>
</html>
