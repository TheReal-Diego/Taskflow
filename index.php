<?php
require_once __DIR__ . '/db.php';

$stmt = $pdo->query("SELECT * FROM tasks ORDER BY done ASC, (due_date IS NULL), due_date ASC, created_at DESC");
$tasks = $stmt->fetchAll();

$categories = array_values(array_unique(array_column($tasks, 'category')));

$today = date('Y-m-d');
$total = count($tasks);
$doneCount = count(array_filter($tasks, fn($t) => (int)$t['done'] === 1));
$overdueCount = count(array_filter($tasks, fn($t) => (int)$t['done'] === 0 && $t['due_date'] && $t['due_date'] < $today));
$progress = $total > 0 ? round(($doneCount / $total) * 100) : 0;
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow — لیست کارها</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Vazirmatn:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="app">
        <!-- سایدبار: آمار و فیلترها -->
        <aside class="sidebar">
            <div class="brand">
                <span class="brand-mark">◆</span>
                <span class="brand-name">TaskFlow</span>
            </div>

            <div class="progress-block">
                <div class="progress-label">
                    <span>Today's Progress </span>
                    <span class="progress-percent" id="progress-percent"><?php echo $progress; ?>٪</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill" id="progress-fill" style="width: <?php echo $progress; ?>%;"></div>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <span class="stat-num" id="stat-total"><?php echo $total; ?></span>
                    <span class="stat-label"> All Tasks</span>
                </div>
                <div class="stat-card stat-done">
                    <span class="stat-num" id="stat-done"><?php echo $doneCount; ?></span>
                    <span class="stat-label">Completed</span>
                </div>
                <div class="stat-card stat-overdue">
                    <span class="stat-num" id="stat-overdue"><?php echo $overdueCount; ?></span>
                    <span class="stat-label">Overdue</span>
                </div>
            </div>

            <nav class="category-nav" id="category-nav">
                <button class="cat-pill active" data-category="">All</button>
                <?php foreach ($categories as $cat): ?>
                    <button class="cat-pill" data-category="<?php echo htmlspecialchars($cat); ?>">
                        <?php echo htmlspecialchars($cat); ?>
                    </button>
                <?php endforeach; ?>
            </nav>
        </aside>

        <!-- بخش اصلی -->
        <main class="main">
            <header class="main-header">
                <h1>Today's Tasks</h1>
                <p class="subtitle">Write down everything you need to do here</p>
            </header>

            <form id="add-form" class="add-form">
                <div class="add-form-row">
                    <input type="text" id="task-input" placeholder="   Add a new task..." required>
                </div>
                <div class="add-form-row add-form-meta">
                    <input type="text" id="category-input" placeholder="Category" list="category-list">
                    <datalist id="category-list">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat); ?>">
                        <?php endforeach; ?>
                    </datalist>
                    <input type="date" id="due-date-input" title="تاریخ سررسید">
                    <button type="submit" class="add-btn">
                        <span>Add</span>
                    </button>
                </div>
            </form>

            <ul id="task-list" class="task-list">
                <?php foreach ($tasks as $task): ?>
                    <?php $isOverdue = !$task['done'] && $task['due_date'] && $task['due_date'] < $today; ?>
                    <li class="task-item <?php echo $task['done'] ? 'done' : ''; ?>"
                        data-id="<?php echo $task['id']; ?>"
                        data-category="<?php echo htmlspecialchars($task['category']); ?>">

                        <button class="check-btn <?php echo $task['done'] ? 'checked' : ''; ?>" aria-label="تیک بزن">
                            <svg viewBox="0 0 24 24" class="check-icon">
                                <path d="M4 12.5L9.5 18L20 6" />
                            </svg>
                        </button>

                        <div class="task-body">
                            <span class="task-text"><?php echo htmlspecialchars($task['text']); ?></span>
                            <div class="task-meta">
                                <span class="badge category-badge"><?php echo htmlspecialchars($task['category']); ?></span>
                                <?php if ($task['due_date']): ?>
                                    <span class="badge date-badge <?php echo $isOverdue ? 'overdue' : ''; ?>">
                                        <?php echo $isOverdue ? '⚠' : '📅'; ?> <?php echo htmlspecialchars($task['due_date']); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <button class="delete-btn" aria-label="حذف">
                            <svg viewBox="0 0 24 24"><path d="M6 6L18 18M6 18L18 6" /></svg>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div id="empty-msg" class="empty-state" style="<?php echo count($tasks) ? 'display:none;' : ''; ?>">
                <svg viewBox="0 0 120 120" class="empty-illustration">
                    <circle cx="60" cy="60" r="46" fill="none" stroke="currentColor" stroke-width="2" opacity="0.25"/>
                    <path d="M40 62l14 14 26-30" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" opacity="0.5"/>
                </svg>
                <p>Your list is empty. Add a new task!</p>
            </div>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
