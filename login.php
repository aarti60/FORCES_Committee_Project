
<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (function_exists('is_logged_in') && is_logged_in()) {
    redirect('index.php');
}

$pageTitle = 'Login | FORCES Committee';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $csrfToken = $_POST['csrf_token'] ?? '';

    if (
        !function_exists('verify_csrf_token') ||
        !verify_csrf_token($csrfToken)
    ) {
        $error = 'Your session has expired. Please refresh the page and try again.';
    } elseif ($email === '' || $password === '') {
        $error = 'Please enter your email and password.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        try {
            /*
             * Assumes users table has:
             * id, name, email, password, role
             *
             * If your password column has another name,
             * change the query accordingly.
             */
            $stmt = $pdo->prepare(
                'SELECT id, name, email, password, role
                 FROM users
                 WHERE email = :email
                 LIMIT 1'
            );

            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (
                $user &&
                password_verify($password, $user['password'])
            ) {
                session_regenerate_id(true);

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];

                redirect('index.php');
            } else {
                $error = 'Invalid email or password.';
            }
        } catch (PDOException $exception) {
            error_log('Login error: ' . $exception->getMessage());
            $error = 'Unable to log in right now. Please check your database configuration.';
        }
    }
}

include __DIR__ . '/includes/header.php';
?>

<style>
.login-page {
    min-height: 75vh;
    padding: 55px 18px;
    box-sizing: border-box;
    display: flex;
    align-items: center;
    justify-content: center;
    background:
        radial-gradient(circle at 10% 10%, #dceaff 0, transparent 35%),
        radial-gradient(circle at 90% 90%, #e8e0ff 0, transparent 35%),
        #f4f7ff;
}

.login-layout {
    width: 100%;
    max-width: 950px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    overflow: hidden;
    background: #fff;
    border-radius: 24px;
    box-shadow: 0 20px 65px rgba(35, 69, 130, .13);
}

.login-welcome {
    padding: 45px 35px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    color: #fff;
    background: linear-gradient(145deg, #6a11cb, #2575fc);
}

.login-logo {
    width: 66px;
    height: 66px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 19px;
    border: 1px solid rgba(255,255,255,.4);
    background: rgba(255,255,255,.16);
    font-size: 28px;
    font-weight: 900;
    margin-bottom: 26px;
}

.login-welcome h1 {
    font-size: clamp(27px, 3vw, 37px);
    font-weight: 850;
    line-height: 1.2;
    margin: 0 0 15px;
}

.login-welcome p {
    color: #e7edff;
    font-size: 14px;
    line-height: 1.9;
    margin: 0;
}

.login-features {
    display: grid;
    gap: 14px;
    margin-top: 30px;
}

.login-feature {
    display: flex;
    align-items: center;
    gap: 11px;
    color: #f4f7ff;
    font-size: 13px;
}

.login-feature-icon {
    width: 31px;
    height: 31px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border-radius: 10px;
    background: rgba(255,255,255,.16);
}

.login-form-area {
    padding: 45px 38px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.login-form-area h2 {
    color: #162b4d;
    font-size: 27px;
    font-weight: 800;
    margin: 0 0 8px;
}

.login-subtitle {
    color: #75839a;
    font-size: 13px;
    line-height: 1.7;
    margin: 0 0 27px;
}

.login-error {
    padding: 12px 14px;
    margin-bottom: 18px;
    border: 1px solid #fecaca;
    border-radius: 10px;
    background: #fff1f2;
    color: #b42318;
    font-size: 13px;
    line-height: 1.6;
}

.login-field {
    margin-bottom: 18px;
}

.login-field label {
    display: block;
    color: #263a59;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 8px;
}

.login-input-wrap {
    position: relative;
}

.login-input {
    display: block;
    width: 100%;
    box-sizing: border-box;
    padding: 13px 14px;
    border: 1px solid #dbe4f0;
    border-radius: 11px;
    background: #fbfdff;
    color: #172b4d;
    font: inherit;
    font-size: 14px;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
}

.login-input:focus {
    border-color: #5489fa;
    box-shadow: 0 0 0 4px rgba(37,117,252,.11);
}

.password-input {
    padding-right: 74px;
}

.password-toggle {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    border: none;
    background: transparent;
    color: #2868d8;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    padding: 8px;
}

.login-options {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
    margin: 0 0 23px;
    font-size: 12px;
}

.remember-option {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: #64748b;
    cursor: pointer;
}

.remember-option input {
    accent-color: #2575fc;
}

.forgot-link {
    color: #2868d8;
    text-decoration: none;
    font-weight: 700;
}

.forgot-link:hover {
    text-decoration: underline;
}

.login-submit {
    width: 100%;
    padding: 14px 18px;
    border: none;
    border-radius: 11px;
    background: linear-gradient(110deg, #6a11cb, #2575fc);
    color: #fff;
    font-size: 14px;
    font-weight: 800;
    cursor: pointer;
    box-shadow: 0 8px 20px rgba(37,117,252,.22);
    transition: transform .2s, box-shadow .2s;
}

.login-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 24px rgba(37,117,252,.3);
}

.login-security {
    margin-top: 22px;
    color: #8793a6;
    text-align: center;
    font-size: 11px;
    line-height: 1.7;
}

.login-security span {
    color: #2868d8;
    font-weight: 800;
}

@media (max-width: 720px) {
    .login-page {
        padding: 30px 14px;
    }

    .login-layout {
        grid-template-columns: 1fr;
        max-width: 480px;
        border-radius: 19px;
    }

    .login-welcome {
        padding: 28px 25px;
    }

    .login-logo {
        width: 52px;
        height: 52px;
        font-size: 23px;
        margin-bottom: 18px;
    }

    .login-features {
        grid-template-columns: 1fr;
        gap: 10px;
        margin-top: 20px;
    }

    .login-form-area {
        padding: 30px 24px;
    }
}

@media (prefers-reduced-motion: reduce) {
    .login-input,
    .login-submit {
        transition: none;
    }
}
</style>

<main class="login-page">
    <div class="login-layout">

        <section class="login-welcome">
            <div class="login-logo" aria-hidden="true">F</div>

            <h1>Welcome Back!</h1>

            <p>
                Sign in to your FORCES Committee account to stay connected
                with events, notices and committee activities.
            </p>

            <div class="login-features">
                <div class="login-feature">
                    <span class="login-feature-icon">✓</span>
                    <span>Stay updated with announcements</span>
                </div>

                <div class="login-feature">
                    <span class="login-feature-icon">✦</span>
                    <span>Explore events and activities</span>
                </div>

                <div class="login-feature">
                    <span class="login-feature-icon">⌑</span>
                    <span>Secure account access</span>
                </div>
            </div>
        </section>

        <section class="login-form-area">
            <h2>Login to Account</h2>

            <p class="login-subtitle">
                Enter your registered email and password below.
            </p>

            <?php if ($error !== ''): ?>
                <div class="login-error" role="alert">
                    <?= e($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= e(csrf_token()) ?>"
                >

                <div class="login-field">
                    <label for="email">Email Address</label>

                    <input
                        class="login-input"
                        type="email"
                        id="email"
                        name="email"
                        placeholder="you@example.com"
                        autocomplete="username"
                        value="<?= e($_POST['email'] ?? '') ?>"
                        required
                    >
                </div>

                <div class="login-field">
                    <label for="password">Password</label>

                    <div class="login-input-wrap">
                        <input
                            class="login-input password-input"
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            id="togglePassword"
                            aria-controls="password"
                            aria-pressed="false"
                        >
                            Show
                        </button>
                    </div>
                </div>

                <div class="login-options">
                    <label class="remember-option">
                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                        >
                        Remember me
                    </label>

                    <a class="forgot-link" href="forgot-password.php">
                        Forgot password?
                    </a>
                </div>

                <button type="submit" class="login-submit">
                    SIGN IN &rarr;
                </button>
            </form>

            <div class="login-security">
                <span>FORCES Committee</span><br>
                Secure access to your account
            </div>
        </section>

    </div>
</main>

<script>
(function () {
    const password = document.getElementById('password');
    const toggle = document.getElementById('togglePassword');

    toggle.addEventListener('click', function () {
        const isPassword = password.type === 'password';

        password.type = isPassword ? 'text' : 'password';
        toggle.textContent = isPassword ? 'Hide' : 'Show';
        toggle.setAttribute('aria-pressed', String(isPassword));
    });
})();
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
