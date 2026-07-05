<?php
// تنظیمات اتصال به دیتابیس - این مقادیر رو با تنظیمات خودت جایگزین کن
$host = 'localhost';
$dbname = 'todo_app';
$username = 'root';
$password = ''; // رمز عبور MySQL خودت رو اینجا بذار

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die(json_encode(['success' => false, 'error' => 'خطا در اتصال به دیتابیس: ' . $e->getMessage()]));
}
