<!DOCTYPE html>
<html>
<head>
  <title>All Books</title>
  <style>
    .book-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
      padding: 20px;
    }
    .book-card {
      border: 1px solid #ccc;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      background-color: #fafafa;
      position: relative;
    }
    .book-card h3 {
      margin-top: 0;
    }
    .book-card a {
      color: #007BFF;
      text-decoration: none;
    }
    .like-btn {
      padding: 8px 12px;
      margin-top: 10px;
      border: none;
      border-radius: 5px;
      color: white;
      background-color: grey;
      cursor: pointer;
    }
    .like-btn.liked {
      background-color: red;
    }
  </style>
</head>
<body>

<h2 style="text-align:center;">Book List</h2>

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

// Query all records
$sql = "SELECT * FROM books";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo '<div class="book-grid">';
  while($row = $result->fetch_assoc()) {
    $liked = $row['liked'] ? 'liked' : '';
    $likeText = $row['liked'] ? 'Unlike' : 'Like';

    echo '<div class="book-card" data-id="' . $row["id"] . '">';
    echo '<h3>' . htmlspecialchars($row["name"]) . '</h3>';
    echo '<p><strong>Author:</strong> ' . htmlspecialchars($row["author"]) . '</p>';
    echo '<p><strong>Genre:</strong> ' . htmlspecialchars($row["genre"]) . '</p>';
    echo '<p><strong>Pages:</strong> ' . htmlspecialchars($row["page_count"]) . '</p>';
    echo '<p><a href="' . htmlspecialchars($row["link"]) . '" target="_blank">More Info</a></p>';
    echo '<button class="like-btn ' . $liked . '" onclick="toggleLike(' . $row["id"] . ')">' . $likeText . '</button>';
    echo '</div>';
  }
  echo '</div>';
} else {
  echo "<p style='text-align:center;'>No records found.</p>";
}

$conn->close();
?>

<script>
function toggleLike(bookId) {
  fetch('toggle_like.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: 'id=' + bookId
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      const card = document.querySelector('.book-card[data-id="' + bookId + '"]');
      const button = card.querySelector('.like-btn');
      if (data.liked) {
        button.classList.add('liked');
        button.textContent = 'Unlike';
      } else {
        button.classList.remove('liked');
        button.textContent = 'Like';
      }
    }
  });
}
</script>

<a href="addbook.html">
  <button>Add book</button>
</a>

</body>
</html>