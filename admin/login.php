<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include '../db/config.php';
  $username = $_POST['username'];
  $password = $_POST['password'];
  $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? AND password = ?");
  $stmt->bind_param("ss", $username, $password);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows === 1) {
    $_SESSION['admin'] = $username;
    header('Location: dashboard.php');
    exit;
  } else {
    $error = "Invalid username or password";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Login</title>
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f4f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: #333;
    }
    .login-form {
      background: #fff;
      padding: 40px 30px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
      text-align: center;
    }
    .login-form h2 {
      margin-bottom: 20px;
      color: #0077cc;
    }
    .login-form input {
      width: 100%;
      padding: 12px;
      margin-bottom: 16px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 15px;
      transition: border-color 0.3s;
    }
    .login-form input:focus {
      border-color: #0077cc;
      outline: none;
    }
    .login-form button {
      width: 100%;
      padding: 12px;
      background-color: #0077cc;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .login-form button:hover {
      background-color: #005fa3;
    }
    .error-message {
      color: #d93025;
      margin-bottom: 16px;
      font-size: 14px;
      background: #ffeaea;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #f5c2c7;
    }
    @media (max-width: 480px) {
      .login-form {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>
  <form method="POST" class="login-form">
    <h2>Admin Login</h2>
    <?php if (!empty($error)): ?>
      <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>
</body>
</html>

