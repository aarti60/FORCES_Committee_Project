
<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$pageTitle = 'Home';


/* =========================================
   EXISTING HOME PAGE DATA
========================================= */

$events = $conn->query(
    "SELECT * FROM events
     WHERE event_date >= CURDATE()
     ORDER BY event_date ASC LIMIT 3"
)->fetch_all(MYSQLI_ASSOC);

$notices = $conn->query(
    "SELECT * FROM notices
     ORDER BY COALESCE(notice_date, DATE(created_at)) DESC, id DESC
     LIMIT 3"
)->fetch_all(MYSQLI_ASSOC);

$faculty = $conn->query(
    "SELECT * FROM faculty ORDER BY id DESC LIMIT 3"
)->fetch_all(MYSQLI_ASSOC);

include __DIR__ . '/includes/header.php';
?>

<style>
.task-module-wrap { margin: 24px auto; }
.task-module-card {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 22px 24px;
    border-radius: 16px;
    background: linear-gradient(120deg, #eef4ff, #ffffff);
    border: 1px solid #d8e5ff;
    box-shadow: 0 6px 20px rgba(37,117,252,.08);
    text-decoration: none;
    color: #243b65;
    transition: transform .22s ease, box-shadow .22s ease;
}
.task-module-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 26px rgba(37,117,252,.15);
}
.task-module-card .quick-icon { font-size: 30px; }
.task-module-text { flex: 1; }
.task-module-text strong { display: block; color: #174ea6; margin-bottom: 5px; }
.task-module-text small { display: block; color: #64748b; line-height: 1.5; }
.task-module-link { margin-left: auto; color: #2575fc; font-weight: 800; white-space: nowrap; }
@media (max-width: 600px) {
    .task-module-card { align-items: flex-start; flex-wrap: wrap; padding: 18px; }
    .task-module-link { margin-left: 0; width: 100%; }
}
</style>




<main>
    <section class="hero">
        <div class="container hero-content">
            <span class="eyebrow">STUDENT COMMUNITY • LEARN • LEAD</span>

            <h1>Ideas That Inspire.<br>
                <span>Leaders Who Create Change.</span>
            </h1>

            <p>
                Welcome to FORCES Committee — a place where creativity meets
                collaboration, new ideas become reality, and students grow
                into confident leaders.
            </p>

            <div class="hero-actions">
                <a class="btn" href="events.php">Explore Events →</a>
                <a class="btn btn-light" href="registration.php">Join FORCES</a>
            </div>
        </div>
    </section>

    <div class="container quick-grid">
        <a class="quick-card" href="committee.php">
            <span class="quick-icon">👥</span>Our Committee
        </a>
        <a class="quick-card" href="faculty.php">
            <span class="quick-icon">🎓</span>Faculty Members