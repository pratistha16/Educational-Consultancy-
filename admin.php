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

// Handle form submission for adding news
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $sql = "INSERT INTO News (title, description) VALUES ('$title', '$description')";

    if ($conn->query($sql) === TRUE) {
        echo "New news item added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch all news for editing or deleting
$sql = "SELECT id, title, description FROM News ORDER BY created_at DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage News</title>
</head>
<body>
    <h1>Admin Panel - Manage News</h1>

    <!-- Form to add news -->
    <form action="admin.php" method="POST">
        <label for="title">News Title:</label><br>
        <input type="text" id="title" name="title" required><br><br>
        
        <label for="description">News Description:</label><br>
        <textarea id="description" name="description" required></textarea><br><br>
        
        <button type="submit">Add News</button>
    </form>

    <h2>Existing News</h2>
    <table>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php
        // Display news items in a table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["title"] . "</td>";
                echo "<td>" . $row["description"] . "</td>";
                echo "<td><a href='edit_news.php?id=" . $row["id"] . "'>Edit</a> | <a href='delete_news.php?id=" . $row["id"] . "'>Delete</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No news available</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
