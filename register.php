<?php
include "ass4.php";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$pass')";

    if ($conn->query($sql)) {
        $success = "تم إنشاء الحساب بنجاح!";
    } else {
        $error = "لم يتم تسجيل الحساب: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل حساب جديد</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            /* background: linear-gradient(135deg, #9333ea, #4f46e5); */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-container {
            background: #fff;
            width: 90%;
            max-width: 420px;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        h2 {
            margin-bottom: 1.5rem;
            color: #4f46e5;
        }

        label {
            display: block;
            text-align: right;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 600;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1.2rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: #9333ea;
            box-shadow: 0 0 5px rgba(147, 51, 234, 0.5);
        }

        .btn {
            width: 100%;
            background: #9333ea;
            color: #fff;
            border: none;
            padding: 0.8rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn:hover {
            background: #7e22ce;
        }

        .error, .success {
            border-radius: 8px;
            padding: 0.5rem;
            margin-bottom: 1rem;
            font-weight: bold;
        }

        .error {
            color: #e11d48;
            background: #fee2e2;
        }

        .success {
            color: #16a34a;
            background: #dcfce7;
        }

        p {
            margin-top: 1rem;
        }

        a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 1.5rem;
            }

            h2 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>إنشاء حساب جديد</h2>

        <?php if (!empty($error)) : ?>
            <div class="error"><?= $error ?></div>
        <?php elseif (!empty($success)) : ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <label for="name">اسم المستخدم</label>
            <input type="text" id="name" name="name" placeholder="اكتب اسمك">

            <label for="email">البريد الإلكتروني</label>
            <input type="email" id="email" name="email" placeholder="اكتب بريدك الإلكتروني">

            <label for="password">كلمة المرور</label>
            <input type="password" id="password" name="password" placeholder="أدخل كلمة المرور">

            <button type="submit" name="submit" class="btn">تسجيل</button>
        </form>

        <p>هل لديك حساب بالفعل؟ <a href="signin.php">تسجيل الدخول</a></p>
    </div>
</body>
</html>
