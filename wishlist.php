<?php
// Database connection
$servername = "localhost";
$username = "root";  // Change if needed
$password = "";      // Change if needed
$dbname = "wishlist_db";  // Change to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table if it doesn't exist
$conn->query("CREATE TABLE IF NOT EXISTS wishlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(255) NOT NULL,
    item_price VARCHAR(50) NOT NULL
)");

// Handle item addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];

    if (!empty($item_name) && !empty($item_price)) {
        $stmt = $conn->prepare("INSERT INTO wishlist (item_name, item_price) VALUES (?, ?)");
        $stmt->bind_param("ss", $item_name, $item_price);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: wishlist.php");
    exit();
}

// Handle item removal
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['remove'])) {
    $id = $_GET['remove'];
    $conn->query("DELETE FROM wishlist WHERE id=$id");
    header("Location: wishlist.php");
    exit();
}

// Handle wishlist clearing
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['clear'])) {
    $conn->query("TRUNCATE TABLE wishlist");
    header("Location: wishlist.php");
    exit();
}

// Fetch wishlist items
$items = $conn->query("SELECT * FROM wishlist");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wishlist</title>
  <style>
    body { font-family: Arial, sans-serif; background-color: skyblue; text-align: center; }
    .header { background-color: #333; color: white; padding: 10px 0; font-size: 1.5rem; }
    .wishlist-section, .add-item-form { background: white; border-radius: 10px; box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1); width: 50%; margin: 20px auto; padding: 20px; }
    .wishlist-section h2, .add-item-form h3 { color: dodgerblue; }
    ul { list-style: none; padding: 0; }
    li { display: flex; justify-content: space-between; padding: 10px; background: #fff; margin: 10px 0; border-radius: 5px; }
    button { background-color: dodgerblue; color: white; border: none; border-radius: 5px; padding: 5px 10px; cursor: pointer; }
    button:hover { background-color: lime; color: black; }
    input { width: 80%; padding: 10px; margin: 10px; border: 1px solid #ddd; border-radius: 5px; }
  </style>
</head>
<body>
  <header class="header"><h1>Wishlist</h1></header>

  <section class="wishlist-section">
    <h2>Your Wishlist</h2>
    <ul>
      <?php while ($row = $items->fetch_assoc()): ?>
        <li>
          <?= htmlspecialchars($row['item_name']) ?> - ₱ <?= htmlspecialchars($row['item_price']) ?>
          <a href="wishlist.php?remove=<?= $row['id'] ?>"><button>Remove</button></a>
        </li>
      <?php endwhile; ?>
    </ul>

    <form action="wishlist.php" method="POST">
      <button type="submit" name="clear">Clear Wishlist</button>
    </form>
  </section>

  <section class="add-item-form">
    <h3>Add a New Item to Your Wishlist</h3>
    <form action="wishlist.php" method="POST">
      <input type="text" name="item_name" placeholder="Item Name" required>
      <input type="text" name="item_price" placeholder="Price" required>
      <button type="submit" name="add">Add Item</button>
    </form>
  </section>

  <footer>
    &copy; 2024 Masubay Car Parts Shop. All Rights Reserved.
  </footer>
</body>
</html>
