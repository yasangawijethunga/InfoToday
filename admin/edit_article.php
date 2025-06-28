<?php
session_start();
if (!isset($_SESSION['admin'])) header('Location: login.php');
include '../db/config.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) die("Invalid ID");

$stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = htmlspecialchars(trim($_POST['title']));
  $content = htmlspecialchars(trim($_POST['content']));
  $imageName = $row['image']; // Default to existing image

  if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

    if (in_array($ext, $allowed)) {
      $imageName = uniqid("img_", true) . "." . $ext;
      $targetPath = realpath(__DIR__ . '/../uploads') . DIRECTORY_SEPARATOR . $imageName;
      if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
        $imageName = $row['image']; // fallback to old image if upload fails
      }
    }
  }

  $stmt = $conn->prepare("UPDATE articles SET title=?, content=?, image=? WHERE id=?");
  $stmt->bind_param("sssi", $title, $content, $imageName, $id);
  $stmt->execute();
  header('Location: dashboard.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Article</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f4f6f8;
      padding: 40px;
      margin: 0;
      color: #333;
    }

    h2 {
      text-align: center;
      color: #0077cc;
      margin-bottom: 30px;
    }

    form {
      background: white;
      max-width: 700px;
      margin: auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    .title-input {
      font-size: 20px;
      font-weight: 600;
      padding: 13px 20px;
      border: 1.5px solid #ccc;
      border-radius: 8px;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
      background-color: #fff;
      letter-spacing: 0.3px;
      margin-bottom: 20px;
    }

    .title-input::placeholder {
      color: #999;
      font-style: italic;
      font-size: 16px;
    }

    .title-input:focus {
      border-color: #0077cc;
      box-shadow: 0 0 0 4px rgba(0, 119, 204, 0.1);
      outline: none;
    }

    textarea {
      width: 100%;
      padding: 14px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 15px;
      margin-bottom: 20px;
      resize: vertical;
      min-height: 160px;
    }

    textarea:focus {
      border-color: #0077cc;
      outline: none;
    }

    input[type="file"] {
      font-size: 15px;
      margin-bottom: 20px;
    }

    button {
      padding: 12px 24px;
      background: linear-gradient(135deg, #0077cc, #005fa3);
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      width: 100%;
      transition: background 0.3s ease;
    }

    button:hover {
      background: linear-gradient(135deg, #005fa3, #004c8c);
    }

    .preview-img {
      margin-bottom: 20px;
      text-align: center;
    }

    .preview-img img {
      max-width: 150px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    label {
      font-weight: 600;
      color: #444;
      display: block;
      margin-bottom: 8px;
    }

    @media (max-width: 600px) {
      body {
        padding: 20px;
      }

      form {
        padding: 20px;
      }
    }
  </style>
</head>
<body>

  <h2>✏️ Edit Article</h2>

  <form method="POST" enctype="multipart/form-data">
    <label for="title">Article Title:</label>
    <input id="title" name="title" class="title-input" placeholder="Enter a captivating title..." value="<?= htmlspecialchars($row['title']) ?>" required>

    <label for="content">Content:</label>
    <textarea id="content" name="content" required><?= htmlspecialchars($row['content']) ?></textarea>

    <label for="image">Update Image (optional):</label>
    <input id="image" type="file" name="image" accept="image/*">

    <?php if (!empty($row['image'])): ?>
      <div class="preview-img">
        <p>Current Image:</p>
        <img src="../uploads/<?= htmlspecialchars($row['image']) ?>" alt="Current Image">
      </div>
    <?php endif; ?>

    <button type="submit">✅ Update Article</button>
  </form>

</body>
</html>

