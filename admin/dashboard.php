<?php
session_start();
if (!isset($_SESSION['admin'])) header('Location: login.php');
include '../db/config.php';
$result = mysqli_query($conn, "SELECT * FROM articles");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard</title>
  <style>
    /* Reset and base */
    * {
      box-sizing: border-box;
    }
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 30px 40px;
      background-color: #f5f7fa;
      color: #333;
    }
    h2 {
      margin-bottom: 25px;
      font-weight: 700;
      color: #0077cc;
    }
    /* Button styles */
    .btn {
      display: inline-block;
      padding: 10px 18px;
      margin: 5px 0;
      background-color: #007bff;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      font-weight: 600;
      transition: background-color 0.3s ease;
      border: none;
      cursor: pointer;
      user-select: none;
      font-size: 14px;
    }
    .btn:hover {
      background-color: #0056b3;
    }
    .btn-secondary {
      background-color: #6c757d;
    }
    .btn-secondary:hover {
      background-color: #565e64;
    }
    /* Layout for header buttons */
    .header-buttons {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      flex-wrap: wrap;
      gap: 10px;
    }
    /* Table styling */
    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0 10px;
      background-color: transparent;
    }
    thead tr {
      background-color: transparent;
    }
    th, td {
      text-align: left;
      padding: 14px 20px;
      font-size: 15px;
      vertical-align: middle;
    }
    th {
      color: #555;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      font-weight: 700;
      border-bottom: 2px solid #ddd;
    }
    tbody tr {
      background-color: white;
      box-shadow: 0 2px 5px rgb(0 0 0 / 0.07);
      border-radius: 8px;
      transition: box-shadow 0.3s ease;
    }
    tbody tr:hover {
      box-shadow: 0 6px 15px rgb(0 0 0 / 0.12);
    }
    /* Action buttons inside table */
    .action-btn {
      background-color: #28a745;
      margin-right: 10px;
      font-size: 13px;
      padding: 6px 14px;
      border-radius: 4px;
      text-decoration: none;
      color: #fff; /* Use white text */
      display: inline-block;
      border: none;
    }
    .action-btn.delete {
      background-color: #dc3545;
      color: #fff; /* Use white text */
      text-decoration: none;
    }
    .action-btn:hover {
      filter: brightness(90%);
    }
    /* Responsive tweaks */
    @media (max-width: 600px) {
      body {
        padding: 20px 15px;
      }
      table, thead, tbody, th, td, tr {
        display: block;
      }
      thead tr {
        display: none;
      }
      tbody tr {
        margin-bottom: 15px;
        box-shadow: none;
        background-color: #fefefe;
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 10px;
      }
      tbody tr td {
        padding: 8px 10px;
        text-align: right;
        font-size: 14px;
        border-bottom: 1px solid #eee;
        position: relative;
      }
      tbody tr td:last-child {
        border-bottom: none;
      }
      tbody tr td::before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 12px;
        color: #666;
        top: 8px;
        text-align: left;
      }
      .action-btn {
        margin: 5px 10px 0 0;
        
      }
      .header-buttons {
        flex-direction: column;
        align-items: stretch;
      }
      .btn {
        width: 100%;
        text-align: center;
      }
    }
  </style>
</head>
<body>
  <h2><center>Admin Dashboard</center></h2>
  <div class="header-buttons">
    <a href="add_article.php" class="btn">Add New Article</a>
    <a href="logout.php" class="btn btn-secondary">Logout</a>
  </div>
  <table>
    <thead>
      <tr>
        <th>Title</th>
        <th style="width: 180px;">Actions</th>
      </tr>
    </thead>
    <tbody>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td data-label="Title"><?php echo htmlspecialchars($row['title']); ?></td>
        <td data-label="Actions">
          <a href="edit_article.php?id=<?php echo $row['id']; ?>" class="action-btn">✏️ Edit</a>
          <a href="delete_article.php?id=<?php echo $row['id']; ?>" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this article?');">🗑️ Delete</a>
        </td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
</body>
</html>

