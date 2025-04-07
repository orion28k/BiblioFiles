<?php
$servername = "localhost";
$username = "andre";
$password = "andre1";
$dbname = "Bibliofiles";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  echo json_encode(['success' => false, 'error' => 'Database connection failed']);
  exit;
}

// Get the book ID from the POST request
if (!isset($_POST['id'])) {
  echo json_encode(['success' => false, 'error' => 'Missing ID']);
  exit;
}

$id = intval($_POST['id']);

// Get the current 'liked' value
$sql = "SELECT liked FROM books WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  echo json_encode(['success' => false, 'error' => 'Book not found']);
  exit;
}

$row = $result->fetch_assoc();
$currentLiked = $row['liked'];

// Toggle the liked value
$newLiked = $currentLiked ? 0 : 1;

// Update the value in the database
$update = $conn->prepare("UPDATE books SET liked = ? WHERE id = ?");
$update->bind_param("ii", $newLiked, $id);

if ($update->execute()) {
  echo json_encode(['success' => true, 'liked' => $newLiked]);
} else {
  echo json_encode(['success' => false, 'error' => 'Failed to update']);
}

$stmt->close();
$update->close();
$conn->close();
?>