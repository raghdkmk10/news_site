<?php
include 'ass4.php';


$sql = "SELECT news.*, categories.name AS category_name
  FROM news
  LEFT JOIN categories ON news.category_id = categories.id
  WHERE news.is_deleted = 0
  ORDER BY news.created_at DESC";
$news_result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>عرض الأخبار</title>
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

    /* Main Content */
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

    .card img {
      width: 100%;
      max-height: 150px;
      object-fit: cover;
      margin-bottom: 10px;
      border-radius: 4px;
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

    .btns {
  display: flex;
  justify-content: space-between;
  margin-top: 10px;
}

.edit, .delete {
  padding: 6px 12px;
  border: none;
  border-radius: 5px;
  text-decoration: none;
  cursor: pointer;
  font-size: 13px;
  color: white;
}

.edit {
  background-color: #2563eb;
}

.edit:hover {
  background-color: #1e40af;
}

.delete {
  background-color: #dc2626;
}

.delete:hover {
  background-color: #b91c1c;
}


  </style>
</head>
<body>

  <div class="main-content">
      <h1> جميع الأخبار</h1>

    <div class="cards">
  <?php if(mysqli_num_rows($news_result) > 0): ?>
    <?php while($news = mysqli_fetch_assoc($news_result)): ?>
      <div class="card">
        <h3><?php echo $news['title']; ?></h3>
        
        <?php if(!empty($news['image'])): ?>
          <img src="<?php echo $news['image']; ?>" alt="صورة الخبر" style="width:100%;border-radius:5px;margin:10px 0;">
        <?php endif; ?>

        <p><?php echo $news['content']; ?></p>
        <small>الفئة: <?php echo $news['category_name'] ?? 'غير محددة'; ?></small>

        <div class="btns">
          <a href="edit_news.php?id=<?php echo $news['id']; ?>" class="edit">تعديل</a>
          <form action="delete_news.php" method="POST" style="display:inline;">
            <input type="hidden" name="id" value="<?php echo $news['id']; ?>">
            <button type="submit" class="delete" onclick="return confirm('هل تريد حذف هذا الخبر؟')">حذف</button>
          </form>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>لا توجد أخبار حالياً.</p>
  <?php endif; ?>
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
