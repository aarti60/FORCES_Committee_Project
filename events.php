
<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Events and Activities';

/*
|--------------------------------------------------------------------------
| Event Gallery
|--------------------------------------------------------------------------
| Add event photos inside:
| assets/images/events/
|--------------------------------------------------------------------------
*/

$events = [
    [
        'title' => 'ASCEND 2K26',
        'description' => 'A Placement Preparation Event',
        'date' => '07 May 2026',
        'image' => 'assets/images/events/ascend-2k26.jpg',
    ],
    [
        'title' => 'CODE SMASH',
        'description' => 'Coding Competition',
        'date' => '11 March 2025',
        'image' => 'assets/images/events/code-smash.jpg',
    ],
    [
        'title' => 'Induction Day One',
        'description' => 'FORCES Event Report',
        'date' => '08 September 2025',
        'image' => 'assets/images/events/induction-day-one.jpg',
    ],
    [
        'title' => 'Induction Day Two',
        'description' => 'FORCES Event Report',
        'date' => '09 September 2025',
        'image' => 'assets/images/events/induction-day-two.jpg',
    ],
    [
        'title' => 'FORCES Inauguration',
        'description' => 'Inauguration Event of FORCES',
        'date' => '21 November 2025',
        'image' => 'assets/images/events/forces-inauguration.jpg',
    ],
    [
        'title' => 'Induction Program 2K26',
        'description' => 'First Year Student Induction Program',
        'date' => '09 February 2026',
        'image' => 'assets/images/events/induction-program-2k6.jpg',
    ],
    [
        'title' => 'WARZONE 2K26',
        'description' => 'An exciting event of competition, teamwork and fun.',
        'date' => '2026',
        'image' => 'assets/images/events/warzone2k26.jpg',
    ],
];

include __DIR__ . '/includes/header.php';
?>

<style>
.events-page {
    background: #e2f6f5;
    min-height: 80vh;
    padding: 35px 0 60px;
}

.events-container {
    width: 92%;
    max-width: 1450px;
    margin: auto;
}

.events-heading {
    margin-bottom: 38px;
}

.events-heading h1 {
    color: #111827;
    font-size: clamp(28px, 4vw, 36px);
    font-weight: 800;
    margin: 0 0 8px;
}

.events-heading p {
    color: #64748b;
    font-size: 16px;
    margin: 0;
    line-height: 1.7;
}

.events-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 36px 45px;
}

.event-card {
    min-width: 0;
    overflow: hidden;
    background: #e8dfce;
    border-radius: 15px;
    box-shadow: 0 5px 18px rgba(30, 64, 100, 0.08);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.event-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 26px rgba(30, 64, 100, 0.16);
}

.event-image-button {
    display: block;
    width: 100%;
    padding: 0;
    border: 0;
    background: transparent;
    cursor: pointer;
    text-align: left;
}

.event-image {
    width: 100%;
    height: 230px;
    display: block;
    object-fit: contain;
    background: #e8dfce;
    transition: transform 0.3s ease;
}

.event-card:hover .event-image {
    transform: scale(1.02);
}

.event-info {
    padding: 15px 17px 18px;
    background: #fff;
}

.event-info h2 {
    color: #183b72;
    font-size: 19px;
    margin: 0 0 7px;
    font-weight: 800;
}

.event-info p {
    color: #64748b;
    font-size: 14px;
    line-height: 1.6;
    margin: 0 0 9px;
}

.event-date {
    display: inline-block;
    padding: 5px 10px;
    background: #edf4ff;
    color: #2463bf;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
}

.event-missing {
    height: 230px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 15px;
    text-align: center;
    box-sizing: border-box;
    color: #52647b;
    background: #e8dfce;
}

.event-missing svg {
    width: 48px;
    height: 48px;
    color: #7187a8;
}

.event-missing span {
    font-weight: 700;
}

.event-missing small {
    font-size: 12px;
    overflow-wrap: anywhere;
}

.event-modal {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: rgba(9, 20, 40, 0.88);
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.event-modal.open {
    display: flex;
}

.event-modal-content {
    position: relative;
    max-width: 1000px;
    width: 100%;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
}

.event-modal-content img {
    display: block;
    max-width: 100%;
    max-height: 78vh;
    object-fit: contain;
    border-radius: 10px;
}

.event-modal-title {
    color: #fff;
    font-size: 17px;
    text-align: center;
}

.event-modal-close {
    position: absolute;
    top: -42px;
    right: 0;
    width: 38px;
    height: 38px;
    border: 0;
    border-radius: 50%;
    background: #fff;
    color: #183b72;
    font-size: 26px;
    cursor: pointer;
}

@media (max-width: 1000px) {
    .events-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 25px;
    }
}

@media (max-width: 600px) {
    .events-page {
        padding: 25px 0 40px;
    }

    .events-container {
        width: 92%;
    }

    .events-grid {
        grid-template-columns: 1fr;
        gap: 22px;
    }

    .event-image,
    .event-missing {
        height: 240px;
    }

    .events-heading {
        margin-bottom: 25px;
    }
}
</style>

<main class="events-page">
    <div class="events-container">

        <section class="events-heading">
            <h1>Event Gallery</h1>
            <p>Moments, memories and milestones from our journey together.</p>
        </section>

        <section class="events-grid">

            <?php foreach ($events as $event): ?>
                <?php
                $imagePath = __DIR__ . '/' . $event['image'];
                $imageExists = is_file($imagePath);
                ?>

                <article class="event-card">

                    <?php if ($imageExists): ?>

                        <button
                            type="button"
                            class="event-image-button"
                            data-image="<?= e($event['image']) ?>"
                            data-title="<?= e($event['title']) ?>"
                            aria-label="View <?= e($event['title']) ?> photo"
                        >
                            <img
                                class="event-image"
                                src="<?= e($event['image']) ?>"
                                alt="<?= e($event['title']) ?>"
                                loading="lazy"
                            >
                        </button>

                    <?php else: ?>

                        <div class="event-missing">
                            <svg viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.5"
                                 aria-hidden="true">
                                <rect x="3" y="3" width="18" height="18"
                                      rx="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <path d="m21 15-5-5L5 21"/>
                            </svg>

                            <span>Event photo not found</span>
                            <small><?= e($event['image']) ?></small>
                        </div>

                    <?php endif; ?>

                    <div class="event-info">
                        <h2><?= e($event['title']) ?></h2>

                        <p><?= e($event['description']) ?></p>

                        <span class="event-date">
                            <?= e($event['date']) ?>
                        </span>
                    </div>

                </article>

            <?php endforeach; ?>

        </section>
    </div>
</main>

<div
    class="event-modal"
    id="eventModal"
    role="dialog"
    aria-modal="true"
    aria-label="Event photo preview"
>
    <div class="event-modal-content">
        <button
            type="button"
            class="event-modal-close"
            id="eventModalClose"
            aria-label="Close photo"
        >&times;</button>

        <img id="eventModalImage" src="" alt="">

        <div class="event-modal-title" id="eventModalTitle"></div>
    </div>
</div>

<script>
(function () {
    const modal = document.getElementById('eventModal');
    const modalImage = document.getElementById('eventModalImage');
    const modalTitle = document.getElementById('eventModalTitle');
    const closeButton = document.getElementById('eventModalClose');

    document.querySelectorAll('.event-image-button').forEach(function (button) {
        button.addEventListener('click', function () {
            modalImage.src = button.dataset.image;
            modalImage.alt = button.dataset.title;
            modalTitle.textContent = button.dataset.title;
            modal.classList.add('open');
            document.body.style.overflow = 'hidden';
            closeButton.focus();
        });
    });

    function closeModal() {
        modal.classList.remove('open');
        modalImage.src = '';
        document.body.style.overflow = '';
    }

    closeButton.addEventListener('click', closeModal);

    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });
})();
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
