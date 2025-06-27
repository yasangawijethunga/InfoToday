<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>InfoToday - Home</title>
  <link rel="stylesheet" href="css/style.css">
   <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
    }
    header, footer {
      background-color: #f9f9f9;
      color: black;
      padding: 20px;
      text-align: center;
    }
    nav a {
      color: #0077cc;
      margin: 0 15px;
      text-decoration: none;
    }
    main {
      max-width: 1200px;
      margin: 20px auto;
      padding: 0 20px;
    }
    #news-section {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
    }
    .news-card {
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      display: flex;
      flex-direction: column;
      transition: transform 0.2s ease;
    }
    .news-card:hover {
      transform: translateY(-5px);
    }
    .news-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }
    .news-card-content {
      padding: 15px;
    }
    .news-card h2 {
      font-size: 1.2em;
      margin: 0 0 10px;
    }
    .news-card p {
      font-size: 0.95em;
      color: #333;
      margin-bottom: 10px;
    }
    .news-card small {
      color: #777;
      font-size: 0.85em;
    }
  </style>
</head>
<body>
  <header>
    <h1>InfoToday</h1>
    <nav>
      <a href="index.php">Home</a>
      <a href="news.php">News</a>
      <a href="about.php">About</a>
      <a href="contact.php">Contact</a>
    </nav>
  </header>
<main>
  <h2>Latest News</h2>
  <style>
    #news-section {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }
    .news-card {
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      display: flex;
      flex-direction: column;
      transition: transform 0.2s ease;
      text-decoration: none;
      color: inherit;
    }
    .news-card:hover {
      transform: translateY(-5px);
    }
    .news-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }
    .news-card-content {
      padding: 15px;
    }
    .news-card h2 {
      font-size: 1.2em;
      margin: 0 0 10px;
    }
    .news-card p {
      font-size: 0.95em;
      color: #333;
      margin-bottom: 10px;
    }
    .news-card small {
      color: #777;
      font-size: 0.85em;
    }
    .view-more {
      text-align: center;
      margin-top: 20px;
    }
    .view-more a {
      padding: 10px 20px;
      background-color: #0077cc;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
    }
    .view-more a:hover {
      background-color: #005fa3;
    }
  </style>
  <section id="news-section">
    <?php
      include 'db/config.php';
      $result = mysqli_query($conn, "SELECT * FROM articles ORDER BY created_at DESC LIMIT 3");
      while($row = mysqli_fetch_assoc($result)) {
        echo '<a class="news-card" href="article.php?id=' . $row['id'] . '">';
        if (!empty($row['image'])) {
          echo '<img src="uploads/' . htmlspecialchars($row['image']) . '" alt="News Image">';
        }
        echo '<div class="news-card-content">';
        echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
        echo '<p>' . htmlspecialchars(substr($row['content'], 0, 200)) . '...</p>';
        echo '<small>Published on ' . $row['created_at'] . '</small>';
        echo '</div></a>';
      }
    ?>
  </section>
  <div class="view-more">
    <a href="news.php">View More News</a>
  </div>
</main>
  <footer>
    <p>&copy; 2025 InfoToday. All rights reserved.</p>
  </footer>
</body>
</html>
