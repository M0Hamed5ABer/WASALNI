<?php
session_start();

// لو الأدمن مسجل دخول، نروح للداشبورد مباشرة
if (isset($_SESSION['admin'])) {
    header("Location: admin_dashboard.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // بيانات ثابتة مؤقتة (ممكن بعدين من DB)
    if ($username === "mohamed saber" && $password === "M1n2b3v4512003@") {
        $_SESSION['admin'] = true;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "اسم المستخدم أو كلمة المرور غير صحيحة";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css" />
<title>تسجيل دخول الأدمن</title>
<style>
.form-group {
    background:#fff;
    padding:20px;
    border-radius:10px;
}
.error {
    color:red;
}
input {
    width: 100%;
    margin: 5px 0;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s;
}

input:focus {
    outline: none;
    border-color: var(--primary-color);
}
button {
    width: 100%;
    padding: 14px;
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: bold;
    cursor: pointer;
    margin-top: 10px;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #005bb5;
}
</style>
</head>
<body>

<form class="form-group" method="POST">
    <h3>تسجيل دخول الأدمن</h3>
    <?php if($error) echo "<p class='error'>$error</p>"; ?>
    <input type="text" name="username" placeholder="اسم المستخدم" required>
    <input type="password" name="password" placeholder="كلمة المرور" required>
    <button type="submit">دخول</button>
</form>

</body>
</html>