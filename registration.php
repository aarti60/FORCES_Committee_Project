<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$pageTitle = 'Create Account | FORCES Committee';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $csrfToken = $_POST['csrf_token'] ?? '';

    if (
        !function_exists('verify_csrf_token') ||
        !verify_csrf_token($csrfToken)
    ) {
        $error = 'Session expired. Refresh the page and try again.';
    } elseif ($name === '' || $email === '' || $phone === ''
        || $password === '' || $confirmPassword === '') {
        $error = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($name) > 100) {
        $error = 'Name must be less than 100 characters.';
    } elseif (!preg_match('/^[0-9+\-\s()]{10,20}$/', $phone)) {
        $error = 'Please enter a valid phone number.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must contain at least 8 characters.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } else {
        try {
            $check = $pdo->prepare(
                'SELECT id FROM users WHERE email = :email LIMIT 1'
            );
            $check->execute(['email' => $email]);

            if ($check->fetch(PDO::FETCH_ASSOC)) {
                $error = 'An account with this email already exists.';
            } else {
                $hashedPassword = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

                // Public registration must never grant admin privileges.
                $role = 'student';

                $stmt = $pdo->prepare(
                    'INSERT INTO users (name, email, phone, password, role)
                     VALUES (:name, :email, :phone, :password, :role)'
                );

                $stmt->execute([
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'password' => $hashedPassword,
                    'role' => $role
                ]);

                redirect('login.php');
            }
        } catch (PDOException $exception) {
            error_log('Account registration error: '
                . $exception->getMessage());

            $error = 'Registration failed. Please check your database setup.';
        }
    }
}

include __DIR__ . '/includes/header.php';
?>

<style>
.register-page {
    min-height: 75vh;
    padding: 45px 18px;
    box-sizing: border-box;
    display: flex;
    justify-content: center;
    align-items: center;
    background:
        radial-gradient(circle at 10% 10%, #dceaff, transparent 35%),
        radial-gradient(circle at 90% 90%, #e8e0ff, transparent 35%),
        #f4f7ff;
}

.register-layout {
    width: 100%;
    max-width: 980px;
    display: grid;
    grid-template-columns: .85fr 1.15fr;
    overflow: hidden;
    border-radius: 24px;
    background: #fff;
    box-shadow: 0 20px 60px rgba(35, 69, 130, .13);
}

.register-welcome {
    padding: 40px 30px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    color: #fff;
    background: linear-gradient(145deg, #6a11cb, #2575fc);
}

.register-logo {
    width: 62px;
    height: 62px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 18px;
    background: rgba(255,255,255,.18);
    border: 1px solid rgba(255,255,255,.3);
    font-size: 27px;
    font-weight: 900;
    margin-bottom: 24px;
}

.register-welcome h1 {
    font-size: clamp(26px, 3vw, 36px);
    line-height: 1.25;
    margin: 0 0 15px;
}

.register-welcome p {
    color: #e7edff;
    font-size: 14px;
    line-height: 1.9;
    margin: 0;
}

.register-benefits {
    display: grid;
    gap: 14px;
    margin-top: 27px;
}

.register-benefit {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
}

.register-check {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 29px;
    height: 29px;
    flex-shrink: 0;
    border-radius: 9px;
    background: rgba(255,255,255,.17);
}

.register-form-area {
    padding: 38px 36px;
}

.register-form-area h2 {
    color: #162b4d;
    font-size: 27px;
    margin: 0 0 7px;
}

.register-subtitle {
    color: #75839a;
    font-size: 13px;
    line-height: 1.7;
    margin: 0 0 23px;
}

.register-message {
    padding: 12px 14px;
    border-radius: 10px;
    font-size: 13px;
    line-height: 1.6;
    margin-bottom: 18px;
}

.register-error {
    color: #b42318;
    background: #fff1f2;
    border: 1px solid #fecaca;
}

.register-success {
    color: #166534;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
}

.register-field {
    margin-bottom: 16px;
}

.register-field label {
    display: block;
    margin-bottom: 7px;
    color: #263a59;
    font-size: 13px;
    font-weight: 700;
}

.register-input-wrap {
    position: relative;
}

.register-input {
    width: 100%;
    box-sizing: border-box;
    padding: 12px 13px;
    border: 1px solid #dbe4f0;
    border-radius: 10px;
    background: #fbfdff;
    color: #172b4d;
    font: inherit;
    font-size: 14px;
    outline: none;
}

.register-input:focus {
    border-color: #5489fa;
    box-shadow: 0 0 0 4px rgba(37,117,252,.1);
}

.register-password {
    padding-right: 68px;
}

.register-toggle {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    border: none;
    background: transparent;
    color: #2868d8;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    padding: 7px;
}

.register-submit {
    width: 100%;
    padding: 14px;
    margin-top: 5px;
    border: none;
    border-radius: 11px;
    color: #fff;
    background: linear-gradient(110deg, #6a11cb, #2575fc);
    font-size: 14px;
    font-weight: 800;
    cursor: pointer;
    transition: transform .2s, box-shadow .2s;
    box-shadow: 0 8px 20px rgba(37,117,252,.2);
}

.register-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 24px rgba(37,117,252,.28);
}

.register-login {
    text-align: center;
    color: #75839a;
    font-size: 13px;
    margin: 21px 0 0;
}

.register-login a {
    color: #2868d8;
    font-weight: 800;
    text-decoration: none;
}

.register-login a:hover {
    text-decoration: underline;
}

.register-security {
    text-align: center;
    color: #8793a6;
    font-size: 11px;
    margin-top: 18px;
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

@media (max-width: 720px) {
    .register-page {
        padding: 25px 13px;
    }

    .register-layout {
        grid-template-columns: 1fr;
        max-width: 480px;
        border-radius: 19px;
    }

    .register-welcome {
        padding: 27px 24px;
    }

    .register-logo {
        width: 50px;
        height: 50px;
        margin-bottom: 16px;
    }

    .register-benefits {
        gap: 9px;
        margin-top: 19px;
    }

    .register-form-area {
        padding: 28px 23px;
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
    .register-submit {
        transition: none;
    }
}
</style>

<main class="register-page">
    <div class="register-layout">

        <section class="register-welcome">
            <div class="register-logo" aria-hidden="true">F</div>

            <h1>Join the FORCES Community</h1>

            <p>
                Create your account to stay connected with committee
                announcements, events and activities.
            </p>

            <div class="register-benefits">
                <div class="register-benefit">
                    <span class="register-check">✓</span>
                    <span>Simple and secure registration</span>
                </div>

                <div class="register-benefit">
                    <span class="register-check">✦</span>
                    <span>Stay informed about events</span>
                </div>

                <div class="register-benefit">
                    <span class="register-check">⌑</span>
                    <span>Join the FORCES community</span>
                </div>
            </div>
        </section>

        <section class="register-form-area">
            <h2>Create Account</h2>

            <p class="register-subtitle">
                Enter your details to get started.
            </p>

            <?php if ($error !== ''): ?>
                <div class="register-message register-error" role="alert">
                    <?= e($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="account-register.php">
                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= e(csrf_token()) ?>"
                >

                <div class="register-field">
                    <label for="name">Full Name</label>

                    <input
                        class="register-input"
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Enter your full name"
                        maxlength="100"
                        autocomplete="name"
                        value="<?= e($_POST['name'] ?? '') ?>"
                        required
                    >
                </div>

                <div class="register-field">
                    <label for="email">Email Address</label>

                    <input
                        class="register-input"
                        type="email"
                        id="email"
                        name="email"
                        placeholder="you@example.com"
                        maxlength="254"
                        autocomplete="email"
                        value="<?= e($_POST['email'] ?? '') ?>"
                        required
                    >
                </div>

                <div class="register-field">
                    <label for="phone">Mobile Number</label>

                    <input
                        class="register-input"
                        type="tel"
                        id="phone"
                        name="phone"
                        placeholder="Enter your mobile number"
                        maxlength="20"
                        autocomplete="tel"
                        value="<?= e($_POST['phone'] ?? '') ?>"
                        required
                    >
                </div>

                <div class="register-field">
                    <label for="password">Password</label>

                    <div class="register-input-wrap">
                        <input
                            class="register-input register-password"
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Minimum 8 characters"
                            minlength="8"
                            autocomplete="new-password"
                            required
                        >

                        <button
                            type="button"
                            class="register-toggle"
                            data-target="password"
                            aria-pressed="false"
                        >
                            Show
                        </button>
                    </div>
                </div>

                <div class="register-field">
                    <label for="confirm_password">Confirm Password</label>

                    <div class="register-input-wrap">
                        <input
                            class="register-input register-password"
                            type="password"
                            id="confirm_password"
                            name="confirm_password"
                            placeholder="Re-enter your password"
                            minlength="8"
                            autocomplete="new-password"
                            required
                        >

                        <button
                            type="button"
                            class="register-toggle"
                            data-target="confirm_password"
                            aria-pressed="false"
                        >
                            Show
                        </button>
                    </div>
                </div>

                <button type="submit" class="register-submit">
                    CREATE ACCOUNT &rarr;
                </button>
            </form>

            <p class="register-login">
                Already have an account?
                <a href="login.php">Login here</a>
            </p>

            <div class="register-security">
                FORCES Committee · Account Registration
            </div>
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
            Hi! I am Aarti. How can I help you with your account registration or FORCES Committee activities today?
        </div>
    </div>
    <form class="forces-chat-form" onsubmit="sendForcesMessage(event)">
        <input type="text" id="forcesChatInput" placeholder="Type a message..." required>
        <button type="submit">Send</button>
    </form>
</div>

<script>
// Password Toggles & Form Validation
document.querySelectorAll('.register-toggle').forEach(function (button) {
    button.addEventListener('click', function () {
        const input = document.getElementById(button.dataset.target);
        const show = input.type === 'password';

        input.type = show ? 'text' : 'password';
        button.textContent = show ? 'Hide' : 'Show';
        button.setAttribute('aria-pressed', String(show));
    });
});

const registrationForm = document.querySelector(
    'form[action="account-register.php"]'
);

if (registrationForm) {
    registrationForm.addEventListener('submit', function (event) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;

        if (password !== confirmPassword) {
            event.preventDefault();
            alert('Passwords do not match. Please try again.');
            document.getElementById('confirm_password').focus();
        }
    });
}

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
        botMsg.textContent = "Thank you for reaching out! If you need help with registration requirements or committee events, please let me know.";
        messages.appendChild(botMsg);
        messages.scrollTop = messages.scrollHeight;
    }, 600);
}
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>