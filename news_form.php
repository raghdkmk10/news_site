<?php
include 'ass4.php';

if (isset($_POST['submit'])) {
  session_start();
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];
    $user_id =$_SESSION['user_id'];;

    $image = "";
    if (!empty($_FILES['image']['name'])) {
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir);
        }
        $image = $upload_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image);
    }

    $sql = "INSERT INTO news (title, content, image, category_id, user_id, created_at)
            VALUES ('$title', '$content', '$image', '$category_id', '$user_id', NOW())";

    if (mysqli_query($conn, $sql)) {
        echo "<p style='color:green; text-align:center;'> تم حفظ الخبر بنجاح!</p>";
    } else {
        echo "<p style='color:red; text-align:center;'> خطأ أثناء الحفظ!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>إضافة خبر جديد</title>
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
    }

    .cards {
      display: flex;
      gap: 20px;
      margin: 20px 0;
    }

    .card {
      background: white;
      padding: 20px;
      border-radius: 6px;
      box-shadow: 0 0 5px #ccc;
      flex: 1;
      text-align: center;
    }

    /* Form */
    form {
      background: #fff;
      padding: 20px;
      border-radius: 6px;
      box-shadow: 0 0 5px #ccc;
      max-width: 500px;
    }

    form label {
      display: block;
      margin-bottom: 5px;
      color: #333;
      font-weight: bold;
    }

    form input, form textarea, form select {
      width: 100%;
      padding: 8px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
    }

    form button {
      background: #007bff;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    form button:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>

  <!-- Main Content -->
  <div class="main-content">
      <h1> إضافة خبر جديد</h1>

      <!-- الفورم -->
      <form action="" method="POST" enctype="multipart/form-data">
          <label for="title">عنوان الخبر</label>
          <input type="text" id="title" name="title" placeholder="أدخل عنوان الخبر" required>

          <label for="content">محتوى الخبر</label>
          <textarea id="content" name="content" placeholder="أدخل نص الخبر..." required></textarea>

          <label for="image">صورة الخبر</label>
          <input type="file" id="image" name="image" accept="image/*">

          <label for="category_id">الفئة</label>
          <select id="category_id" name="category_id" required>
            <option value="">-- اختر الفئة --</option>
            <?php
              $cats = mysqli_query($conn, "SELECT id, name FROM categories");
              while ($cat = mysqli_fetch_assoc($cats)) {
                  echo "<option value='{$cat['id']}'>{$cat['name']}</option>";
              }
            ?>
          </select>

          <button type="submit" name="submit"> حفظ الخبر</button>
      </form>
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