<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  include 'db/config.php';
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];
  $stmt = $conn->prepare("INSERT INTO messages (name, email, message, sent_at) VALUES (?, ?, ?, NOW())");
  $stmt->bind_param("sss", $name, $email, $message);
  $stmt->execute();
  $stmt->close();
  $conn->close();
  $success = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us - InfoToday</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    form {
      max-width: 500px;
      margin: auto;
      padding: 20px;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px #ccc;
    }
    input, textarea {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    input[type="submit"] {
      background: #0077cc;
      color: white;
      border: none;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <header>
    <h1>Contact InfoToday</h1>
    <nav>
      <a href="index.php">Home</a>
      <a href="news.php">News</a>
      <a href="about.php">About</a>
      <a href="contact.php">Contact</a>
    </nav>
  </header>
  
<main>
  <style>
    .contact-container {
      max-width: 800px;
      margin: 30px auto;
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      font-family: Arial, sans-serif;
    }
    .contact-container h2 {
      color: #0077cc;
    }
    .contact-form {
      display: flex;
      flex-direction: column;
    }
    .contact-form input,
    .contact-form textarea {
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1em;
    }
    .contact-form button {
      width: fit-content;
      padding: 10px 20px;
      background: #0077cc;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    .contact-form button:hover {
      background: #005fa3;
    }
  </style>

  <div class="contact-container">
    <h2>Contact Us</h2>
    <p>If you have any questions, feedback, or news tips, feel free to reach out. We’d love to hear from you!</p>

    <form class="contact-form" method="post" action="php/send_message.php">
      <input type="text" name="name" placeholder="Your Name" required>
      <input type="email" name="email" placeholder="Your Email" required>
      <textarea name="message" rows="6" placeholder="Your Message" required></textarea>
      <button type="submit">Send Message</button>
    </form>
  </div>
</main>
  <footer>
    <p>&copy; 2025 InfoToday. All rights reserved.</p>
  </footer>

</body>
</html>

