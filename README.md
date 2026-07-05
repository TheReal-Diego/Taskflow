# 📝 TaskFlow

یه اپلیکیشن مدیریت کارهای روزانه با **PHP + MySQL + Vanilla JS**، با طراحی داشبورد شبانه، دسته‌بندی، تاریخ سررسید و آمار زنده‌ی پیشرفت.

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/license-MIT-blue)

## ✨ امکانات

- ✅ افزودن، ویرایش وضعیت (انجام‌شده/نشده) و حذف کارها بدون رفرش صفحه (AJAX)
- 🏷️ دسته‌بندی کارها با پیشنهاد خودکار دسته‌های قبلی
- 📅 تاریخ سررسید با هشدار خودکار برای کارهای عقب‌افتاده
- 📊 نوار پیشرفت و آمار زنده (کل کارها / انجام‌شده / عقب‌افتاده)
- 🔍 فیلتر سریع بر اساس دسته‌بندی
- 🎨 طراحی اختصاصی با تم داشبورد شبانه (بدون فریمورک CSS)
- 🔒 اتصال امن به دیتابیس با PDO + Prepared Statements

## 🛠️ پیش‌نیازها

- PHP 8 یا بالاتر
- MySQL / MariaDB
- یک سرور محلی مثل XAMPP، WAMP یا Laragon

## 🚀 راه‌اندازی

1. این پروژه رو کلون کن یا دانلود کن:
   ```bash
   git clone https://github.com/USERNAME/taskflow.git
   ```

2. فایل `schema.sql` رو در MySQL اجرا کن (مثلاً از طریق phpMyAdmin، تب SQL):
   ```bash
   mysql -u root -p < schema.sql
   ```

3. فایل `db.php` رو باز کن و اطلاعات اتصال دیتابیس خودت رو وارد کن:
   ```php
   $host = 'localhost';
   $dbname = 'todo_app';
   $username = 'root';
   $password = '';
   ```

4. پروژه رو داخل پوشه‌ی سرور محلی‌ات کپی کن (مثلاً `htdocs` برای XAMPP) و برو به:
   ```
   http://localhost/taskflow/
   ```

## 📁 ساختار پروژه

```
taskflow/
├── index.php      → صفحه اصلی (رندر سمت سرور)
├── api.php        → API داخلی برای افزودن/حذف/تیک زدن (JSON)
├── db.php         → اتصال به دیتابیس با PDO
├── schema.sql      → اسکریپت ساخت دیتابیس و جدول
├── style.css       → استایل‌ها
└── script.js       → منطق سمت کلاینت (AJAX + رابط کاربری)
```

## ⚠️ نکته امنیتی

فایل `db.php` شامل اطلاعات اتصال دیتابیس (مثل رمز عبور) است. قبل از عمومی کردن ریپازیتوری، حتماً:
- از رمز عبور واقعی و قوی برای دیتابیس پروداکشن استفاده کن
- در نظر بگیر که `db.php` رو به `.gitignore` اضافه کنی و یه نسخه‌ی نمونه (`db.example.php`) بدون اطلاعات حساس نگه داری

## 📄 لایسنس

MIT — آزاد برای استفاده و تغییر.
