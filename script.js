const form = document.getElementById('add-form');
const input = document.getElementById('task-input');
const categoryInput = document.getElementById('category-input');
const dueDateInput = document.getElementById('due-date-input');
const categoryNav = document.getElementById('category-nav');
const list = document.getElementById('task-list');
const emptyMsg = document.getElementById('empty-msg');

const progressFill = document.getElementById('progress-fill');
const progressPercent = document.getElementById('progress-percent');
const statTotal = document.getElementById('stat-total');
const statDone = document.getElementById('stat-done');
const statOverdue = document.getElementById('stat-overdue');

let activeCategory = '';

async function callApi(action, data = {}) {
    const res = await fetch('api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action, ...data })
    });
    return res.json();
}

function todayStr() {
    return new Date().toISOString().split('T')[0];
}

function isOverdue(dueDate, done) {
    return !!dueDate && !done && dueDate < todayStr();
}

// آپدیت آمار سایدبار بر اساس آیتم‌های واقعی توی DOM
function updateStats() {
    const items = [...list.children];
    const total = items.length;
    const doneItems = items.filter(li => li.classList.contains('done'));
    const overdueItems = items.filter(li => {
        const dateBadge = li.querySelector('.date-badge');
        return dateBadge && dateBadge.classList.contains('overdue');
    });

    const doneCount = doneItems.length;
    const overdueCount = overdueItems.length;
    const progress = total > 0 ? Math.round((doneCount / total) * 100) : 0;

    statTotal.textContent = total;
    statDone.textContent = doneCount;
    statOverdue.textContent = overdueCount;
    progressFill.style.width = progress + '%';
    progressPercent.textContent = progress + '٪';
}

function applyFilter() {
    const items = [...list.children];
    let visibleCount = 0;
    items.forEach(li => {
        const show = !activeCategory || li.dataset.category === activeCategory;
        li.style.display = show ? '' : 'none';
        if (show) visibleCount++;
    });
    emptyMsg.style.display = visibleCount ? 'none' : 'block';
}

function createTaskElement(task) {
    const li = document.createElement('li');
    const done = Number(task.done) === 1;
    li.className = 'task-item' + (done ? ' done' : '');
    li.dataset.id = task.id;
    li.dataset.category = task.category;

    const overdue = isOverdue(task.due_date, done);

    li.innerHTML = `
        <button class="check-btn ${done ? 'checked' : ''}" aria-label="تیک بزن">
            <svg viewBox="0 0 24 24" class="check-icon">
                <path d="M4 12.5L9.5 18L20 6" />
            </svg>
        </button>
        <div class="task-body">
            <span class="task-text"></span>
            <div class="task-meta">
                <span class="badge category-badge"></span>
                ${task.due_date ? `<span class="badge date-badge ${overdue ? 'overdue' : ''}">${overdue ? '⚠' : '📅'} ${task.due_date}</span>` : ''}
            </div>
        </div>
        <button class="delete-btn" aria-label="حذف">
            <svg viewBox="0 0 24 24"><path d="M6 6L18 18M6 18L18 6" /></svg>
        </button>
    `;
    li.querySelector('.task-text').textContent = task.text;
    li.querySelector('.category-badge').textContent = task.category;

    return li;
}

// افزودن دسته‌بندی جدید به نوار فیلتر اگه قبلاً وجود نداشت
function ensureCategoryPill(category) {
    const exists = [...categoryNav.children].some(btn => btn.dataset.category === category);
    if (!exists && category) {
        const btn = document.createElement('button');
        btn.className = 'cat-pill';
        btn.dataset.category = category;
        btn.textContent = category;
        categoryNav.appendChild(btn);
    }
}

// ===== افزودن کار =====
form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const text = input.value.trim();
    if (!text) return;

    const category = categoryInput.value.trim() || 'عمومی';
    const dueDate = dueDateInput.value || null;

    const result = await callApi('add', { text, category, due_date: dueDate });
    if (result.success) {
        const li = createTaskElement(result.task);
        list.insertBefore(li, list.firstChild);
        ensureCategoryPill(category);
        input.value = '';
        categoryInput.value = '';
        dueDateInput.value = '';
        applyFilter();
        updateStats();
    } else {
        alert(result.error || 'خطایی رخ داد');
    }
});

// ===== تیک زدن و حذف =====
list.addEventListener('click', async (e) => {
    const li = e.target.closest('.task-item');
    if (!li) return;
    const id = li.dataset.id;

    if (e.target.closest('.check-btn')) {
        const result = await callApi('toggle', { id });
        if (result.success) {
            li.classList.toggle('done');
            li.querySelector('.check-btn').classList.toggle('checked');
            updateStats();
        }
    }

    if (e.target.closest('.delete-btn')) {
        const result = await callApi('delete', { id });
        if (result.success) {
            li.style.opacity = '0';
            setTimeout(() => {
                li.remove();
                applyFilter();
                updateStats();
            }, 150);
        }
    }
});

// ===== فیلتر دسته‌بندی =====
categoryNav.addEventListener('click', (e) => {
    const btn = e.target.closest('.cat-pill');
    if (!btn) return;

    [...categoryNav.children].forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    activeCategory = btn.dataset.category;
    applyFilter();
});

// مقداردهی اولیه
updateStats();
