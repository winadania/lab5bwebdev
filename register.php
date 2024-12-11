<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Database connection
    $conn = new mysqli("localhost", "root", "", "Lab_5b");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the matric already exists
    $checkStmt = $conn->prepare("SELECT matric FROM users WHERE matric = ?");
    $checkStmt->bind_param("s", $matric);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo "<p style='color: red;'>Error: Matric number already exists. Please try a different one.</p>";
    } else {
        // Proceed with insertion if matric does not exist
        $stmt = $conn->prepare("INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $matric, $name, $password, $role);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>Registration successful! You can now <a href='login.php'>login here</a>.</p>";
        } else {
            echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
        }
        $stmt->close();
    }

    $checkStmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
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
        input[type="text"], input[type="password"], select {
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
    <h2>Register</h2>
    <form method="post">
        <label>Matric:</label>
        <input type="text" name="matric" required><br>
        <label>Name:</label>
        <input type="text" name="name" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <label>Role:</label>
        <select name="role" required>
            <option value="">Please select</option>
            <option value="student">Student</option>
            <option value="lecturer">Lecturer</option>
        </select><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
