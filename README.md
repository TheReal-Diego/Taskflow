<div align="center">

# ◆ TaskFlow

**A dark, gold-accented task manager built with PHP, MySQL & vanilla JS**

![PHP](https://img.shields.io/badge/PHP-8.x-12141C?style=for-the-badge&logo=php&logoColor=F2B84B)
![MySQL](https://img.shields.io/badge/MySQL-8.x-12141C?style=for-the-badge&logo=mysql&logoColor=F2B84B)
![JavaScript](https://img.shields.io/badge/JavaScript-Vanilla-12141C?style=for-the-badge&logo=javascript&logoColor=F2B84B)
![License](https://img.shields.io/badge/LICENSE-MIT-12141C?style=for-the-badge&logoColor=F2B84B)

</div>

---

## ✨ Overview

TaskFlow is a self-hosted daily task manager with a dashboard-style interface — deep charcoal background, a warm amber accent, and a teal highlight for completed tasks. No frontend framework, no build step: just PHP, MySQL, and vanilla JS talking to each other over a small JSON API.

## 🖤 Features

| | |
|---|---|
| ✅ **Instant task actions** | Add, complete, and delete tasks with zero page reloads (AJAX) |
| 🏷️ **Categories** | Tag tasks and filter by category with one click |
| 📅 **Due dates** | Automatic overdue warnings on the task card |
| 📊 **Live progress** | A gold-to-teal progress bar and stat cards that update in real time |
| 🎨 **Custom UI** | Hand-built dark dashboard theme, no CSS framework |
| 🔒 **Secure by default** | PDO + prepared statements, credentials kept out of git |

## 🛠️ Requirements

- PHP 8.0+
- MySQL or MariaDB
- A local server stack — XAMPP, WAMP, or Laragon all work fine

## 🚀 Setup

**1. Clone the repo**
```bash
git clone https://github.com/YOUR_USERNAME/taskflow.git
cd taskflow
```

**2. Create the database**

Run `schema.sql` against your MySQL server (via phpMyAdmin's SQL tab, or the CLI):
```bash
mysql -u root -p < schema.sql
```

**3. Set up your local credentials**

`db.php` is intentionally **not** included in this repo (see [Security](#-security) below). Copy the example file and fill in your own values:
```bash
cp db.example.php db.php
```
Then edit `db.php`:
```php
$host     = 'localhost';
$dbname   = 'todo_app';
$username = 'root';
$password = 'your_real_password';
```

**4. Serve the project**

Drop the folder into your server's document root (e.g. `htdocs/taskflow` for XAMPP), then visit:
```
http://localhost/taskflow/
```

## 📁 Project structure

```
taskflow/
├── index.php        → Main page (server-rendered)
├── api.php          → JSON API for add/toggle/delete
├── db.php           → Your local DB connection (gitignored, not in repo)
├── db.example.php    → Template for db.php — copy this one
├── schema.sql        → Database + table creation script
├── style.css         → Dashboard theme styles
├── script.js         → Client-side logic (AJAX + UI state)
└── .gitignore
```

## 🔒 Security

This repo is set up so you can push it publicly without leaking anything:

- `db.php` holds your real database credentials and is listed in `.gitignore` — it will **never** be committed.
- `db.example.php` is the safe, credential-free template that ships in the repo instead.
- All database queries go through **PDO prepared statements**, so user input is never concatenated directly into SQL.

Before deploying anywhere public-facing (not just local dev), also make sure to:
- Use a strong, unique MySQL password — never `root` with an empty password in production.
- Restrict the MySQL user's privileges to just this database.
- Serve the app over HTTPS.

## 📄 License

MIT — free to use, modify, and share.
