<?php
include 'ass4.php';

$deleted_news = mysqli_query($conn, "
  SELECT news.*, categories.name AS category_name 
  FROM news
  LEFT JOIN categories ON news.category_id = categories.id
  WHERE news.is_deleted = 1
  ORDER BY news.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title> الأخبار المحذوفة</title>
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

    
    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 15px;
    }

    .card {
      background: #fff;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .card h3 {
      margin-bottom: 10px;
      color: #333;
    }

    .card img {
      width: 100%;
      border-radius: 5px;
      margin: 10px 0;
    }

    .card small {
      display: block;
      color: #666;
      margin-top: 5px;
    }

    .btns {
      display: flex;
      justify-content: space-between;
      margin-top: 10px;
    }

    .restore {
      background-color: #16a34a;
      color: white;
      padding: 6px 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .restore:hover {
      background-color: #15803d;
    }

    .delete {
      background-color: #dc2626;
      color: white;
      padding: 6px 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .delete:hover {
      background-color: #b91c1c;
    }
  </style>
</head>
<body>

  <div class="sidebar">
    <h2>لوحة التحكم</h2>
    <a href="dashboard.php"> الرئيسية</a>
    <a href="category.php"> إضافة فئة</a>
    <a href="show_categories.php"> عرض الفئات</a>
    <a href="shownews.php"> عرض الأخبار</a>
    <a href="news_form.php"> إضافة خبر</a>
    <a href="deleted_news.php" class="active"> الأخبار المحذوفة</a>
  </div>

  <div class="main-content">
    <h1> الأخبار المحذوفة</h1>
    <div class="cards">
      <?php if(mysqli_num_rows($deleted_news) > 0): ?>
        <?php while($news = mysqli_fetch_assoc($deleted_news)): ?>
          <div class="card">
            <h3><?php echo $news['title']; ?></h3>

            <?php if(!empty($news['image'])): ?>
              <img src="<?php echo $news['image']; ?>" alt="صورة الخبر">
            <?php endif; ?>

            <p><?php echo $news['content']; ?></p>
            <small>الفئة: <?php echo $news['category_name'] ?? 'غير محددة'; ?></small>
            <small>تاريخ الإنشاء: <?php echo date("Y-m-d", strtotime($news['created_at'])); ?></small>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>لا توجد أخبار محذوفة حالياً.</p>
      <?php endif; ?>
    </div>
  </div>

</body>
</html>