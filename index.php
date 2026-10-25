<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = 'FORCES Committee | Home';

function forcesEscape($value) {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

function forcesFetch($conn, $table, $sql) {
    if (!in_array($table, ['events', 'notices', 'faculty'], true)) {
        return [];
    }

    $check = $conn->query(
        "SHOW TABLES LIKE '" . $conn->real_escape_string($table) . "'"
    );

    if (!$check || $check->num_rows === 0) {
        return [];
    }

    $result = $conn->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

$events = forcesFetch(
    $conn,
    'events',
    "SELECT * FROM events
     WHERE event_date >= CURDATE()
     ORDER BY event_date ASC LIMIT 3"
);

$notices = forcesFetch(
    $conn,
    'notices',
    "SELECT * FROM notices ORDER BY id DESC LIMIT 4"
);

$faculty = forcesFetch(
    $conn,
    'faculty',
    "SELECT * FROM faculty ORDER BY id DESC LIMIT 3"
);

include __DIR__ . '/includes/header.php';
?>

<style>
/* ===== FORCES COMMITTEE HOMEPAGE ===== */

.forces-home {
    --blue: #1769e0;
    --navy: #12396e;
    --text: #23364f;
    --muted: #64748b;
    --border: #e1e8f2;
    background: #fff;
    color: var(--text);
    overflow: hidden;
}

.forces-home *,
.forces-home *::before,
.forces-home *::after {
    box-sizing: border-box;
}

.forces-container {
    width: min(1120px, 92%);
    margin: 0 auto;
}

.forces-section {
    padding: 26px 0;
}

.forces-heading {
    text-align: center;
    max-width: 700px;
    margin: 0 auto 18px;
}

.forces-heading h2 {
    color: var(--navy);
    font-size: clamp(25px, 3vw, 33px);
    font-weight: 850;
    margin: 8px 0 6px;
}

.forces-heading p {
    color: var(--muted);
    font-size: 14px;
    line-height: 1.7;
    margin: 0;
}

.forces-tag {
    display: inline-block;
    padding: 6px 11px;
    border-radius: 30px;
    color: #1769e0;
    background: #e9f2ff;
    font-size: 11px;
    font-weight: 850;
    letter-spacing: .8px;
}

.forces-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 9px;
}

.forces-btn {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    gap: 7px;
    min-height: 40px;
    padding: 10px 16px;
    border-radius: 8px;
    text-decoration: none !important;
    font-size: 13px;
    font-weight: 750;
    transition: .2s ease;
}

.forces-btn-primary {
    color: #fff !important;
    background: var(--blue);
    border: 1px solid var(--blue);
}

.forces-btn-primary:hover {
    background: #0c51b5;
    transform: translateY(-2px);
}

.forces-btn-outline {
    color: var(--blue) !important;
    background: #fff;
    border: 1px solid #c8d9f2;
}

/* ===== HERO ===== */

.forces-hero {
    min-height: 365px;
    display: flex;
    align-items: center;
    background:
        linear-gradient(100deg, rgba(7,31,70,.94), rgba(17,75,151,.76)),
        url('assets/images/forces-members.jpg') center/cover no-repeat;
    overflow: hidden;
}

.forces-hero-content {
    max-width: 720px;
    padding: 40px 0;
    color: #fff;
}

.forces-hero .forces-tag {
    color: #e5f1ff;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.22);
}

.forces-hero h1 {
    color: #fff;
    font-size: clamp(36px, 5.4vw, 58px);
    font-weight: 900;
    line-height: 1.08;
    margin: 15px 0 12px;
}

.forces-hero h1 span {
    display: block;
    color: #91caff;
}

.forces-hero p {
    max-width: 610px;
    color: #e8f1ff;
    font-size: 15px;
    line-height: 1.8;
    margin: 0 0 20px;
}

.forces-hero .forces-btn-outline {
    color: #fff !important;
    background: rgba(255,255,255,.08);
    border-color: rgba(255,255,255,.45);
}

/* ===== QUICK LINKS ===== */

.forces-shortcuts {
    padding: 13px 0;
    background: #f5f8fe;
    border-bottom: 1px solid var(--border);
}

.forces-shortcuts-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0,1fr));
    gap: 10px;
}

.forces-shortcut {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 11px;
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 10px;
    text-decoration: none !important;
    color: var(--text) !important;
    transition: .2s;
}

.forces-shortcut:hover {
    transform: translateY(-2px);
    border-color: #a5c7fa;
}

.forces-shortcut-icon {
    display: grid;
    place-items: center;
    width: 39px;
    height: 39px;
    flex-shrink: 0;
    background: #eaf2ff;
    border-radius: 9px;
    font-size: 19px;
}

.forces-shortcut strong,
.forces-shortcut small {
    display: block;
}

.forces-shortcut strong {
    font-size: 13px;
}

.forces-shortcut small {
    color: var(--muted);
    margin-top: 3px;
    font-size: 11px;
}

/* ===== CODE SMASH 2.0 ===== */

.forces-code-section {
    padding: 23px 0;
}

.forces-code-container {
    overflow: hidden;
    border: 1px solid #cfe0fa;
    border-radius: 15px;
    background: #f4f8ff;
    box-shadow: 0 7px 22px rgba(27,75,145,.08);
}

.forces-code-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    padding: 12px 17px;
    background: #0a2854;
    color: #fff;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1px;
}

.forces-code-bar span:last-child {
    color: #78d5ff;
}

.forces-code-layout {
    display: grid;
    grid-template-columns: .9fr 1.1fr;
    align-items: stretch;
}

.forces-code-info {
    padding: 23px;
}

.forces-code-info h2 {
    font-size: clamp(30px,3.7vw,42px);
    color: #102e5c;
    line-height: 1.08;
    font-weight: 950;
    margin: 11px 0 8px;
}

.forces-code-info h2 span {
    display: block;
    color: #1678e8;
}

.forces-code-info h3 {
    font-size: 15px;
    color: #1e6bb9;
    margin: 0 0 12px;
}

.forces-code-info > p {
    color: var(--muted);
    font-size: 13px;
    line-height: 1.75;
    margin: 0 0 14px;
}

.forces-code-points {
    display: grid;
    gap: 8px;
    margin-bottom: 16px;
}

.forces-code-point {
    display: flex;
    align-items: center;
    gap: 9px;
    color: #2e4663;
    font-size: 12px;
    font-weight: 700;
}

.forces-code-point span {
    display: grid;
    place-items: center;
    width: 30px;
    height: 30px;
    flex-shrink: 0;
    background: #e0edff;
    border-radius: 8px;
    font-size: 16px;
}

.forces-code-poster {
    min-width: 0;
    padding: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e5efff;
}

.forces-code-poster img {
    display: block;
    width: 100%;
    height: auto;
    max-height: 470px;
    object-fit: contain;
    border-radius: 8px;
    background: #061832;
}

/* Fallback shown if poster file is missing */
.forces-code-fallback {
    width: 100%;
    min-height: 300px;
    display: none;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 20px;
    color: #fff;
    background: linear-gradient(135deg,#071b3a,#1266d5,#44b8ff);
    border-radius: 8px;
}

.forces-code-fallback strong {
    font-size: 31px;
    margin-top: 10px;
}

.forces-code-fallback b {
    font-size: 48px;
    color: #b8e6ff;
}

.forces-code-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    padding: 11px 16px;
    background: #e9f2ff;
    border-top: 1px solid #d6e5fa;
}

.forces-code-footer p {
    color: #536983;
    font-size: 11px;
    line-height: 1.6;
    margin: 0;
}

/* ===== ABOUT FORCES ===== */

.forces-about-box {
    display: grid;
    grid-template-columns: 65px 1fr;
    gap: 16px;
    padding: 21px;
    border: 1px solid #dce7f5;
    border-radius: 13px;
    background: #f7faff;
}

.forces-about-letter {
    display: grid;
    place-items: center;
    width: 62px;
    height: 62px;
    border-radius: 14px;
    color: #fff;
    background: linear-gradient(145deg,#15468e,#438fff);
    font-size: 33px;
    font-weight: 900;
}

.forces-about-box h3 {
    color: var(--navy);
    font-size: 21px;
    margin: 0 0 9px;
}

.forces-about-box p {
    color: var(--muted);
    font-size: 13px;
    line-height: 1.85;
    margin: 0 0 9px;
}

.forces-about-box p:last-child {
    margin-bottom: 0;
}

.forces-values {
    display: grid;
    grid-template-columns: repeat(4,minmax(0,1fr));
    gap: 10px;
    margin-top: 12px;
}

.forces-value {
    padding: 14px;
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 11px;
}

.forces-value-icon {
    width: 37px;
    height: 37px;
    display: grid;
    place-items: center;
    border-radius: 9px;
    background: #eaf2ff;
    font-size: 19px;
    margin-bottom: 9px;
}

.forces-value h3 {
    color: var(--navy);
    font-size: 14px;
    margin: 0 0 6px;
}

.forces-value p {
    color: var(--muted);
    font-size: 12px;
    line-height: 1.65;
    margin: 0;
}

/* ===== VISION / MISSION ===== */

.forces-vm-grid {
    display: grid;
    grid-template-columns: repeat(2,minmax(0,1fr));
    gap: 13px;
    margin-top: 13px;
}

.forces-vm-card {
    padding: 19px;
    border-radius: 13px;
    transition: transform .2s;
}

.forces-vm-card:hover {
    transform: translateY(-3px);
}

.forces-vision {
    background: linear-gradient(135deg,#e4f0ff,#f3f8ff);
    border: 1px solid #bdd8ff;
}

.forces-vision .forces-vm-icon {
    background: #c8e0ff;
    color: #1454a6;
}

.forces-mission {
    background: linear-gradient(135deg,#f0e9ff,#faf7ff);
    border: 1px solid #d8c7ff;
}

.forces-mission .forces-vm-icon {
    background: #dfd0ff;
    color: #6339b5;
}

.forces-vm-heading {
    display: flex;
    align-items: center;
    gap: 11px;
    margin-bottom: 10px;
}

.forces-vm-icon {
    display: grid;
    place-items: center;
    width: 42px;
    height: 42px;
    flex-shrink: 0;
    border-radius: 11px;
    font-size: 20px;
}

.forces-vm-heading h3 {
    color: #1a3d70;
    font-size: 19px;
    margin: 0;
}

.forces-mission .forces-vm-heading h3 {
    color: #58349c;
}

.forces-vm-card > p {
    color: #536780;
    font-size: 13px;
    line-height: 1.8;
    margin: 0;
}

/* ===== EVENTS AND NOTICES ===== */

.forces-updates {
    background: #f6f9ff;
    border-top: 1px solid #edf2fa;
    border-bottom: 1px solid #edf2fa;
}

.forces-updates-grid {
    display: grid;
    grid-template-columns: repeat(2,minmax(0,1fr));
    gap: 14px;
}

.forces-panel {
    min-width: 0;
    padding: 16px;
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 12px;
}

.forces-panel-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.forces-panel-heading h3 {
    color: var(--navy);
    font-size: 18px;
    margin: 0;
}

.forces-panel-heading span {
    font-size: 20px;
}

.forces-list {
    display: grid;
    gap: 9px;
}

.forces-list-item {
    padding: 11px;
    border: 1px solid var(--border);
    border-radius: 9px;
    background: #fff;
}

.forces-list-item h4 {
    color: var(--navy);
    font-size: 14px;
    line-height: 1.5;
    margin: 0 0 6px;
}

.forces-list-item p {
    color: var(--muted);
    font-size: 12px;
    line-height: 1.65;
    margin: 0 0 7px;
}

.forces-meta {
    color: var(--blue);
    font-size: 11px;
    font-weight: 750;
}

.forces-empty {
    padding: 14px;
    border: 1px dashed #c8d9f2;
    border-radius: 9px;
    background: #f7faff;
    color: var(--muted);
    font-size: 13px;
    line-height: 1.7;
}

.forces-panel-action {
    margin-top: 12px;
}

/* ===== FACULTY ===== */

.forces-faculty-grid {
    display: grid;
    grid-template-columns: repeat(3,minmax(0,1fr));
    gap: 11px;
}

.forces-faculty-card {
    padding: 17px;
    text-align: center;
    border: 1px solid var(--border);
    border-radius: 12px;
    background: #fff;
}

.forces-faculty-avatar {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 64px;
    height: 64px;
    margin: 0 auto 10px;
    border-radius: 50%;
    color: var(--blue);
    background: #eaf2ff;
    font-size: 23px;
    font-weight: 900;
    overflow: hidden;
}

.forces-faculty-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.forces-faculty-card h3 {
    color: var(--navy);
    font-size: 15px;
    margin: 0 0 5px;
}

.forces-faculty-card p {
    color: var(--muted);
    font-size: 12px;
    margin: 0;
}

/* ===== AARTI CHATBOT ===== */

.forces-chat-toggle {
    position: fixed;
    right: 18px;
    bottom: 18px;
    z-index: 9998;
    width: 54px;
    height: 54px;
    border: 0;
    border-radius: 50%;
    background: linear-gradient(140deg,#1769e0,#398fff);
    color: #fff;
    font-size: 23px;
    cursor: pointer;
    box-shadow: 0 7px 22px rgba(23,105,224,.3);
}

.forces-chat {
    position: fixed;
    z-index: 9999;
    right: 18px;
    bottom: 82px;
    width: min(340px, calc(100vw - 25px));
    height: 390px;
    display: none;
    flex-direction: column;
    overflow: hidden;
    border: 1px solid var(--border);
    border-radius: 13px;
    background: #fff;
    box-shadow: 0 12px 35px rgba(20,47,87,.2);
}

.forces-chat.open {
    display: flex;
}

.forces-chat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 13px;
    background: linear-gradient(120deg,#12396e,#2678ee);
    color: #fff;
}

.forces-chat-header strong,
.forces-chat-header small {
    display: block;
}

.forces-chat-header small {
    color: #e4efff;
    margin-top: 3px;
}

.forces-chat-close {
    color: #fff;
    border: 0;
    background: transparent;
    font-size: 23px;
    cursor: pointer;
}

.forces-chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 12px;
    background: #f6f9ff;
}

.forces-chat-message {
    max-width: 90%;
    overflow-wrap: anywhere;
    padding: 10px;
    margin-bottom: 9px;
    border: 1px solid var(--border);
    border-radius: 10px;
    background: #fff;
    font-size: 12px;
    line-height: 1.6;
}

.forces-chat-message.user {
    margin-left: auto;
    color: #fff;
    background: var(--blue);
    border-color: var(--blue);
}

.forces-chat-form {
    display: flex;
    gap: 7px;
    padding: 9px;
    border-top: 1px solid var(--border);
}

.forces-chat-form input {
    width: 0;
    min-width: 0;
    flex: 1;
    padding: 10px;
    border: 1px solid #d5e1f0;
    border-radius: 7px;
    outline: none;
}

.forces-chat-form button {
    padding: 0 12px;
    border: 0;
    border-radius: 7px;
    background: var(--blue);
    color: #fff;
    cursor: pointer;
}

/* ===== MOBILE RESPONSIVE ===== */

@media (max-width: 850px) {
    .forces-shortcuts-grid {
        grid-template-columns: repeat(2,minmax(0,1fr));
    }

    .forces-code-layout {
        grid-template-columns: 1fr;
    }

    .forces-values {
        grid-template-columns: repeat(2,minmax(0,1fr));
    }
}

@media (max-width: 600px) {
    .forces-section {
        padding: 22px 0;
    }

    .forces-hero {
        min-height: 345px;
    }

    .forces-hero-content {
        padding: 32px 0;
    }

    .forces-hero h1 {
        font-size: 36px;
    }

    .forces-shortcut {
        padding: 9px;
    }

    .forces-shortcut-icon {
        width: 34px;
        height: 34px;
    }

    .forces-code-info {
        padding: 17px;
    }

    .forces-code-info h2 {
        font-size: 34px;
    }

    .forces-code-poster {
        padding: 8px;
    }

    .forces-code-footer {
        padding: 10px;
    }

    .forces-about-box {
        grid-template-columns: 1fr;
        padding: 17px;
        gap: 11px;
    }

    .forces-about-letter {
        width: 50px;
        height: 50px;
        font-size: 27px;
    }

    .forces-values,
    .forces-vm-grid,
    .forces-updates-grid,
    .forces-faculty-grid {
        grid-template-columns: 1fr;
    }

    .forces-panel {
        padding: 13px;
    }

    .forces-chat-toggle {
        right: 12px;
        bottom: 12px;
    }

    .forces-chat {
        right: 9px;
        bottom: 75px;
    }
}
</style>

<main class="forces-home">

    <!-- HERO -->
    <section class="forces-hero">
        <div class="forces-container">
            <div class="forces-hero-content">
                <span class="forces-tag">
                    STUDENT COMMUNITY · TECHNOLOGY · INNOVATION
                </span>

                <h1>
                    Think Beyond.
                    <span>Create What's Next.</span>
                </h1>

                <p>
                    Welcome to FORCES Committee — a community where students
                    explore technology, share ideas, collaborate on challenges
                    and develop skills through meaningful activities.
                </p>

                <div class="forces-actions">
                    <a href="events.php" class="forces-btn forces-btn-primary">
                        Explore Events →
                    </a>
                    <a href="committee.php" class="forces-btn forces-btn-outline">
                        Meet the Committee
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- QUICK LINKS -->
    <section class="forces-shortcuts">
        <div class="forces-container forces-shortcuts-grid">
            <a href="events.php" class="forces-shortcut">
                <span class="forces-shortcut-icon">📅</span>
                <span><strong>Events</strong><small>Discover activities</small></span>
            </a>

            <a href="committee.php" class="forces-shortcut">
                <span class="forces-shortcut-icon">👥</span>
                <span><strong>Committee</strong><small>Meet our team</small></span>
            </a>

            <a href="past_members.php" class="forces-shortcut">
                <span class="forces-shortcut-icon">🏆</span>
                <span><strong>Past Members</strong><small>Our journey</small></span>
            </a>

            <a href="notice.php" class="forces-shortcut">
                <span class="forces-shortcut-icon">📢</span>
                <span><strong>Notices</strong><small>Latest updates</small></span>
            </a>
        </div>
    </section>

    <!-- CODE SMASH 2.0 WITH POSTER -->
    <section class="forces-code-section">
        <div class="forces-container">
            <div class="forces-code-container">

                <div class="forces-code-bar">
                    <span>FORCES COMMITTEE PRESENTS</span>
                    <span>IDEA · INNOVATE · CREATE</span>
                </div>

                <div class="forces-code-layout">
                    <div class="forces-code-info">
                        <span class="forces-tag">⚡ FEATURED EVENT</span>

                        <h2>CODE SMASH <span>2.0</span></h2>
                        <h3>Think. Code. Collaborate.</h3>

                        <p>
                            Explore your passion for programming, challenge
                            your thinking and discover creative solutions
                            through CODE SMASH 2.0.
                        </p>

                        <div class="forces-code-points">
                            <div class="forces-code-point">
                                <span>💻</span> Coding challenges
                            </div>
                            <div class="forces-code-point">
                                <span>🧠</span> Problem-solving skills
                            </div>
                            <div class="forces-code-point">
                                <span>🤝</span> Collaboration and learning
                            </div>
                            <div class="forces-code-point">
                                <span>🚀</span> Technology and innovation
                            </div>
                        </div>

                        <div class="forces-actions">
                            <a href="events.php" class="forces-btn forces-btn-primary">
                                Explore Event →
                            </a>
                            <a href="notice.php" class="forces-btn forces-btn-outline">
                                Check Updates
                            </a>
                        </div>
                    </div>

                    <div class="forces-code-poster">
                        <img
                            src="assets/images/events/code-smash-2.0.jpg"
                            alt="CODE SMASH 2.0 event poster"
                            onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
                        >

                        <div class="forces-code-fallback">
                            <span style="font-size:45px">&lt;/&gt;</span>
                            <strong>CODE SMASH</strong>
                            <b>2.0</b>
                            <small>IDEA · INNOVATE · CREATE</small>
                        </div>
                    </div>
                </div>

                <div class="forces-code-footer">
                    <p>
                        📢 Check official notices for confirmed event dates,
                        venue and registration information.
                    </p>
                    <a href="events.php" class="forces-btn forces-btn-primary">
                        All Events →
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- ABOUT FORCES -->
    <section class="forces-section">
        <div class="forces-container">

            <div class="forces-heading">
                <span class="forces-tag">ABOUT OUR COMMUNITY</span>
                <h2>About FORCES Committee</h2>
                <p>A place to learn, collaborate, innovate and grow together.</p>
            </div>

            <div class="forces-about-box">
                <div class="forces-about-letter">F</div>

                <div>
                    <h3>Building Ideas Into Experiences</h3>

                    <p>
                        FORCES Committee is a student-focused community that
                        encourages technical learning, creativity and active
                        participation. It provides opportunities for students
                        to exchange knowledge, explore technology and take
                        part in events and activities.
                    </p>

                    <p>
                        Through coding activities, workshops and collaborative
                        initiatives, students can develop practical skills,
                        confidence, communication and leadership abilities
                        beyond the classroom.
                    </p>
                </div>
            </div>

            <div class="forces-values">
                <article class="forces-value">
                    <div class="forces-value-icon">💡</div>
                    <h3>Innovation</h3>
                    <p>Explore new ideas and creative approaches to challenges.</p>
                </article>

                <article class="forces-value">
                    <div class="forces-value-icon">🤝</div>
                    <h3>Teamwork</h3>
                    <p>Share knowledge and achieve more through collaboration.</p>
                </article>

                <article class="forces-value">
                    <div class="forces-value-icon">📚</div>
                    <h3>Learning</h3>
                    <p>Gain knowledge through technical activities and experience.</p>
                </article>

                <article class="forces-value">
                    <div class="forces-value-icon">🚀</div>
                    <h3>Growth</h3>
                    <p>Develop confidence, leadership and problem-solving abilities.</p>
                </article>
            </div>

            <div class="forces-vm-grid">
                <article class="forces-vm-card forces-vision">
                    <div class="forces-vm-heading">
                        <span class="forces-vm-icon">🎯</span>
                        <h3>Our Vision</h3>
                    </div>

                    <p>
                        To build an innovative and collaborative student
                        community where learners explore technology, exchange
                        knowledge and become confident problem-solvers and
                        future professionals.
                    </p>
                </article>

                <article class="forces-vm-card forces-mission">
                    <div class="forces-vm-heading">
                        <span class="forces-vm-icon">🚀</span>
                        <h3>Our Mission</h3>
                    </div>

                    <p>
                        To create opportunities for technical learning,
                        teamwork, creativity and student participation
                        through engaging activities, knowledge sharing
                        and collaborative projects.
                    </p>
                </article>
            </div>
        </div>
    </section>

    <!-- EVENTS AND NOTICES -->
    <section class="forces-section forces-updates">
        <div class="forces-container">

            <div class="forces-heading">
                <span class="forces-tag">LATEST UPDATES</span>
                <h2>Events & Notices</h2>
                <p>Important information and activities from the FORCES community.</p>
            </div>

            <div class="forces-updates-grid">

                <section class="forces-panel">
                    <div class="forces-panel-heading">
                        <h3>Upcoming Events</h3>
                        <span>📅</span>
                    </div>

                    <div class="forces-list">
                        <?php if ($events): ?>
                            <?php foreach ($events as $event): ?>
                                <article class="forces-list-item">
                                    <h4>
                                        <?= forcesEscape(
                                            $event['event_name']
                                            ?? $event['title']
                                            ?? 'FORCES Event'
                                        ) ?>
                                    </h4>

                                    <?php if (!empty($event['description'])): ?>
                                        <p><?= forcesEscape($event['description']) ?></p>
                                    <?php endif; ?>

                                    <?php if (!empty($event['event_date'])): ?>
                                        <span class="forces-meta">
                                            📆 <?= forcesEscape(
                                                date('d M Y', strtotime($event['event_date']))
                                            ) ?>
                                        </span>
                                    <?php endif; ?>
                                </article>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="forces-empty">
                                No upcoming events are available.
                                Visit the Events page for updates.
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="forces-panel-action">
                        <a href="events.php" class="forces-btn forces-btn-primary">
                            View All Events →
                        </a>
                    </div>
                </section>

                <section class="forces-panel">
                    <div class="forces-panel-heading">
                        <h3>Latest Notices</h3>
                        <span>📢</span>
                    </div>

                    <div class="forces-list">
                        <?php if ($notices): ?>
                            <?php foreach ($notices as $notice): ?>
                                <article class="forces-list-item">
                                    <h4>
                                        <?= forcesEscape(
                                            $notice['title']
                                            ?? $notice['notice_title']
                                            ?? 'FORCES Notice'
                                        ) ?>
                                    </h4>

                                    <p>
                                        <?= forcesEscape(
                                            $notice['description']
                                            ?? $notice['message']
                                            ?? $notice['content']
                                            ?? 'Visit the Notices page for details.'
                                        ) ?>
                                    </p>

                                    <?php
                                    $noticeDate = $notice['notice_date']
                                        ?? $notice['created_at']
                                        ?? null;
                                    ?>

                                    <?php if ($noticeDate): ?>
                                        <span class="forces-meta">
                                            📌 <?= forcesEscape(
                                                date('d M Y', strtotime($noticeDate))
                                            ) ?>
                                        </span>
                                    <?php endif; ?>
                                </article>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="forces-empty">
                                No notices are available at the moment.
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="forces-panel-action">
                        <a href="notice.php" class="forces-btn forces-btn-primary">
                            View All Notices →
                        </a>
                    </div>
                </section>

            </div>
        </div>
    </section>

    <!-- FACULTY -->
    <section class="forces-section">
        <div class="forces-container">

            <div class="forces-heading">
                <span class="forces-tag">GUIDANCE & SUPPORT</span>
                <h2>Faculty & Mentors</h2>
                <p>Meet the people who support student learning and activities.</p>
            </div>

            <div class="forces-faculty-grid">
                <?php if ($faculty): ?>
                    <?php foreach ($faculty as $member): ?>
                        <?php
                        $name = $member['name']
                            ?? $member['faculty_name']
                            ?? $member['full_name']
                            ?? 'Faculty Member';

                        $role = $member['designation']
                            ?? $member['role']
                            ?? 'Mentor';

                        $image = $member['image']
                            ?? $member['photo']
                            ?? $member['avatar']
                            ?? '';
                        ?>
                        <article class="forces-faculty-card">
                            <div class="forces-faculty-avatar">
                                <?php if (!empty($image)): ?>
                                    <img src="<?= forcesEscape($image) ?>" alt="<?= forcesEscape($name) ?>">
                                <?php else: ?>
                                    <?= forcesEscape(strtoupper(substr($name, 0, 1))) ?>
                                <?php endif; ?>
                            </div>
                            <h3><?= forcesEscape($name) ?></h3>
                            <p><?= forcesEscape($role) ?></p>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="forces-empty" style="grid-column: 1 / -1;">
                        Faculty details will be available soon.
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </section>

    <!-- CALL TO ACTION -->
    <section class="forces-cta">
        <div class="forces-container">
            <div class="forces-cta-box">
                <h2>Ready to Join FORCES?</h2>
                <p>
                    Participate in our events, join coding initiatives, and grow
                    with a vibrant technical community.
                </p>
                <a href="events.php" class="forces-btn">Explore Events →</a>
            </div>
        </div>
    </section>

</main>

<!-- AARTI CHATBOT WINDOW & TOGGLE -->
<button type="button" class="forces-chat-toggle" onclick="toggleForcesChat()" aria-label="Open Aarti Chatbot">💬</button>

<div class="forces-chat" id="forcesChatBox">
    <div class="forces-chat-header">
        <div>
            <strong>Aarti</strong>
            <small>FORCES Assistant</small>
        </div>
        <button type="button" class="forces-chat-close" onclick="toggleForcesChat()">&times;</button>
    </div>
    <div class="forces-chat-messages" id="forcesChatMessages">
        <div class="forces-chat-message">
            Hi! I am Aarti. How can I help you with FORCES Committee events and activities today?
        </div>
    </div>
    <form class="forces-chat-form" onsubmit="sendForcesMessage(event)">
        <input type="text" id="forcesChatInput" placeholder="Type a message..." required>
        <button type="submit">Send</button>
    </form>
</div>

<script>
function toggleForcesChat() {
    const chat = document.getElementById('forcesChatBox');
    if (chat) {
        chat.classList.toggle('open');
    }
}

function sendForcesMessage(e) {
    e.preventDefault();
    const input = document.getElementById('forcesChatInput');
    const messages = document.getElementById('forcesChatMessages');
    const text = input.value.trim();

    if (!text) return;

    // Add User Message
    const userMsg = document.createElement('div');
    userMsg.className = 'forces-chat-message user';
    userMsg.textContent = text;
    messages.appendChild(userMsg);

    input.value = '';
    messages.scrollTop = messages.scrollHeight;

    // Simulated Assistant Response
    setTimeout(() => {
        const botMsg = document.createElement('div');
        botMsg.className = 'forces-chat-message';
        botMsg.textContent = "Thank you for reaching out! Please check our Events or Notices section for full details.";
        messages.appendChild(botMsg);
        messages.scrollTop = messages.scrollHeight;
    }, 600);
}
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>