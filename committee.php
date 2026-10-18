
<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'FORCES Committee Members';


$groups = [
    'Leadership' => [
        ['Avishkar Bhagat', 'President'],
        ['Vyankatesh Lavgji', 'Honorary President'],
        ['Nikita Dattatray Shelke', 'Vice President'],
        ['Sanskriti Surse', 'Vice President'],
        ['Vaibhav Aran', 'Secretary'],
        ['Kuldip Suryawanshi', 'Secretary'],
    ],

    'Treasurer Committee' => [
        ['Aarti Ashok Satav', 'Treasurer Committee'],
        ['Sarthak Bhandare', 'Treasurer Committee'],
        ['Sanchita Santosh Vaijwade', 'Treasurer Committee'],
        ['Shaikh Saniya Jaker', 'Treasurer Committee'],
    ],

    'Technical Committee' => [
        ['Shaikh Rijwan Salauddin', 'Technical Committee'],
        ['Sambhaji Mahajan', 'Technical Committee'],
        ['Mamta Budhpriyagautam Magare', 'Technical Committee'],
        ['Kirtane Asmita Rahul', 'Technical Committee'],
        ['Saing surdakar', 'Technical Committee'],
        ['Kanishk  Dalvi', 'Technical Committee'],
        ['Mohini Kamble', 'Technical Committee'],
    ],

    'Photography and Social Media Committee' => [
        ['Maroti Kautkar', 'Photography and Social Media Committee'],
        ['Sakshi Tangade', 'Photography and Social Media Committee'],
        ['Jeewak Khandare', 'Photography and Social Media Committee'],
        ['Dnyaneshwar Ghadge', 'Photography and Social Media Committee'],
        ['Jangid Nikita Rajendra', 'Photography and Social Media Committee'],
        ['Surbhi Shesware', 'Photography and Social Media Committee'],
        ['Mansi Yadav', 'Photography and Social Media Committee'],
        ['Prajkta Funde', 'Photography and Social Media Committee'],
    ],
    'Discipline Committee' => [
        ['Sidharth Bhalerao', 'Discipline Committee'],
        ['Tushar Suresh Khetre', 'Discipline Committee'],
        ['Kashyap Bhatkar', 'Discipline Committee'],
        ['Vinit Dinesh More', 'Discipline Committee'],
        ['Ashwini Suresh Javanjal', 'Discipline Committee'],
        ['Sayali Raut', 'Discipline Committee'],
        ['Sakshi Dilip Dabhade', 'Discipline Committee'],
        ['Aniket Devidas More', 'Discipline Committee'],
    ],

    'Report Committee' => [
        ['Vaishnavi Darade', 'Report Committee'],
        ['Namrata Sanjay Aher', 'Report Committee'],
        ['Shaikh Saubiya Khatgon', 'Report Committee'],
        ['Shradhha Balaji Chikane', 'Report Committee'],
        ['Rutuja Ramprasad Jaybhaye', 'Report Committee'],
        ['Dimpal Raju Kukade', 'Report Committee'],
    ],

    

    'Volunteers' => [
        ['Aditi Wayal', 'Volunteer'],
        ['Asmita Talekar', 'Volunteer'],
    ],
];

/*
|--------------------------------------------------------------------------
| Find member photos
|--------------------------------------------------------------------------
| Supported filenames:
| member01.jpg
| member01.jpeg
| member01.png
| member01.webp
|
| Folder:
| assets/images/members/
|--------------------------------------------------------------------------
*/

$extensions = ['jpg', 'jpeg', 'png', 'webp'];
$memberNumber = 1;
$totalMembers = 0;
$availablePhotos = 0;

foreach ($groups as $groupName => &$members) {
    foreach ($members as &$member) {
        $name = $member[0];
        $position = $member[1];

        $photoNumber = $memberNumber;
        $photo = '';

        foreach ($extensions as $ext) {
            $fileName = sprintf('member%02d.%s', $photoNumber, $ext);

            $fullPath = __DIR__
                . '/assets/images/members/'
                . $fileName;

            if (is_file($fullPath)) {
                $photo = 'assets/images/members/' . $fileName;
                $availablePhotos++;
                break;
            }
        }

        $member = [
            'name' => $name,
            'position' => $position,
            'photo' => $photo,
            'number' => $photoNumber
        ];

        $memberNumber++;
        $totalMembers++;
    }

    unset($member);
}
unset($members);

include __DIR__ . '/includes/header.php';
?>

<style>
/* Committee page styles */
.committee-page {
    background: #f5f8ff;
    min-height: 80vh;
    padding: 45px 20px 60px;
}

.committee-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}

.committee-hero {
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    color: #fff;
    text-align: center;
    padding: 42px 20px;
    border-radius: 22px;
    margin-bottom: 35px;
    box-shadow: 0 12px 30px rgba(37, 117, 252, 0.18);
}

.committee-hero h1 {
    font-size: clamp(28px, 4vw, 42px);
    font-weight: 800;
    margin: 0 0 12px;
}

.committee-hero p {
    margin: 0;
    font-size: 16px;
    line-height: 1.7;
    opacity: 0.95;
}

.committee-stats {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 15px;
    margin-top: 24px;
}

.committee-stat {
    background: rgba(255, 255, 255, 0.17);
    border: 1px solid rgba(255, 255, 255, 0.3);
    padding: 12px 22px;
    border-radius: 14px;
    min-width: 130px;
}

.committee-stat strong {
    display: block;
    font-size: 25px;
    line-height: 1.3;
}

.committee-stat span {
    font-size: 12px;
    opacity: 0.95;
}

.committee-section {
    margin-top: 38px;
}

.committee-section-heading {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid #dce8ff;
}

.committee-section-heading .heading-line {
    width: 5px;
    height: 32px;
    background: linear-gradient(180deg, #6a11cb, #2575fc);
    border-radius: 5px;
    flex-shrink: 0;
}

.committee-section-heading h2 {
    color: #183b72;
    font-size: clamp(20px, 3vw, 27px);
    font-weight: 800;
    margin: 0;
}

.committee-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 22px;
}

.member-card {
    background: #fff;
    border: 1px solid #e4ecfa;
    border-radius: 18px;
    overflow: hidden;
    text-align: center;
    box-shadow: 0 5px 18px rgba(35, 72, 130, 0.07);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.member-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 13px 28px rgba(35, 72, 130, 0.14);
}

.photo-area {
    height: 220px;
    background: linear-gradient(145deg, #eaf2ff, #dbe8ff);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
}

.member-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
    display: block;
}

.photo-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 5px;
    color: #5277b6;
    font-size: 13px;
    font-weight: 700;
    padding: 10px;
    box-sizing: border-box;
}

.photo-placeholder svg {
    width: 75px;
    height: 75px;
}

.photo-placeholder small {
    color: #6f83a5;
    font-size: 11px;
}

.member-info {
    padding: 17px 12px 20px;
}

.member-info h3 {
    font-size: 16px;
    line-height: 1.5;
    color: #183b72;
    margin: 0 0 9px;
    overflow-wrap: anywhere;
}

.member-role {
    display: inline-block;
    max-width: 100%;
    background: #edf4ff;
    color: #2463bf;
    border: 1px solid #dce9ff;
    border-radius: 20px;
    padding: 6px 11px;
    font-size: 11px;
    font-weight: 700;
    line-height: 1.5;
}

.photo-status {
    margin-top: 10px;
    color: #74839b;
    font-size: 11px;
}

@media (max-width: 1000px) {
    .committee-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

@media (max-width: 700px) {
    .committee-page {
        padding: 25px 12px 40px;
    }

    .committee-hero {
        padding: 30px 15px;
        border-radius: 17px;
    }

    .committee-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 13px;
    }

    .photo-area {
        height: 180px;
    }

    .member-info {
        padding: 13px 8px 16px;
    }

    .member-info h3 {
        font-size: 14px;
    }

    .member-role {
        font-size: 10px;
        padding: 5px 8px;
    }
}

@media (max-width: 380px) {
    .committee-grid {
        grid-template-columns: 1fr;
    }

    .photo-area {
        height: 240px;
    }
}
</style>

<main class="committee-page">
    <div class="committee-container">

        <section class="committee-hero">
            <h1>Our Committee</h1>
            <p>
                Meet the dedicated team behind FORCES.
                Together, we work to build a stronger and more active community.
            </p>

            <div class="committee-stats">
                <div class="committee-stat">
                    <strong><?= (int) $totalMembers ?></strong>
                    <span>Total Members</span>
                </div>

                <div class="committee-stat">
                    <strong><?= count($groups) ?></strong>
                    <span>Committees</span>
                </div>

                <div class="committee-stat">
                    <strong><?= (int) $availablePhotos ?></strong>
                    <span>Photos Found</span>
                </div>
            </div>
        </section>

        <?php foreach ($groups as $groupName => $members): ?>
            <section class="committee-section">

                <div class="committee-section-heading">
                    <div class="heading-line"></div>
                    <h2><?= e($groupName) ?></h2>
                </div>

                <div class="committee-grid">

                    <?php foreach ($members as $member): ?>

                        <article class="member-card">

                            <div class="photo-area">

                                <?php if ($member['photo'] !== ''): ?>

                                    <img
                                        class="member-photo"
                                        src="<?= e($member['photo']) ?>"
                                        alt="<?= e($member['name']) ?>"
                                        loading="lazy"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                    >

                                    <div
                                        class="photo-placeholder"
                                        style="display:none;"
                                    >
                                        <svg viewBox="0 0 100 100"
                                             aria-hidden="true">
                                            <circle cx="50" cy="32" r="19"
                                                    fill="#78a9ec"/>
                                            <path d="M14 94c2-24 16-37 36-37s34 13 36 37"
                                                  fill="#78a9ec"/>
                                        </svg>
                                        <span>Image could not load</span>
                                        <small>
                                            <?= e(sprintf(
                                                'member%02d',
                                                $member['number']
                                            )) ?>
                                        </small>
                                    </div>

                                <?php else: ?>

                                    <div class="photo-placeholder">
                                        <svg viewBox="0 0 100 100"
                                             aria-hidden="true">
                                            <circle cx="50" cy="32" r="19"
                                                    fill="#78a9ec"/>
                                            <path d="M14 94c2-24 16-37 36-37s34 13 36 37"
                                                  fill="#78a9ec"/>
                                        </svg>
                                        <span>Photo not found</span>
                                        <small>
                                            <?= e(sprintf(
                                                'member%02d',
                                                $member['number']
                                            )) ?>
                                        </small>
                                    </div>

                                <?php endif; ?>

                            </div>

                            <div class="member-info">
                                <h3><?= e($member['name']) ?></h3>

                                <span class="member-role">
                                    <?= e($member['position']) ?>
                                </span>

                                <?php if ($member['photo'] === ''): ?>
                                    <div class="photo-status">
                                        Add the matching photo to the images folder
                                    </div>
                                <?php endif; ?>
                            </div>

                        </article>

                    <?php endforeach; ?>

                </div>
            </section>
        <?php endforeach; ?>

    </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
