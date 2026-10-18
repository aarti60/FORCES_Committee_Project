<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$pageTitle = 'Task Management';
$loggedIn = function_exists('is_logged_in') && is_logged_in();
$taskError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$loggedIn) {
        redirect('login.php');
    }

    $token = $_POST['csrf_token'] ?? '';
    if (!function_exists('verify_csrf_token') || !verify_csrf_token($token)) {
        $taskError = 'Session expired. Refresh the page and try again.';
    } else {
        $action = $_POST['task_action'] ?? '';

        if ($action === 'create_task') {
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $assignedTo = trim($_POST['assigned_to'] ?? '');
            $dueDate = trim($_POST['due_date'] ?? '');
            $date = DateTime::createFromFormat('Y-m-d', $dueDate);
            $validDate = $date && $date->format('Y-m-d') === $dueDate;

            if ($title === '' || $assignedTo === '' || !$validDate) {
                $taskError = 'Enter a task title, assignee and valid deadline.';
            } elseif (strlen($title) > 150 || strlen($assignedTo) > 150) {
                $taskError = 'Title or assignee is too long.';
            } else {
                $stmt = $conn->prepare(
                    'INSERT INTO tasks (title, description, assigned_to, due_date, created_by)
                     VALUES (?, ?, ?, ?, ?)'
                );
                if ($stmt) {
                    $createdBy = $_SESSION['user_id'] ?? null;
                    $stmt->bind_param('ssssi', $title, $description, $assignedTo, $dueDate, $createdBy);
                    if ($stmt->execute()) {
                        $stmt->close();
                        redirect('task-management.php?task_created=1');
                    } else {
                        $taskError = 'Could not create task. Please try again.';
                    }
                    $stmt->close();
                } else {
                    $taskError = 'Unable to prepare the task query.';
                }
            }
        } elseif ($action === 'update_status') {
            $taskId = filter_input(INPUT_POST, 'task_id', FILTER_VALIDATE_INT);
            $status = $_POST['status'] ?? '';
            $allowedStatuses = ['Pending', 'In Progress', 'Completed'];

            if (!$taskId || !in_array($status, $allowedStatuses, true)) {
                $taskError = 'Invalid task or status.';
            } else {
                $stmt = $conn->prepare('UPDATE tasks SET status = ? WHERE id = ?');
                if ($stmt) {
                    $stmt->bind_param('si', $status, $taskId);
                    if ($stmt->execute()) {
                        $stmt->close();
                        redirect('task-management.php?status_updated=1');
                    } else {
                        $taskError = 'Could not update task status.';
                    }
                    $stmt->close();
                } else {
                    $taskError = 'Unable to prepare the status query.';
                }
            }
        }
    }
}

$tasks = [];
$totalTasks = $pendingTasks = $progressTasks = $completedTasks = 0;
$taskResult = $conn->query(
    "SELECT id, title, description, assigned_to, due_date, status, created_at
     FROM tasks
     ORDER BY CASE status WHEN 'Pending' THEN 1 WHEN 'In Progress' THEN 2 ELSE 3 END,
              due_date ASC, id DESC"
);

if ($taskResult) {
    $tasks = $taskResult->fetch_all(MYSQLI_ASSOC);
    $totalTasks = count($tasks);
    foreach ($tasks as $task) {
        if ($task['status'] === 'Pending') $pendingTasks++;
        elseif ($task['status'] === 'In Progress') $progressTasks++;
        elseif ($task['status'] === 'Completed') $completedTasks++;
    }
}