<?php
include 'ass4.php';

$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>عرض الفئات</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f2f2f2;
      display: flex;
    }

    .sidebar {
      width: 220px;
      background: linear-gradient(135deg, #4f46e5, #9333ea);
      padding: 20px;
      color: white;
      height: 100vh;
      position: fixed;
      right: 0;
      top: 0;
    }

    .sidebar h2 {
      text-align: center;
      margin-bottom: 30px;
    }

    .sidebar a {
      display: block;
      color: white;
      text-decoration: none;
      padding: 10px;
      border-radius: 4px;
      margin-bottom: 8px;
    }

    .sidebar a.active, .sidebar a:hover {
      background: #2563eb;
    }

    .main-content {
      margin-right: 240px;
      padding: 30px;
      flex: 1;
    }

    h1 {
      color: #333;
      margin-bottom: 20px;
    }

    .cards {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .card {
      background: white;
      padding: 15px 20px;
      border-radius: 6px;
      box-shadow: 0 0 5px #ccc;
      flex: 1 1 calc(33.33% - 20px);
      min-width: 250px;
    }

    .card h3 {
      margin: 0 0 10px 0;
      color: #007bff;
    }

    .card p {
      color: #555;
      font-size: 14px;
    }

    .card small {
      display: block;
      margin-top: 10px;
      color: #888;
      font-size: 12px;
    }

    @media (max-width: 768px) {
      .card {
        flex: 1 1 calc(50% - 20px);
      }
    }

    @media (max-width: 500px) {
      .card {
        flex: 1 1 100%;
      }
    }
  </style>
</head>
<body>

  <div class="main-content">
      <h1>جميع الفئات</h1>

      <div class="cards">
        <?php if(mysqli_num_rows($categories) > 0): ?>
          <?php while($cat = mysqli_fetch_assoc($categories)): ?>
            <div class="card">
              <h3><?php echo $cat['name']; ?></h3>
              <p><?php echo $cat['description']; ?></p>
              <small>تاريخ الإنشاء: <?php echo date("Y-m-d H:i", strtotime($cat['created_at'])); ?></small>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p>لا توجد فئات حالياً.</p>
        <?php endif; ?>
      </div>
  </div>

     <div class="sidebar">
    <h2>لوحة التحكم</h2>
    <a href="dashboard.php"> الرئيسية</a>
    <a href="category.php"> إضافة فئة</a>
    <a href="show_categories.php"> عرض الفئات</a>
    <a href="shownews.php"> عرض الأخبار</a>
    <a href="news_form.php"> إضافة خبر</a>
    <a href="deleted_news.php" class="active"> الأخبار المحذوفة</a>
  </div>
</body>
</html>
