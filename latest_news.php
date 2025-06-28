<?php
include __DIR__ . '/../db/config.php';

echo '<div style="display: grid; gap: 20px;">';
while ($row = mysqli_fetch_assoc($result)) {
  echo '<div style="background: #fff; border: 1px solid #ddd; padding: 15px; border-radius: 8px;">';
  echo '<h3 style="margin-top:0;">' . htmlspecialchars($row['title']) . '</h3>';
  echo '<p>' . htmlspecialchars(substr($row['content'], 0, 150)) . '...</p>';
  echo '<small>Published: ' . $row['created_at'] . '</small>';
  echo '</div>';
}
echo '</div>';
?>
