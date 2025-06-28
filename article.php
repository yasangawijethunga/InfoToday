<?php

include 'db/config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "<main><p>Invalid article ID.</p></main>";

  exit;
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  echo "<main><p>Article not found.</p></main>";

  exit;
}

$article = $result->fetch_assoc();
?>

<main>
  <style>
    main {
    padding: 20px;
    background-color: #f4f4f4;
    }
    .article-container {
      max-width: 800px;
      margin: 40px auto;
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      font-family: Arial, sans-serif;
    }
    .article-container h1 {
      font-size: 2em;
      margin-bottom: 10px;
      color: #0077cc;
    }
    .article-container small {
      color: #888;
    }
    .article-container img {
      width: 100%;
      height: auto;
      margin-top: 20px;
      border-radius: 8px;
    }
    .article-container p {
      font-size: 1.05em;
      line-height: 1.6;
      margin-top: 20px;
    }
    .back-button {
      display: inline-block;
      margin-top: 30px;
      padding: 10px 18px;
      background-color: #0077cc;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      font-weight: 600;
      transition: background-color 0.3s ease;
      font-family: Arial, sans-serif;
    }
    .back-button:hover {
      background-color: #005fa3;
    }
  </style>

  <div class="article-container">
    <h1><?= htmlspecialchars($article['title']) ?></h1>
    <small>Published on <?= $article['created_at'] ?></small>
    <?php if (!empty($article['image'])): ?>
      <img src="uploads/<?= htmlspecialchars($article['image']) ?>" alt="Article Image">
    <?php endif; ?>
    <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>

    <a href="news.php" class="back-button">← Back to News</a>
  </div>
</main>




