
<?php
include "ass4.php";
$count_query = mysqli_query($conn, "SELECT COUNT(*) AS total_news FROM news WHERE is_deleted = 0");
$count_result = mysqli_fetch_assoc($count_query);
$total_news = $count_result['total_news'];

$count_cate=mysqli_query($conn,"SELECT COUNT(*) AS total_cate FROM categories");
$count_resultcate=mysqli_fetch_assoc($count_cate);
$total_cate=$count_resultcate['total_cate'];

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: "Cairo", sans-serif;
        }

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

        .main-content {
            flex: 1;
            margin-right: 260px;
            padding: 2rem;
        }

        .main-content h1 {
            color: #4f46e5;
            margin-bottom: 1rem;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 1.5rem;
        }

        .card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            color: #9333ea;
            margin-bottom: 0.5rem;
        }

        .card p {
            color: #555;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                width: 100%;
                height: auto;
                flex-direction: row;
                justify-content: space-around;
                padding: 0.5rem;
            }

            .sidebar h2 {
                display: none;
            }

            .sidebar a {
                margin: 0;
                padding: 0.5rem;
                font-size: 0.9rem;
            }

            .main-content {
                margin-right: 0;
                margin-top: 70px;
                padding: 1rem;
            }

            .cards {
                grid-template-columns: 1fr;
            }
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
        <h1>مرحباً بك في لوحة التحكم</h1>
        <p>هنا يمكنك إدارة الفئات والأخبار في النظام بسهولة.</p>

        <div class="cards">
            <div class="card">
                <h3>عدد الفئات</h3>
                <p><?php echo $total_cate ?></p>
            </div>
            <div class="card">
                <h3>عدد الأخبار</h3>
                <p><?php echo $total_news ?></p>
    </div>
