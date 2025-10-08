<?php
 include "ass4.php";


if (isset($_POST['submit'])) {
    $name = $_POST['category_name'];
    $description = $_POST['description'];

    $sql = "INSERT INTO categories (name, description) VALUES ('$name', '$description')";

    if (mysqli_query($conn, $sql)) {
        echo "<p style='color: green;'> تم إضافة الفئة بنجاح!</p>";
    } else {
        echo "<p style='color: red;'> حدث خطأ أثناء إضافة الفئة: " . mysqli_error($conn) . "</p>";
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>إضافة فئة</title>
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

  <div class="main-content">
      <h1>إضافة فئة جديدة</h1>

      <form action="" method="POST">
          <label for="category_name">اسم الفئة</label>
          <input type="text" id="category_name" name="category_name" placeholder="مثلاً: رياضة، سياسة..." required>

          <label for="description">وصف الفئة</label>
          <textarea id="description" name="description" placeholder="أدخل وصفاً مختصراً عن الفئة..." required></textarea>

          <button type="submit" name="submit"> حفظ الفئة</button>
      </form>
  </div>

<div class="sidebar">
      <h2>لوحة التحكم</h2>
      <a href="dashboard.php" class="active"> الرئيسية</a>
      <a href="category.php"> إضافة فئة</a>
      <a href="show_categories.php">عرض الفئات</a>
      <a href="shownews.php">عرض الأخبار</a>
      <a href="news_form.php"> إضافة خبر</a>
      <a href="#"> الأخبار المحذوفة</a>
  </div>

</body>
</html>

