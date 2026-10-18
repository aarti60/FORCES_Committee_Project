
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

    ' Social Media Committee' => [
        ['role' => 'Committee Member', 'name' => 'Sanjyot Tembulkar'],
        ['role' => 'Committee Member', 'name' => 'Avishkar Bhagat'],
        ['role' => 'Committee Member', 'name' => 'sakshi Tangade'],
        ['role' => 'Committee Member', 'name' => 'Prashik Jadhav'],
       ['role' => 'Committee Member', 'name' => 'Maroti Kautker'],
        ['role' => 'Committee Member', 'name' => 'Sarthak Bhandare'],
    ],
    'Photography Committee'=>[
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
                'Photography & Social Media Committee' => '📸',
                'Report Committee' => '📝',
                'Discipline Committee' => '🛡️',
                'Volunteers Committee' => '🤝',
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

<?php include __DIR__ . '/includes/footer.php'; ?>
