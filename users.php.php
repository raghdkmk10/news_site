<?php
$host = "localhost";
$dbname = "news_system";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("فشل الاتصال: " . $e->getMessage());
}
?>

<?php
session_start();
include "db.php";

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password']);

    $stmt = $conn->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
    $stmt->execute([$name, $email, $password]);

    echo "تم التسجيل بنجاح ✔ <a href='login.php'>تسجيل الدخول</a>";
}
?>
<form method="post">
    <input type="text" name="name" placeholder="الاسم" required><br>
    <input type="email" name="email" placeholder="الإيميل" required><br>
    <input type="password" name="password" placeholder="كلمة المرور" required><br>
    <button type="submit" name="register">تسجيل</button>
</form>

<?php
session_start();
include "db.php";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: dashboard.php");
        exit;
    } else {
        echo "❌ خطأ في تسجيل الدخول";
    }
}
?>
<form method="post">
    <input type="email" name="email" placeholder="الإيميل"><br>
    <input type="password" name="password" placeholder="كلمة المرور"><br>
    <button type="submit" name="login">دخول</button>
</form>

<?php
session_start();
if(!isset($_SESSION['user_id'])){ header("Location: login.php"); exit; }
?>
<h2>مرحباً، <?= $_SESSION['user_name'] ?></h2>
<ul>
    <li><a href="add_category.php"> إضافة فئة</a></li>
    <li><a href="categories.php"> عرض الفئات</a></li>
    <li><a href="add_news.php"> إضافة خبر</a></li>
    <li><a href="news.php">عرض الأخبار</a></li>
    <li><a href="deleted_news.php">🗑 الأخبار المحذوفة</a></li>
    <li><a href="logout.php"> تسجيل خروج</a></li>
</ul>

<?php
session_start();
include "db.php";
if(isset($_POST['save'])){
    $stmt=$conn->prepare("INSERT INTO categories(category_name) VALUES(?)");
    $stmt->execute([$_POST['category_name']]);
    echo "✔ تمت إضافة الفئة";
}
?>
<form method="post">
    <input type="text" name="category_name" placeholder="اسم الفئة">
    <button type="submit" name="save">حفظ</button>
</form>

<?php
include "db.php";
$cats = $conn->query("SELECT * FROM categories");
echo "<table border=1><tr><th>ID</th><th>الاسم</th></tr>";
foreach($cats as $c){
    echo "<tr><td>".$c['id']."</td><td>".$c['category_name']."</td></tr>";
}
echo "</table>";

session_start();
include "db.php";
if(isset($_POST['save'])){
    $title=$_POST['title'];
    $details=$_POST['details'];
    $category_id=$_POST['category_id'];
    $user_id=$_SESSION['user_id'];

    $image=$_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'],"uploads/".$image);

    $stmt=$conn->prepare("INSERT INTO news(title,details,image,category_id,user_id) VALUES(?,?,?,?,?)");
    $stmt->execute([$title,$details,$image,$category_id,$user_id]);

    echo "✔ تمت إضافة الخبر";
}
?>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="عنوان الخبر"><br>
    <textarea name="details" placeholder="تفاصيل الخبر"></textarea><br>
    <select name="category_id">
        <?php
        $cats=$conn->query("SELECT * FROM categories");
        foreach($cats as $c){ echo "<option value='".$c['id']."'>".$c['category_name']."</option>"; }
        ?>
    </select><br>
    <input type="file" name="image"><br>
    <button type="submit" name="save">إضافة</button>
</form>

<?php
include "db.php";
$news=$conn->query("SELECT news.*, categories.category_name, users.name as uname 
FROM news 
JOIN categories ON news.category_id=categories.id 
JOIN users ON news.user_id=users.id 
WHERE news.is_deleted=0");

echo "<table border=1>
<tr><th>العنوان</th><th>الفئة</th><th>التفاصيل</th><th>الصورة</th><th>الكاتب</th><th>تعديل</th><th>حذف</th></tr>";
foreach($news as $n){
    echo "<tr>
    <td>".$n['title']."</td>
    <td>".$n['category_name']."</td>
    <td>".$n['details']."</td>
    <td><img src='uploads/".$n['image']."' width='100'></td>
    <td>".$n['uname']."</td>
    <td><a href='edit_news.php?id=".$n['id']."'>✏ تعديل</a></td>
    <td><a href='delete_news.php?id=".$n['id']."'>❌ حذف</a></td>
    </tr>";
}
echo "</table>";

<?php
include "db.php";
$id=$_GET['id'];
$stmt=$conn->prepare("SELECT * FROM news WHERE id=?");
$stmt->execute([$id]);
$news=$stmt->fetch();

if(isset($_POST['update'])){
    $title=$_POST['title'];
    $details=$_POST['details'];
    $conn->prepare("UPDATE news SET title=?,details=? WHERE id=?")->execute([$title,$details,$id]);
    header("Location: news.php");
}
?>
<form method="post">
    <input type="text" name="title" value="<?= $news['title'] ?>"><br>
    <textarea name="details"><?= $news['details'] ?></textarea><br>
    <button type="submit" name="update">تحديث</button>
</form>

<?php
include "db.php";
$id=$_GET['id'];
$conn->prepare("UPDATE news SET is_deleted=1 WHERE id=?")->execute([$id]);
header("Location: news.php");

<?php
include "db.php";
$news=$conn->query("SELECT * FROM news WHERE is_deleted=1");
echo "<table border=1><tr><th>العنوان</th><th>التفاصيل</th></tr>";
foreach($news as $n){
    echo "<tr><td>".$n['title']."</td><td>".$n['details']."</td></tr>";
}
echo "</table>";

<?php
session_start();
session_destroy();
header("Location: login.php");
