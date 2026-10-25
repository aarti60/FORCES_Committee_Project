<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Our Faculty';

/*
|--------------------------------------------------------------------------
| Faculty Information
|--------------------------------------------------------------------------
| Existing faculty photos folder: assets/images/faculty/
|--------------------------------------------------------------------------
*/

$facultyMembers = [
    [
        'name' => 'Dr. A.H. Rokade',
        'designation' => 'Assistant Professor',
        'department' => 'Computer Engineering',
        'photo' => 'faculty01.jpg'
    ],
    [
        'name' => 'Ms. S.D. Pingle',
        'designation' => 'Assistant Professor',
        'department' => 'Computer Engineering',
        'photo' => 'faculty02.jpg'
    ],
    [
        'name' => 'Ms. K.R. Ghule',
        'designation' => 'Assistant Professor',
        'department' => 'Computer Engineering',
        'photo' => 'faculty03.jpg'
    ],
    [
        'name' => 'Ms. S.A. Khusro',
        'designation' => 'Assistant Professor',
        'department' => 'Computer Engineering',
        'photo' => 'faculty04.jpg'
    ],
    [
        'name' => 'Ms. S.K. Shewale',
        'designation' => 'Assistant Professor',
        'department' => 'Computer Engineering',
        'photo' => 'faculty05.jpg'
    ],
    [
        'name' => 'Ms. M.N. Bhosle',
        'designation' => 'Assistant Professor',
        'department' => 'Computer Engineering',
        'photo' => 'faculty06.jpg'
    ],
    [
        'name' => 'Mr. M.B. Gaikwad',
        'designation' => 'Assistant Professor',
        'department' => 'Computer Engineering',
        'photo' => 'faculty07.jpg'
    ],
    [
        'name' => 'Mr. P.P. Gadve',
        'designation' => 'Assistant Professor',
        'department' => 'Computer Engineering',
        'photo' => 'faculty08.jpg'
    ],
    [
        'name' => 'Ms. S. Khan',
        'designation' => 'Assistant Professor',
        'department' => 'Computer Engineering',
        'photo' => 'faculty09.jpg'
    ],
    [
        'name' => 'Ms. P.R. Murkute',
        'designation' => 'Assistant Professor',
        'department' => 'Computer Engineering',
        'photo' => 'faculty10.jpg'
    ],
    [
        'name' => 'Ms. A.P. Kamble',
        'designation' => 'Assistant Professor',
        'department' => 'Computer Engineering',
        'photo' => 'faculty11.jpg'
    ],
];

/*
|--------------------------------------------------------------------------
| Search and Department Filter
|--------------------------------------------------------------------------
*/

$search = trim($_GET['search'] ?? '');
$departmentFilter = trim($_GET['department'] ?? '');

$departments = array_values(
    array_unique(array_column($facultyMembers, 'department'))
);

$filteredFaculty = array_filter(
    $facultyMembers,
    function ($faculty) use ($search, $departmentFilter) {
        $matchesSearch =
            $search === '' ||
            stripos($faculty['name'], $search) !== false ||
            stripos($faculty['designation'], $search) !== false ||
            stripos($faculty['department'], $search) !== false;

        $matchesDepartment =
            $departmentFilter === '' ||
            $faculty['department'] === $departmentFilter;

        return $matchesSearch && $matchesDepartment;
    }
);

include __DIR__ . '/includes/header.php';
?>

<style>
/* ======================================
   FACULTY PAGE
====================================== */

.faculty-page {
    background: #e2f6f5;
    min-height: 80vh;
    padding: 30px 0 60px;
}

.faculty-container {
    width: 94%;
    max-width: 1450px;
    margin: 0 auto;
}

/* Heading */

.faculty-heading {
    margin-bottom: 30px;
}

.faculty-heading h1 {
    color: #101827;
    font-size: clamp(28px, 4vw, 36px);
    font-weight: 850;
    text-transform: uppercase;
    margin: 0 0 8px;
}

.faculty-heading p {
    color: #64748b;
    font-size: 16px;
    margin: 0;
    line-height: 1.7;
}

/* Search Tools */

.faculty-tools {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 22px;
}

.faculty-search,
.faculty-select,
.faculty-search-button {
    box-sizing: border-box;
    padding: 11px 14px;
    border: 1px solid #d6e5f4;
    border-radius: 9px;
    background: #fff;
    color: #183153;
    font: inherit;
}

.faculty-search {
    flex: 1;
    min-width: 220px;
}

.faculty-select {
    min-width: 200px;
}

.faculty-search-button {
    background: #2575fc;
    border-color: #2575fc;
    color: #fff;
    font-weight: 700;
    cursor: pointer;
    transition: background .2s;
}

.faculty-search-button:hover {
    background: #174bba;
}

.faculty-search:focus,
.faculty-select:focus {
    outline: 2px solid #9ac1ff;
    outline-offset: 2px;
}

.faculty-count {
    color: #64748b;
    font-size: 13px;
    margin: 0 0 20px;
}

/* Faculty Cards Grid */

.faculty-grid {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 28px 24px;
    align-items: start;
}

.faculty-card {
    min-width: 0;
    overflow: hidden;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 5px 16px rgba(25, 60, 95, .07);
    transition: transform .25s ease, box-shadow .25s ease;
}

.faculty-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(25, 60, 95, .13);
}

.faculty-photo-area {
    width: 100%;
    height: 175px;
    background: #f6b80c;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.faculty-photo {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
    border: none;
    transition: transform .3s ease;
}

.faculty-card:hover .faculty-photo {
    transform: scale(1.04);
}

.faculty-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 7px;
    padding: 10px;
    box-sizing: border-box;
    background: #f6b80c;
    color: #17345d;
    text-align: center;
    font-size: 12px;
    font-weight: 700;
}

.faculty-placeholder svg {
    width: 42px;
    height: 42px;
}

/* Clean Info Area without Duplicate Name */

.faculty-info {
    background: #fff;
    text-align: center;
    padding: 14px 10px;
}

.faculty-designation {
    display: block;
    color: #102448;
    font-size: 13px;
    line-height: 1.4;
    font-weight: 700;
}

.faculty-department {
    display: block;
    color: #64748b;
    font-size: 11px;
    line-height: 1.4;
    margin-top: 4px;
}

.no-faculty {
    grid-column: 1 / -1;
    padding: 35px 15px;
    background: #fff;
    color: #64748b;
    text-align: center;
    border-radius: 12px;
}

/* ===== ASK AARTI CHATBOT STYLES ===== */

.forces-chat-toggle {
    position: fixed;
    right: 18px;
    bottom: 18px;
    z-index: 9998;
    width: 54px;
    height: 54px;
    border: 0;
    border-radius: 50%;
    background: linear-gradient(140deg, #1769e0, #398fff);
    color: #fff;
    font-size: 23px;
    cursor: pointer;
    box-shadow: 0 7px 22px rgba(23, 105, 224, 0.3);
    transition: transform 0.2s ease;
}

.forces-chat-toggle:hover {
    transform: scale(1.06);
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
    border: 1px solid #e1e8f2;
    border-radius: 13px;
    background: #fff;
    box-shadow: 0 12px 35px rgba(20, 47, 87, 0.2);
}

.forces-chat.open {
    display: flex;
}

.forces-chat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 13px;
    background: linear-gradient(120deg, #12396e, #2678ee);
    color: #fff;
}

.forces-chat-header strong,
.forces-chat-header small {
    display: block;
}

.forces-chat-header small {
    color: #e4efff;
    margin-top: 3px;
    font-size: 11px;
}

.forces-chat-close {
    color: #fff;
    border: 0;
    background: transparent;
    font-size: 23px;
    cursor: pointer;
    line-height: 1;
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
    border: 1px solid #e1e8f2;
    border-radius: 10px;
    background: #fff;
    font-size: 12px;
    line-height: 1.6;
    color: #23364f;
}

.forces-chat-message.user {
    margin-left: auto;
    color: #fff;
    background: #1769e0;
    border-color: #1769e0;
}

.forces-chat-form {
    display: flex;
    gap: 7px;
    padding: 9px;
    border-top: 1px solid #e1e8f2;
    background: #fff;
}

.forces-chat-form input {
    width: 0;
    min-width: 0;
    flex: 1;
    padding: 10px;
    border: 1px solid #d5e1f0;
    border-radius: 7px;
    outline: none;
    font-size: 12px;
}

.forces-chat-form button {
    padding: 0 14px;
    border: 0;
    border-radius: 7px;
    background: #1769e0;
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
}

/* Responsive layout */

@media (max-width: 1100px) {
    .faculty-grid {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }
}

@media (max-width: 850px) {
    .faculty-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 22px 16px;
    }

    .faculty-photo-area {
        height: 155px;
    }
}

@media (max-width: 560px) {
    .faculty-container {
        width: 92%;
    }

    .faculty-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px 13px;
    }

    .faculty-photo-area {
        height: 140px;
    }

    .faculty-info {
        padding: 11px 6px;
    }

    .faculty-tools {
        flex-direction: column;
    }

    .faculty-search,
    .faculty-select,
    .faculty-search-button {
        width: 100%;
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

@media (prefers-reduced-motion: reduce) {
    .faculty-card,
    .faculty-photo {
        transition: none;
    }
}
</style>

<main class="faculty-page">
    <div class="faculty-container">

        <section class="faculty-heading">
            <h1>Our Faculty</h1>
            <p>
                Meet the faculty members who guide and support FORCES.
            </p>
        </section>

        <form
            method="GET"
            action="faculty.php"
            class="faculty-tools"
        >

            <input
                type="search"
                name="search"
                class="faculty-search"
                placeholder="Search faculty by name..."
                value="<?= e($search) ?>"
                aria-label="Search faculty"
            >

            <select
                name="department"
                class="faculty-select"
                aria-label="Filter by department"
            >
                <option value="">All Departments</option>

                <?php foreach ($departments as $department): ?>
                    <option
                        value="<?= e($department) ?>"
                        <?= $departmentFilter === $department
                            ? 'selected'
                            : '' ?>
                    >
                        <?= e($department) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button
                type="submit"
                class="faculty-search-button"
            >
                Search
            </button>

        </form>

        <p class="faculty-count">
            Showing <?= count($filteredFaculty) ?>
            of <?= count($facultyMembers) ?> faculty members
        </p>

        <section class="faculty-grid">

            <?php if (empty($filteredFaculty)): ?>

                <div class="no-faculty">
                    <h3>No faculty members found</h3>
                    <p>Try another name or department.</p>
                </div>

            <?php else: ?>

                <?php foreach ($filteredFaculty as $faculty): ?>

                    <?php
                    $photoPath = __DIR__
                        . '/assets/images/faculty/'
                        . $faculty['photo'];

                    $photoUrl = 'assets/images/faculty/'
                        . rawurlencode($faculty['photo']);

                    $photoExists = is_file($photoPath);
                    ?>

                    <article class="faculty-card">

                        <div class="faculty-photo-area">

                            <?php if ($photoExists): ?>

                                <img
                                    class="faculty-photo"
                                    src="<?= e($photoUrl) ?>"
                                    alt="<?= e($faculty['name']) ?>"
                                    loading="lazy"
                                    onerror="
                                        this.style.display='none';
                                        this.nextElementSibling.style.display='flex';
                                    "
                                >

                                <div
                                    class="faculty-placeholder"
                                    style="display:none;"
                                >
                                    <span><?= e($faculty['name']) ?></span>
                                </div>

                            <?php else: ?>

                                <div class="faculty-placeholder">
                                    <svg
                                        viewBox="0 0 100 100"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="4"
                                        aria-hidden="true"
                                    >
                                        <circle cx="50" cy="32" r="18"/>
                                        <path d="M15 90c2-23 14-36 35-36s33 13 35 36"/>
                                    </svg>

                                    <span><?= e($faculty['name']) ?></span>
                                </div>

                            <?php endif; ?>

                        </div>

                        <div class="faculty-info">

                            <span class="faculty-designation">
                                <?= e($faculty['designation']) ?>
                            </span>

                            <span class="faculty-department">
                                <?= e($faculty['department']) ?>
                            </span>

                        </div>

                    </article>

                <?php endforeach; ?>

            <?php endif; ?>

        </section>

    </div>
</main>

<!-- ASK AARTI CHATBOT WINDOW & TOGGLE -->
<button type="button" class="forces-chat-toggle" onclick="toggleForcesChat()" aria-label="Open Aarti Chatbot">💬</button>

<div class="forces-chat" id="forcesChatBox">
    <div class="forces-chat-header">
        <div>
            <strong>Ask Aarti</strong>
            <small>FORCES Assistant</small>
        </div>
        <button type="button" class="forces-chat-close" onclick="toggleForcesChat()">&times;</button>
    </div>
    <div class="forces-chat-messages" id="forcesChatMessages">
        <div class="forces-chat-message">
            Hi! I am Aarti. How can I help you find faculty members or learn about FORCES Committee mentors today?
        </div>
    </div>
    <form class="forces-chat-form" onsubmit="sendForcesMessage(event)">
        <input type="text" id="forcesChatInput" placeholder="Type a message..." required>
        <button type="submit">Send</button>
    </form>
</div>

<script>
// Ask Aarti Chatbot Script
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

    // Append User Message
    const userMsg = document.createElement('div');
    userMsg.className = 'forces-chat-message user';
    userMsg.textContent = text;
    messages.appendChild(userMsg);

    input.value = '';
    messages.scrollTop = messages.scrollHeight;

    // Simulated Bot Response
    setTimeout(() => {
        const botMsg = document.createElement('div');
        botMsg.className = 'forces-chat-message';
        botMsg.textContent = "Thank you for reaching out! You can easily search our faculty directory by name or filter by department using the search tools above.";
        messages.appendChild(botMsg);
        messages.scrollTop = messages.scrollHeight;
    }, 600);
}
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>