-- ساخت دیتابیس
CREATE DATABASE IF NOT EXISTS todo_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE todo_app;

-- ساخت جدول کارها
CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    text VARCHAR(255) NOT NULL,
    category VARCHAR(50) DEFAULT 'عمومی',
    due_date DATE NULL,
    done TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- چند نمونه کار برای تست (اختیاری)
INSERT INTO tasks (text, category, due_date, done) VALUES
('خرید نان و شیر', 'شخصی', '2026-07-10', 0),
('تحویل پروژه PHP', 'کاری', '2026-07-08', 0),
('تماشای فیلم جدید', 'شخصی', NULL, 1);
