<?php
include 'ass4.php';


$id = intval($_GET['id']);

$query = mysqli_query($conn, "
  SELECT * FROM news WHERE id = $id AND is_deleted = 0
");
$news = mysqli_fetch_assoc($query);

if (!$news) {
  die("الخبر غير موجود أو محذوف.");
}

if (isset($_POST['submit'])) {
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $content = mysqli_real_escape_string($conn, $_POST['content']);
  $category_id = intval($_POST['category_id']);

  $image = $news['image'];
  if (!empty($_FILES['image']['name'])) {
    $target_dir = "uploads/";
    $image = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $image);
  }

  $update_query = "
    UPDATE news 
    SET title='$title', content='$content', image='$image', category_id='$category_id'
    WHERE id=$id
  ";

  if (mysqli_query($conn, $update_query)) {
    header("Location: shownews.php?msg=updated");
    exit;
  } else {
    echo "حدث خطأ أثناء التعديل: " . mysqli_error($conn);
  }
}

$cats = mysqli_query($conn, "SELECT id, name FROM categories");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title> تعديل الخبر</title>
  <style>
    body {
      font-family: "Tahoma", sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      display: flex;
    }

    .sidebar {
      width: 250px;
      background-color: #1e293b;
      color: white;
      height: 100vh;
      padding: 20px;
      position: fixed;
      right: 0;
    }

    .sidebar h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .sidebar a {
      display: block;
      color: white;
      text-decoration: none;
      margin: 10px 0;
      padding: 8px;
      border-radius: 5px;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: #334155;
    }

    .main-content {
      flex: 1;
      padding: 30px;
      margin-right: 270px;
    }

    form {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      max-width: 600px;
      margin: auto;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin: 10px 0 5px;
    }

    input[type="text"],
    textarea,
    select {
      width: 100%;
      padding: 8px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    button {
      background-color: #2563eb;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      margin-top: 10px;
      cursor: pointer;
    }

    button:hover {
      background-color: #1e40af;
    }

    img {
      max-width: 100%;
      border-radius: 5px;
      margin-top: 10px;
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
    <a href="deleted_news.php"> الأخبار المحذوفة</a>
  </div>

  <div class="main-content">
    <form action="" method="POST" enctype="multipart/form-data">
      <h2> تعديل الخبر</h2>

      <label for="title">عنوان الخبر</label>
      <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($news['title']); ?>" required>

      <label for="content">محتوى الخبر</label>
      <textarea id="content" name="content" rows="6" required><?php echo htmlspecialchars($news['content']); ?></textarea>

      <label for="image">صورة الخبر</label>
      <?php if (!empty($news['image'])): ?>
        <img src="<?php echo $news['image']; ?>" alt="صورة الخبر الحالية">
      <?php endif; ?>
      <input type="file" id="image" name="image" accept="image/*">

      <label for="category_id">الفئة</label>
      <select id="category_id" name="category_id" required>
        <option value="">-- اختر الفئة --</option>
        <?php while ($cat = mysqli_fetch_assoc($cats)): ?>
          <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $news['category_id']) ? 'selected' : ''; ?>>
            <?php echo $cat['name']; ?>
          </option>
        <?php endwhile; ?>
      </select>

      <button type="submit" name="submit"> حفظ التعديلات</button>
    </form>
  </div>

</body>
</html>
