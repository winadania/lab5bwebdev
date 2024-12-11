<?php
$conn = new mysqli("localhost", "root", "", "Lab_5b");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];
    $stmt = $conn->prepare("SELECT matric, name, role FROM users WHERE matric = ?");
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
    } else {
        die("User not found.");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET name = ?, role = ? WHERE matric = ?");
    $stmt->bind_param("sss", $name, $role, $matric);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>User updated successfully. <a href='display.php' style='color: #007bff;'>Return to list</a></p>";
    } else {
        echo "<p style='color: red;'>Error updating user.</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
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
        input[type="text"] {
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
        a {
            color: #007bff;
        }
    </style>
</head>
<body>
    <h2>Update User</h2>
    <form method="post">
        <label>Matric:</label>
        <input type="text" name="matric" value="<?php echo $user['matric']; ?>" readonly><br>
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $user['name']; ?>" required><br>
        <label>Access Level:</label>
        <input type="text" name="role" value="<?php echo $user['role']; ?>" required><br>
        <button type="submit">Update</button>
        <a href="display.php">Cancel</a>
    </form>
</body>
</html>
