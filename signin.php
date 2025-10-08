<?php
include "ass4.php";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if ($password == $user['password']) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            header("location: dashboard.php");
            exit();
        } else {
            $error = "❌ كلمة المرور غير صحيحة";
        }
    } else {
        $error = "⚠️ البريد الإلكتروني غير موجود";
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            /* background: linear-gradient(135deg, #4f46e5, #9333ea); */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: #fff;
            width: 90%;
            max-width: 400px;
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
            border-color: #4f46e5;
            box-shadow: 0 0 5px rgba(79, 70, 229, 0.5);
        }

        .btn {
            width: 100%;
            background: #4f46e5;
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
            background: #3730a3;
        }

        .error {
            color: #e11d48;
            background: #fee2e2;
            border-radius: 8px;
            padding: 0.5rem;
            margin-bottom: 1rem;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 1.5rem;
            }

            h2 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>تسجيل الدخول</h2>

        <?php if (!empty($error)) : ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <label for="email">البريد الإلكتروني</label>
            <input type="email" id="email" name="email">

            <label for="password">كلمة المرور</label>
            <input type="password" id="password" name="password" >

            <button type="submit" name="submit" class="btn">تسجيل الدخول</button>
        </form>
    </div>
</body>
</html>
