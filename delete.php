<?php
$conn = new mysqli("localhost", "root", "", "Lab_5b");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];
    $stmt = $conn->prepare("DELETE FROM users WHERE matric = ?");
    $stmt->bind_param("s", $matric);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>User deleted successfully. <a href='display.php' style='color: #007bff;'>Return to list</a></p>";
    } else {
        echo "<p style='color: red;'>Error deleting user.</p>";
    }
}

$conn->close();
?>
