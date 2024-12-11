<?php
$conn = new mysqli("localhost", "root", "", "Lab_5b");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT matric, name, role FROM users");

echo "<table class='user-table'>
        <tr>
            <th>Matric</th>
            <th>Name</th>
            <th>Role</th>
            <th>Action</th>
        </tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['matric']}</td>
            <td>{$row['name']}</td>
            <td>{$row['role']}</td>
            <td>
                <a href='update.php?matric={$row['matric']}' class='btn update-btn'>Update</a> | 
                <a href='delete.php?matric={$row['matric']}' onclick=\"return confirm('Are you sure you want to delete this user?');\" class='btn delete-btn'>Delete</a>
            </td>
          </tr>";
}

echo "</table>";
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h2 {
            text-align: center;
            margin: 20px 0;
            color: #5b5b5b;
        }

        .user-table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .user-table th, .user-table td {
            padding: 12px;
            text-align: left;
        }

        .user-table th {
            background-color: #4CAF50;
            color: white;
        }

        .user-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .user-table tr:hover {
            background-color: #eaeaea;
        }

        .btn {
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }

        .update-btn {
            background-color: #4CAF50;
            color: white;
        }

        .update-btn:hover {
            background-color: #45a049;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
        }

        .delete-btn:hover {
            background-color: #e53935;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>
</html>
