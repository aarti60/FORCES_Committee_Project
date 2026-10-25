<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Past Members | FORCES Committee';

/*
 * Committee-wise members.
 * Update the roles and names to match your official list.
 */
$committees = [
    'Leadership Committee' => [
        ['role' => 'President', 'name' => 'Trupti Kumari'],
        ['role' => 'Secretary', 'name' => 'Gautami Chabukswar'],
        ['role' => 'Vice-President', 'name' => 'Anand Nawale'],
    ],

    'Treasurer Committee' => [
        ['role' => 'Committee Member', 'name' => 'Azka Fatema'],
        ['role' => 'Committee Member', 'name' => 'Vishakha Damodhar'],
    ],

    'Technical Committee' => [
        ['role' => 'Technical Member', 'name' => 'Sandesh Bansode'],
        ['role' => 'Technical Member', 'name' => 'Vaibhav Aran'],
        ['role' => 'Technical Member', 'name' => 'Aarti Satav'],
        ['role' => 'Technical Member', 'name' => 'Rutuja Kendhale'],
    ],

    'Social Media Committee' => [
        ['role' => 'Committee Member', 'name' => 'Sanjyot Tembulkar'],
        ['role' => 'Committee Member', 'name' => 'Avishkar Bhagat'],
        ['role' => 'Committee Member', 'name' => 'Sakshi Tangade'],
        ['role' => 'Committee Member', 'name' => 'Prashik Jadhav'],
        ['role' => 'Committee Member', 'name' => 'Maroti Kautker'],
        ['role' => 'Committee Member', 'name' => 'Sarthak Bhandare'],
    ],
    'Photography Committee' => [
        ['role' => 'Committee Member', 'name' => 'Sakshi Gaikwad'],
        ['role' => 'Committee Member', 'name' => 'Payal Rathod'],
        ['role' => 'Committee Member', 'name' => 'Susmita Gaikwad'],
        ['role' => 'Committee Member', 'name' => 'Shubham Bedare'],
        ['role' => 'Committee Member', 'name' => 'Sanskruti Surse'],
    ],

    'Report Committee' => [
        ['role' => 'Committee Member', 'name' => 'Sayli Mote'],
        ['role' => 'Committee Member', 'name' => 'Nagma Begam'],
        ['role' => 'Committee Member', 'name' => 'Tanvi Shinde'],
        ['role' => 'Committee Member', 'name' => 'Disha Perkar'],
        ['role' => 'Committee Member', 'name' => 'Vyankatesh Lavgi'],
        ['role' => 'Committee Member', 'name' => 'Kuldip Surawanshi'],
    ], 
    'Printing And Publicity Committee' => [
        ['role' => 'Committee Member', 'name' => 'Syed Asim'],
        ['role' => 'Committee Member', 'name' => 'Abhilasha Dolse'],
        ['role' => 'Committee Member', 'name' => 'Pranav Sonawane'],
        ['role' => 'Committee Member', 'name' => 'Nitesh Pawale'],
        ['role' => 'Committee Member', 'name' => 'Gauri Atawane'],
    ],

    'Discipline Committee' => [
        ['role' => 'Committee Member', 'name' => 'Nikita Shelke'],
        ['role' => 'Committee Member', 'name' => 'Jeewak Khandare'],
        ['role' => 'Committee Member', 'name' => 'Vaishnavi Darade'],
        ['role' => 'Committee Member', 'name' => 'Renuka Kamble'],
        ['role' => 'Committee Member', 'name' => 'Sambhaji Mahajan'],
        ['role' => 'Committee Member', 'name' => 'Pravin Kedar'],
    ],
];

$totalMembers = 0;

foreach ($committees as $members) {
    $totalMembers += count($members);
}

include __DIR__ . '/includes/header.php';
?>

<style>
.past-page {
    min-height: 70vh;
    padding: 48px 0 65px;
    background: #f4f7ff;
}

.past-hero {
    position: relative;
    overflow: hidden;
    padding: 38px 25px;
    margin-bottom: 35px;
    border-radius: 20px;
    text-align: center;
    color: #ffffff;
    background: linear-gradient(120deg, #6a11cb, #2575fc);
}

.past-hero h1 {
    margin: 0 0 12px;
    color: #ffffff;
    font-size: clamp(27px, 4vw, 38px);
}

.past-hero p {
    margin: 7px 0;
    color: #eef4ff;
    line-height: 1.7;
}

.past-count {
    display: inline-block;
    margin-top: 12px;
    padding: 9px 16px;
    border: 1px solid rgba(255,255,255,.4);
    border-radius: 30px;
    font-size: 13px;
    font-weight: 700;
}

.committee-section {
    margin-bottom: 32px;
}

.committee-heading {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 17px;
    padding: 17px 20px;
    border: 1px solid #dce7fa;
    border-left: 5px solid #2575fc;
    border-radius: 12px;
    background: #ffffff;
}

.committee-icon {
    display: flex;
    flex-shrink: 0;
    align-items: center;
    justify-content: center;
    width: 46px;
    height: 46px;
    border-radius: 12px;
    color: #ffffff;
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    font-size: 21px;
}

.committee-heading h2 {
    margin: 0;
    color: #193765;
    font-size: 20px;
}

.committee-heading p {
    margin: 5px 0 0;
    color: #74839a;
    font-size: 12px;
}

.member-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
}

.member-card {
    position: relative;
    padding: 20px;
    overflow: hidden;
    border: 1px solid #e0e9f7;
    border-radius: 14px;
    background: #ffffff;
    box-shadow: 0 5px 17px rgba(31, 74, 130, .05);
    transition: transform .25s ease, box-shadow .25s ease;
}

.member-card::before {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    content: "";
    background: linear-gradient(90deg, #6a11cb, #2575fc);
}

.member-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 24px rgba(37, 117, 252, .12);
}

.member-role {
    display: inline-block;
    margin-bottom: 12px;
    padding: 6px 10px;
    border-radius: 7px;
    background: #edf3ff;
    color: #245fc1;
    font-size: 11px;
    font-weight: 800;
}

.member-card h3 {
    margin: 0;
    color: #243b65;
    font-size: 16px;
    line-height: 1.5;
    overflow-wrap: anywhere;
}

.member-label {
    margin-top: 9px;
    color: #8794a8;
    font-size: 11px;
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

@media (max-width: 850px) {
    .member-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 520px) {
    .past-page {
        padding: 28px 0 42px;
    }

    .past-hero {
        padding: 28px 16px;
    }

    .member-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .committee-heading {
        padding: 14px;
    }

    .committee-heading h2 {
        font-size: 17px;
    }

    .member-card {
        padding: 18px;
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

<main>
    <section class="past-page">
        <div class="container">

            <header class="past-hero">
                <h1>FORCES Past Members</h1>

                <p>Academic Batch 2025–26</p>

                <p>
                    Department of Computer Science and Engineering
                </p>

                <span class="past-count">
                    <?= (int) $totalMembers ?> Members
                    &nbsp; | &nbsp;
                    <?= count($committees) ?> Committees
                </span>
            </header>

            <?php
            $icons = [
                'Leadership Committee' => '👑',
                'Treasurer Committee' => '💰',
                'Technical Committee' => '💻',
                'Social Media Committee' => '📱',
                'Photography Committee' => '📸',
                'Report Committee' => '📝',
                'Printing And Publicity Committee' => '🖨️',
                'Discipline Committee' => '🛡️',
            ];
            ?>

            <?php foreach ($committees as $committeeName => $members): ?>

                <section class="committee-section">

                    <div class="committee-heading">

                        <div class="committee-icon">
                            <?= $icons[$committeeName] ?? '👥' ?>
                        </div>

                        <div>
                            <h2>
                                <?= htmlspecialchars(
                                    $committeeName,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </h2>

                            <p>
                                <?= count($members) ?> Members
                            </p>
                        </div>

                    </div>

                    <div class="member-grid">

                        <?php foreach ($members as $member): ?>

                            <article class="member-card">

                                <span class="member-role">
                                    <?= htmlspecialchars(
                                        $member['role'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </span>

                                <h3>
                                    <?= htmlspecialchars(
                                        $member['name'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </h3>

                                <div class="member-label">
                                    FORCES • 2025–26
                                </div>

                            </article>

                        <?php endforeach; ?>

                    </div>

                </section>

            <?php endforeach; ?>

        </div>
    </section>
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
            Hi! I am Aarti. How can I help you find past FORCES Committee members or batch details today?
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
        botMsg.textContent = "Thank you for reaching out! You can view past committee members listed above by their respective committees and roles for the 2025–26 batch.";
        messages.appendChild(botMsg);
        messages.scrollTop = messages.scrollHeight;
    }, 600);
}
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>