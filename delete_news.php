<?php
include 'ass4.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $query = "UPDATE news SET is_deleted = 1 WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        header("Location: shownews.php?msg=deleted"); 
        exit;
    } else {
        echo "حدث خطأ أثناء حذف الخبر: " . mysqli_error($conn);
    }
} else {
    echo "طلب غير صالح.";
}
?>