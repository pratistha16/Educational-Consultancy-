<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "Pradeepa@16";
$dbname = "quickglobal";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

$sql = "DELETE FROM News WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "News item deleted successfully!";
    header("Location: admin.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
