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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $sql = "UPDATE News SET title='$title', description='$description' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "News item updated successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch news item for editing
$sql = "SELECT title, description FROM News WHERE id=$id";
$result = $conn->query($sql);
$news = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit News</title>
</head>
<body>
    <h1>Edit News</h1>

    <form action="edit_news.php?id=<?php echo $id; ?>" method="POST">
        <label for="title">News Title:</label><br>
        <input type="text" id="title" name="title" value="<?php echo $news['title']; ?>" required><br><br>
        
        <label for="description">News Description:</label><br>
        <textarea id="description" name="description" required><?php echo $news['description']; ?></textarea><br><br>
        
        <button type="submit">Update News</button>
    </form>
</body>
</html>
<?php
$conn->close();
?>
