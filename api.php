<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/db.php';

$input = json_decode(file_get_contents('php://input'), true);
$action = $input['action'] ?? '';

switch ($action) {

    case 'add':
        $text = trim($input['text'] ?? '');
        $category = trim($input['category'] ?? '') ?: 'عمومی';
        $dueDate = trim($input['due_date'] ?? '') ?: null;

        if ($text === '') {
            echo json_encode(['success' => false, 'error' => 'متن کار خالیه']);
            exit;
        }

        $stmt = $pdo->prepare(
            "INSERT INTO tasks (text, category, due_date, done) VALUES (:text, :category, :due_date, 0)"
        );
        $stmt->execute([
            ':text' => $text,
            ':category' => $category,
            ':due_date' => $dueDate,
        ]);

        $newId = $pdo->lastInsertId();
        echo json_encode([
            'success' => true,
            'task' => [
                'id' => $newId,
                'text' => $text,
                'category' => $category,
                'due_date' => $dueDate,
                'done' => 0,
            ]
        ]);
        break;

    case 'toggle':
        $id = (int) ($input['id'] ?? 0);
        $stmt = $pdo->prepare("UPDATE tasks SET done = NOT done WHERE id = :id");
        $stmt->execute([':id' => $id]);
        echo json_encode(['success' => true]);
        break;

    case 'delete':
        $id = (int) ($input['id'] ?? 0);
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
        $stmt->execute([':id' => $id]);
        echo json_encode(['success' => true]);
        break;

    default:
        echo json_encode(['success' => false, 'error' => 'عملیات نامعتبر']);
}
