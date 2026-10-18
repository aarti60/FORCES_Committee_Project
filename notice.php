
<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Notices and Announcements';

include __DIR__ . '/includes/header.php';
?>

<style>
.notices-page {
    background: #f1f7ff;
    min-height: 80vh;
    padding: 40px 0 65px;
}

.notices-container {
    max-width: 1150px;
    width: 92%;
    margin: auto;
}

.notices-heading {
    margin-bottom: 30px;
}

.notices-heading h1 {
    color: #142b4d;
    font-size: clamp(28px, 4vw, 38px);
    margin: 0 0 8px;
    font-weight: 800;
}

.notices-heading p {
    color: #64748b;
    margin: 0;
    line-height: 1.7;
}

.upcoming-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #fff2d8;
    color: #9a5700;
    padding: 8px 13px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 800;
    margin-bottom: 18px;
}

.pulse-dot {
    width: 9px;
    height: 9px;
    background: #f59e0b;
    border-radius: 50%;
    animation: pulse 1.4s infinite;
}

@keyframes pulse {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(245, 158, 11, .45);
    }
    50% {
        box-shadow: 0 0 0 7px rgba(245, 158, 11, 0);
    }
}

.code-smash-card {
    position: relative;
    overflow: hidden;
    display: grid;
    grid-template-columns: 1.15fr .85fr;
    gap: 25px;
    align-items: center;
    padding: 35px;
    color: white;
    border-radius: 24px;
    background: linear-gradient(130deg, #10264d, #174b91 58%, #2575fc);
    box-shadow: 0 18px 45px rgba(37, 99, 180, .2);
    isolation: isolate;
}

.code-smash-card::before,
.code-smash-card::after {
    content: "";
    position: absolute;
    border: 1px solid rgba(255,255,255,.13);
    border-radius: 50%;
    z-index: -1;
    pointer-events: none;
}

.code-smash-card::before {
    width: 300px;
    height: 300px;
    right: -80px;
    top: -130px;
    animation: orbit 12s linear infinite;
}

.code-smash-card::after {
    width: 220px;
    height: 220px;
    right: -35px;
    bottom: -140px;
}

@keyframes orbit {
    to { transform: rotate(360deg); }
}

.event-content {
    position: relative;
    z-index: 1;
}

.event-kicker {
    color: #a9d5ff;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.event-content h2 {
    font-size: clamp(35px, 5vw, 56px);
    line-height: 1.1;
    margin: 15px 0;
    font-weight: 900;
    letter-spacing: -1px;
}

.event-content h2 span {
    color: #7ce7ff;
}

.event-content p {
    color: #e0ecff;
    font-size: 15px;
    line-height: 1.8;
    max-width: 520px;
}

.event-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 9px;
    margin: 20px 0;
}

.event-tag {
    padding: 8px 12px;
    border-radius: 9px;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.18);
    color: white;
    font-size: 12px;
}

.event-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 24px;
}

.event-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border: 0;
    border-radius: 10px;
    padding: 12px 18px;
    font-size: 13px;
    font-weight: 800;
    cursor: pointer;
    transition: transform .2s, background .2s;
    text-decoration: none;
}

.event-btn:hover {
    transform: translateY(-3px);
}

.event-btn-primary {
    background: #fff;
    color: #174b91;
}

.event-btn-secondary {
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.3);
    color: white;
}

.event-art {
    position: relative;
    z-index: 1;
    min-height: 260px;
    display: flex;
    align-items: center;
    justify-content: center;
    perspective: 800px;
}

.code-window {
    width: 100%;
    max-width: 360px;
    border: 1px solid rgba(255,255,255,.22);
    border-radius: 16px;
    background: rgba(5, 18, 43, .78);
    box-shadow: 0 20px 45px rgba(0,0,0,.22);
    overflow: hidden;
    transform: rotateY(-7deg) rotateX(3deg);
    animation: floatWindow 4s ease-in-out infinite;
}

@keyframes floatWindow {
    0%, 100% { transform: translateY(0) rotateY(-7deg); }
    50% { transform: translateY(-10px) rotateY(-3deg); }
}

.window-top {
    padding: 13px;
    display: flex;
    align-items: center;
    gap: 6px;
    border-bottom: 1px solid rgba(255,255,255,.1);
}

.window-dot {
    width: 9px;
    height: 9px;
    border-radius: 50%;
    background: #7ce7ff;
}

.window-title {
    margin-left: 7px;
    color: #d6e8ff;
    font-size: 11px;
}

.code-lines {
    padding: 20px 16px;
    font-family: Consolas, monospace;
    font-size: 13px;
    line-height: 2;
    color: #dbeafe;
    overflow-wrap: anywhere;
}

.code-line {
    opacity: 0;
    animation: typeLine .5s forwards;
}

.code-line:nth-child(1) { animation-delay: .2s; }
.code-line:nth-child(2) { animation-delay: .5s; }
.code-line:nth-child(3) { animation-delay: .8s; }
.code-line:nth-child(4) { animation-delay: 1.1s; }
.code-line:nth-child(5) { animation-delay: 1.4s; }

@keyframes typeLine {
    to { opacity: 1; }
}

.code-purple { color: #d5a8ff; }
.code-green { color: #8af0c4; }
.code-yellow { color: #ffe58a; }

.event-details {
    display: none;
    margin-top: 25px;
    padding: 22px;
    border-radius: 16px;
    background: #fff;
    border: 1px solid #dce8fa;
    color: #334155;
    animation: reveal .3s ease;
}

.event-details.show {
    display: block;
}

@keyframes reveal {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}

.event-details h3 {
    margin: 0 0 12px;
    color: #183b72;
}

.event-details p {
    line-height: 1.8;
    margin: 7px 0;
}

.notice-note {
    margin-top: 25px;
    border-radius: 13px;
    padding: 17px 20px;
    background: white;
    border: 1px solid #dce8fa;
    color: #64748b;
    font-size: 13px;
    line-height: 1.7;
}

@media (max-width: 760px) {
    .code-smash-card {
        grid-template-columns: 1fr;
        padding: 25px 20px;
        gap: 5px;
    }

    .event-art {
        min-height: 220px;
    }

    .code-window {
        max-width: 100%;
    }

    .event-content h2 {
        font-size: 39px;
    }
}

@media (prefers-reduced-motion: reduce) {
    *, *::before, *::after {
        animation-duration: .01ms !important;
        animation-iteration-count: 1 !important;
        scroll-behavior: auto !important;
    }
}
</style>

<main class="notices-page">
    <div class="notices-container">

        <section class="notices-heading">
            <h1>Notices & Announcements</h1>
            <p>Stay updated with upcoming events, important announcements and FORCES activities.</p>
        </section>

        <div class="upcoming-label">
            <span class="pulse-dot"></span>
            UPCOMING EVENT
        </div>

        <section class="code-smash-card">

            <div class="event-content">
                <div class="event-kicker">
                    FORCES Committee Presents
                </div>

                <h2>CODE SMASH <span>2.0</span></h2>

                <p>
                    Ready to test your coding skills?
                    Get ready for a coding challenge focused on
                    logic, problem-solving and creative thinking.
                    More event details will be announced soon.
                </p>

                <div class="event-tags">
                    <span class="event-tag">💻 Coding Challenge</span>
                    <span class="event-tag">🧠 Logical Thinking</span>
                    <span class="event-tag">⚡ Tech & Innovation</span>
                </div>

                <div class="event-actions">
                    <button
                        type="button"
                        class="event-btn event-btn-primary"
                        id="detailsButton"
                        aria-expanded="false"
                        aria-controls="eventDetails"
                    >
                        <span id="detailsButtonText">Explore Event ↓</span>
                    </button>

                    <button
                        type="button"
                        class="event-btn event-btn-secondary"
                        id="shareButton"
                    >
                        ↗ Share Notice
                    </button>
                </div>
            </div>

            <div class="event-art" aria-label="Animated coding illustration">
                <div class="code-window">
                    <div class="window-top">
                        <span class="window-dot"></span>
                        <span class="window-dot"></span>
                        <span class="window-dot"></span>
                        <span class="window-title">code_smash_2.js</span>
                    </div>

                    <div class="code-lines">
                        <div class="code-line">
                            <span class="code-purple">const</span> event =
                            <span class="code-green">"CODE SMASH 2.0"</span>;
                        </div>
                        <div class="code-line">
                            <span class="code-purple">function</span>
                            <span class="code-yellow">solveChallenge</span>() {
                        </div>
                        <div class="code-line">
                            &nbsp;&nbsp;skills++;
                        </div>
                        <div class="code-line">
                            &nbsp;&nbsp;innovation =
                            <span class="code-green">true</span>;
                        </div>
                        <div class="code-line">
                            &nbsp;&nbsp;<span class="code-purple">return</span>
                            "Ready to code!";
                        </div>
                        <div style="color:#d5a8ff;">}</div>
                    </div>
                </div>
            </div>

        </section>

        <section
            class="event-details"
            id="eventDetails"
            aria-hidden="true"
        >
            <h3>📢 About CODE SMASH 2.0</h3>

            <p>
                <strong>Event:</strong> CODE SMASH 2.0
            </p>

            <p>
                <strong>Organized by:</strong> FORCES Committee
            </p>

            <p>
                <strong>Category:</strong> Coding Competition
            </p>

            <p>
                <strong>Date & Time:</strong> To be announced
            </p>

            <p>
                <strong>Venue:</strong> To be announced
            </p>

            <p>
                <strong>Registration:</strong> Registration details will be announced soon.
            </p>
        </section>

        <div class="notice-note">
            <strong>Important:</strong> This is a demo announcement.
            Please confirm the official event date, venue and registration
            details with the organizers before publishing the final notice.
        </div>

    </div>
</main>

<script>
(function () {
    const detailsButton = document.getElementById('detailsButton');
    const details = document.getElementById('eventDetails');
    const buttonText = document.getElementById('detailsButtonText');
    const shareButton = document.getElementById('shareButton');

    detailsButton.addEventListener('click', function () {
        const isOpen = details.classList.toggle('show');

        detailsButton.setAttribute('aria-expanded', String(isOpen));
        details.setAttribute('aria-hidden', String(!isOpen));

        buttonText.textContent = isOpen
            ? 'Hide Details ↑'
            : 'Explore Event ↓';

        if (isOpen) {
            details.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        }
    });

    shareButton.addEventListener('click', async function () {
        const shareData = {
            title: 'CODE SMASH 2.0',
            text: 'Check out the upcoming CODE SMASH 2.0 event by FORCES Committee!',
            url: window.location.href
        };

        try {
            if (navigator.share) {
                await navigator.share(shareData);
            } else if (navigator.clipboard) {
                await navigator.clipboard.writeText(
                    shareData.text + ' ' + shareData.url
                );
                shareButton.textContent = '✓ Link Copied';
            } else {
                window.prompt('Copy this event link:', window.location.href);
            }
        } catch (error) {
            if (error.name !== 'AbortError') {
                window.prompt('Copy this event link:', window.location.href);
            }
        }
    });
})();
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
