<?php
session_start();
if (!isset($_SESSION['admin'])) header('Location: login.php');
include '../db/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = htmlspecialchars(trim($_POST['title']));
  $content = htmlspecialchars(trim($_POST['content']));
  $imageName = null;

  if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

    if (in_array($ext, $allowed)) {
      $imageName = uniqid("img_", true) . "." . $ext;
      $targetPath = realpath(__DIR__ . '/../uploads') . DIRECTORY_SEPARATOR . $imageName;
      if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
        $imageName = null;
      }
    }
  }

  $stmt = $conn->prepare("INSERT INTO articles (title, content, image, created_at) VALUES (?, ?, ?, NOW())");
  $stmt->bind_param("sss", $title, $content, $imageName);
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
  <title>Add Article</title>
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

    input[type="text"],
    textarea {
      width: 100%;
      padding: 14px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 15px;
      margin-bottom: 20px;
      transition: border-color 0.3s ease;
    }

    input[type="text"]:focus,
    textarea:focus {
      border-color: #0077cc;
      outline: none;
    }

    textarea {
      resize: vertical;
      min-height: 160px;
    }

    input[type="file"] {
      border: none;
      font-size: 15px;
      margin-bottom: 10px;
    }

    #preview {
      margin: 15px 0 20px;
      text-align: center;
    }

    #preview img {
      max-width: 200px;
      border-radius: 6px;
      border: 1px solid #ccc;
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

  <h2>➕ Add New Article</h2>

  <form method="POST" enctype="multipart/form-data">
    <input name="title" type="text" placeholder="Article Title" required>
    <textarea name="content" placeholder="Write your article content here..." required></textarea>

    <input type="file" name="image" accept="image/*" onchange="previewImage(event)">
    
    <div id="preview" style="display:none;">
      <p><strong>Image Preview:</strong></p>
      <img id="preview-img" src="" alt="Preview">
    </div>

    <button type="submit">📢 Publish Article</button>
  </form>

  <script>
    function previewImage(event) {
      const preview = document.getElementById('preview');
      const img = document.getElementById('preview-img');
      const file = event.target.files[0];

      if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
          img.src = e.target.result;
          preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
      } else {
        preview.style.display = 'none';
        img.src = '';
      }
    }
  </script>

</body>
</html>

