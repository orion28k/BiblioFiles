<?php
$servername = "localhost";
$username = "andre";
$password = "andre1";
$dbname = "Bibliofiles";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get POST data safely
$name = $_POST["name"];
$author = $_POST["author"];
$genre = $_POST["genre"];
$page_count = $_POST["page_count"];
$liked = 0; // default value
$link = $_POST["link"];

// Get current number of records to set as ID
$result = $conn->query("SELECT COUNT(*) AS total FROM books");
$row = $result->fetch_assoc();
$id = $row['total'] + 1;

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO books (id, name, author, genre, page_count, liked, link) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssids", $id, $name, $author, $genre, $page_count, $liked, $link);

// Execute and check
if ($stmt->execute()) {
  echo "New record created successfully";
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>