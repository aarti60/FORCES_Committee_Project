<?php
if (!isset($pageTitle)) {
    $pageTitle = 'FORCES Committee';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> | FORCES Committee</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="site-header">
    <div class="container nav-wrap">
        <a class="brand" href="index.php">
            <img src="assets/images/forces-logo.png"
                 alt="FORCES logo"
                 onerror="this.style.display='none'">
            <span>FORCES <small>COMMITTEE</small></span>
        </a>

        <button class="menu-toggle" id="menuToggle"
                type="button" aria-label="Toggle navigation"
                aria-expanded="false">☰</button>

        <nav class="main-nav" id="mainNav">
            <a href="index.php">Home</a>
            <a href="committee.php">Committee</a>
            <a href="faculty.php">Faculty</a>
            <a href="past-members.php">Past Members</a>
            <a href="events.php">Events</a>
            <a href="notice.php">Notices</a>
            <a href="registration.php">Registration</a>

            <?php if (is_logged_in()): ?>
                <a class="nav-button" href="logout.php">Logout</a>
            <?php else: ?>
                <a class="nav-button" href="login.php">Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<?php show_flash(); ?>