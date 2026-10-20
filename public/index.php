<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/cart.php';
require_once dirname(__DIR__) . '/includes/homepage.php';
require_once dirname(__DIR__) . '/includes/instructor.php';
require_once dirname(__DIR__) . '/includes/site_content.php';

$courses = [];
$cartSuccess = flash('cart_success');
$newsletterSuccess = flash('newsletter_success');
$newsletterError = flash('newsletter_error');

try {
    $courses = getCourses();
} catch (Throwable $e) {
    $courses = [];
}

$featuredList = array_values(array_filter($courses, fn($c) => !empty($c['is_featured'])));
$otherList = array_values(array_filter($courses, fn($c) => empty($c['is_featured'])));
$homeCourses = array_slice(array_merge($featuredList, $otherList), 0, 8);
$homeStats = getHomepageStats();
$homeContent = getHomepageContent();
$faqItems = getHomepageFaqItems();
$reviews = getHomeReviews();
$lineUrl = lineContactUrl();
$lineId = getSetting('line_id', '@learn.studios');
$trustItems = $homeContent['trust'] ?? [];
$resolveTrustValue = static function (array $item) use ($homeStats): string {
    return match ($item['mode'] ?? 'manual') {
        'courses' => (string) (int) ($homeStats['courses'] ?? 0),
        'lessons' => (int) ($homeStats['lessons'] ?? 0) . '+',
        default => (string) ($item['value'] ?? ''),
    };
};
$coursesUrl = APP_URL . '/public/courses.php';
$registerUrl = APP_URL . '/public/register.php';
$coverUrl = static fn(string $slug): string => asset('images/courses/ls/' . $slug . '.jpg');

$heroSlides = [
    [
        'theme' => 'brand',
        'eyebrow' => 'กวดวิชา Learning Studios',
        'title' => 'Learn Unlocked, <br>Lead with Logic.',
        'text' => 'เรียนเป็นระบบ ครบทุกวิชา สอบแข่งขันและสอบเข้า ม.1',
        'cta' => ['label' => 'ดูคอร์สทั้งหมด', 'href' => $coursesUrl],
        'cta2' => ['label' => 'สมัครสมาชิก', 'href' => $registerUrl],
        'logo' => true,
        'covers' => [],
    ],
    [
        'theme' => 'blue',
        'eyebrow' => 'เตรียมสอบเข้า ม.1',
        'title' => 'GATE · GIFTED <br>EP · EPLUS',
        'text' => 'ติวเข้มโรงเรียนชั้นนำ ครบ คณิต · วิทย์ · อังกฤษ · ไทย ตั้งแต่ LEVEL 1–5',
        'cta' => ['label' => 'ดูคอร์สติวสอบ', 'href' => $coursesUrl . '?q=GATE'],
        'cta2' => null,
        'logo' => false,
        'covers' => ['l1-prep-sci', 'l3-exam-gate', 'l1-prep-math'],
    ],
    [
        'theme' => 'red',
        'eyebrow' => 'เรียน Hybrid · Online',
        'title' => 'Onsite + ZOOM สด <br>พร้อมกันแบบ Real-time',
        'text' => 'คอร์สออนไลน์เรียนได้ทุกที่ · เรียนครั้งแรกลด 5% · ลูกค้าเก่าลด 10%',
        'cta' => ['label' => 'ดูคอร์สออนไลน์', 'href' => $coursesUrl . '?type=recorded'],
        'cta2' => ['label' => 'สอบถาม Line', 'href' => $lineUrl],
        'logo' => false,
        'covers' => ['on1-algebra-1', 'sci-map-phy', 'on2-physics'],
    ],
];

$subjects = [
    ['icon' => 'calculator', 'title' => 'คณิตศาสตร์'],
    ['icon' => 'flask-conical', 'title' => 'วิทยาศาสตร์'],
    ['icon' => 'languages', 'title' => 'ภาษาอังกฤษ'],
    ['icon' => 'book-open', 'title' => 'ภาษาไทย'],
    ['icon' => 'landmark', 'title' => 'สังคมศึกษา'],
];

$tutors = [
    ['name' => 'ครูแพรว', 'role' => 'Co-founder', 'subject' => 'คณิตศาสตร์'],
    ['name' => 'ครูนันต์', 'role' => 'Co-founder', 'subject' => 'วิทยาศาสตร์'],
    ['name' => 'ครูไอซ์', 'role' => 'ครูผู้สอน', 'subject' => 'ภาษาอังกฤษ'],
    ['name' => 'ครูโอปอ', 'role' => 'ครูผู้สอน', 'subject' => 'ภาษาไทยและสังคม'],
    ['name' => 'ครูอังฟิลด์', 'role' => 'ครูผู้สอน', 'subject' => 'คณิตศาสตร์'],
    ['name' => 'ครูแอน', 'role' => 'ครูผู้สอน', 'subject' => 'วิทยาศาสตร์'],
    ['name' => 'ครูปาท่องโก๋', 'role' => 'ครูผู้สอน', 'subject' => 'ภาษาอังกฤษ'],
    ['name' => 'ครูแพม', 'role' => 'ครูผู้สอน', 'subject' => 'ภาษาอังกฤษ'],
];
?>

<?php if ($cartSuccess): ?>
<div class="container" style="padding-top:1rem"><div class="alert alert-success"><?= e($cartSuccess) ?></div></div>
<?php endif; ?>

<section class="hero hero-slider ls-hero" id="heroSlider" aria-roledescription="carousel" aria-label="แบนเนอร์หลัก">
    <div class="hero-slider-viewport">
        <div class="hero-slider-track">
            <?php foreach ($heroSlides as $i => $slide): ?>
            <div class="hero-slide ls-slide ls-slide--<?= e($slide['theme']) ?><?= $i === 0 ? ' is-active' : '' ?>">
                <span class="ls-slide-brick ls-slide-brick--a" aria-hidden="true"></span>
                <span class="ls-slide-brick ls-slide-brick--b" aria-hidden="true"></span>
                <span class="ls-slide-brick ls-slide-brick--c" aria-hidden="true"></span>
                <div class="container ls-slide-inner">
                    <div class="ls-slide-copy">
                        <p class="ls-slide-eyebrow"><?= e($slide['eyebrow']) ?></p>
                        <<?= $i === 0 ? 'h1' : 'h2' ?> class="ls-slide-title"><?= $slide['title'] ?></<?= $i === 0 ? 'h1' : 'h2' ?>>
                        <p class="ls-slide-text"><?= e($slide['text']) ?></p>
                        <div class="ls-slide-actions">
                            <a href="<?= e($slide['cta']['href']) ?>" class="btn ls-slide-btn"><?= e($slide['cta']['label']) ?></a>
                            <?php if ($slide['cta2']): ?>
                            <a href="<?= e($slide['cta2']['href']) ?>" class="btn ls-slide-btn ls-slide-btn--ghost"<?= str_starts_with($slide['cta2']['href'], 'http') ? ' target="_blank" rel="noopener"' : '' ?>><?= e($slide['cta2']['label']) ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="ls-slide-visual" aria-hidden="true">
                        <?php if ($slide['logo']): ?>
                        <img class="ls-slide-logo" src="<?= e(asset('images/learning-studios/logo-hero.png')) ?>" alt="" width="720" height="317" <?= $i === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?> decoding="async">
                        <?php else: ?>
                        <div class="ls-slide-covers">
                            <?php foreach ($slide['covers'] as $slug): ?>
                            <img src="<?= e($coverUrl($slug)) ?>" alt="" width="600" height="849" loading="lazy" decoding="async">
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <button type="button" class="hero-slider-btn hero-slider-prev" aria-label="สไลด์ก่อนหน้า">
        <?= lucide_icon('chevron-left', ['size' => 24, 'stroke' => '2.5']) ?>
    </button>
    <button type="button" class="hero-slider-btn hero-slider-next" aria-label="สไลด์ถัดไป">
        <?= lucide_icon('chevron-right', ['size' => 24, 'stroke' => '2.5']) ?>
    </button>
    <div class="hero-slider-dots" role="tablist" aria-label="เลือกสไลด์"></div>
</section>

<section class="trust-bar" aria-label="จุดเด่นกวดวิชา Learning Studios">
    <div class="container">
        <ul class="trust-bar-grid">
            <?php foreach ($trustItems as $trustItem): ?>
            <li>
                <span class="trust-bar-icon" aria-hidden="true">
                    <?= trustBarIcon($trustItem) ?>
                </span>
                <strong><?= e($resolveTrustValue($trustItem)) ?></strong>
                <span><?= e($trustItem['label'] ?? '') ?></span>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<section class="section section-alt why-wenxin-section" id="about">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow"><?= e($homeContent['why']['eyebrow'] ?? '') ?></span>
            <h2><?= e($homeContent['why']['title'] ?? '') ?></h2>
            <p><?= e($homeContent['why']['subtitle'] ?? '') ?></p>
        </div>
        <div class="why-wenxin-grid">
            <?php foreach (($homeContent['why']['cards'] ?? []) as $i => $whyCard): ?>
            <article class="why-card">
                <div class="why-card-icon" aria-hidden="true">
                    <?= whyCardIcon($i) ?>
                </div>
                <h3><?= e($whyCard['title'] ?? '') ?></h3>
                <p><?= e($whyCard['text'] ?? '') ?></p>
            </article>
            <?php endforeach; ?>
        </div>
        <ul class="ls-subject-chips" id="subjects" aria-label="วิชาที่เปิดสอน">
            <?php foreach ($subjects as $subject): ?>
            <li>
                <span aria-hidden="true"><?= lucide_icon($subject['icon'], ['size' => 18, 'stroke' => '2']) ?></span>
                <?= e($subject['title']) ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<section class="section home-courses-section" id="courses">
    <div class="container">
        <div class="section-header-row">
            <div class="section-header section-header-left">
                <h2><?= e($homeContent['courses']['title'] ?? 'คอร์สเรียนยอดนิยม') ?></h2>
                <p><?= e($homeContent['courses']['subtitle'] ?? '') ?></p>
            </div>
            <a href="<?= e($coursesUrl) ?>" class="section-link-more">ดูคอร์สทั้งหมด →</a>
        </div>
        <?php if ($homeCourses): ?>
        <div class="courses-grid courses-home-grid">
            <?php foreach ($homeCourses as $course): ?>
                <?php include dirname(__DIR__) . '/includes/course_card.php'; ?>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p class="lesson-empty">กำลังเตรียมคอร์ส... กรุณาลองใหม่ภายหลัง</p>
        <?php endif; ?>
    </div>
</section>

<section class="section section-alt home-instructor-section" id="tutors" aria-labelledby="tutors-heading">
    <div class="container">
        <div class="section-header">
            <h2 id="tutors-heading"><?= e($homeContent['instructor']['title'] ?? 'พบกับครูผู้สอน') ?></h2>
            <p>ทีมครูกวดวิชา Learning Studios ดูแลนักเรียนอย่างใกล้ชิดทุกวิชา</p>
        </div>
        <div class="ls-tutor-grid">
            <?php foreach ($tutors as $t => $tutor): ?>
            <article class="ls-tutor-card">
                <span class="ls-tutor-avatar ls-tutor-avatar--<?= $t % 3 ?>" aria-hidden="true"><?= e(mb_substr(preg_replace('/^ครู[เแโใไ]?/u', '', $tutor['name']), 0, 1)) ?></span>
                <h3><?= e($tutor['name']) ?></h3>
                <p class="ls-tutor-subject"><?= e($tutor['subject']) ?></p>
                <?php if ($tutor['role'] === 'Co-founder'): ?>
                <span class="ls-tutor-badge">Co-founder</span>
                <?php endif; ?>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section home-reviews-section" id="reviews" aria-labelledby="reviews-heading">
    <div class="container">
        <div class="section-header">
            <h2 id="reviews-heading"><?= e($homeContent['reviews']['title'] ?? '') ?></h2>
            <p><?= e($homeContent['reviews']['subtitle'] ?? '') ?></p>
        </div>
        <?php
        $renderReviewCard = static function (array $review): void {
            ?>
            <article class="review-card review-card-grid">
                <div class="review-stars" aria-label="5 จาก 5 ดาว">
                    <?php for ($s = 0; $s < 5; $s++): ?>
                    <?= lucide_icon('star', ['size' => 16, 'class' => 'review-star']) ?>
                    <?php endfor; ?>
                </div>
                <blockquote class="review-quote">&ldquo;<?= e($review['quote'] ?? '') ?>&rdquo;</blockquote>
                <footer class="review-author">
                    <span class="review-avatar" style="--avatar-hue: <?= (int) ($review['hue'] ?? 220) ?>"><?= e($review['initial'] ?? '') ?></span>
                    <div class="review-author-meta">
                        <strong><?= e($review['name'] ?? '') ?></strong>
                        <span><?= e($review['course'] ?? '') ?></span>
                    </div>
                </footer>
            </article>
            <?php
        };
        ?>
        <div class="reviews-grid reviews-grid--desktop">
            <?php foreach (array_slice($reviews, 0, 4) as $review): ?>
                <?php $renderReviewCard($review); ?>
            <?php endforeach; ?>
        </div>
        <div class="reviews-slider reviews-slider--mobile" id="reviewsSlider">
            <button type="button" class="reviews-slider-btn reviews-slider-prev" aria-label="รีวิวก่อนหน้า">
                <?= lucide_icon('chevron-left', ['size' => 24, 'stroke' => '2.5']) ?>
            </button>
            <div class="reviews-slider-viewport">
                <div class="reviews-slider-track">
                    <?php foreach ($reviews as $review): ?>
                        <?php $renderReviewCard($review); ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <button type="button" class="reviews-slider-btn reviews-slider-next" aria-label="รีวิวถัดไป">
                <?= lucide_icon('chevron-right', ['size' => 24, 'stroke' => '2.5']) ?>
            </button>
            <div class="reviews-slider-dots" role="tablist" aria-label="เลือกหน้ารีวิว"></div>
        </div>
    </div>
</section>

<section class="section section-alt home-steps-section">
    <div class="container">
        <div class="section-header">
            <h2><?= e($homeContent['steps']['title'] ?? '') ?></h2>
            <p><?= e($homeContent['steps']['subtitle'] ?? '') ?></p>
        </div>
        <div class="home-steps-flow">
            <?php foreach (($homeContent['steps']['items'] ?? []) as $stepIndex => $step): ?>
            <?php if ($stepIndex > 0): ?><div class="home-step-connector" aria-hidden="true"></div><?php endif; ?>
            <div class="home-step-node">
                <div class="home-step-icon" aria-hidden="true">
                    <?= homeStepIcon((int) $stepIndex) ?>
                </div>
                <h3><?= e($step['title'] ?? '') ?></h3>
                <p><?= e($step['text'] ?? '') ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section home-faq-section" id="faq">
    <div class="container">
        <div class="section-header-row">
            <div class="section-header section-header-left">
                <h2><?= e($homeContent['faq']['title'] ?? '') ?></h2>
                <p><?= e($homeContent['faq']['subtitle'] ?? '') ?></p>
            </div>
            <a href="<?= APP_URL ?>/public/faq.php" class="section-link-more">ดูทั้งหมด →</a>
        </div>
        <?php include dirname(__DIR__) . '/includes/faq_panel.php'; ?>
    </div>
</section>

<section class="home-newsletter" id="newsletter">
    <div class="container home-newsletter-inner">
        <div class="home-newsletter-info">
            <div class="home-newsletter-icon" aria-hidden="true">
                <?= lucide_icon('mail', ['size' => 48, 'stroke' => '1.75']) ?>
            </div>
            <div class="home-newsletter-copy">
                <h2><?= e($homeContent['newsletter']['title'] ?? '') ?></h2>
                <p><?= e($homeContent['newsletter']['subtitle'] ?? '') ?></p>
            </div>
        </div>
        <div class="home-newsletter-form-wrap">
            <?php if ($newsletterSuccess): ?>
            <p class="home-newsletter-feedback home-newsletter-feedback-success" role="status"><?= e($newsletterSuccess) ?></p>
            <?php elseif ($newsletterError): ?>
            <p class="home-newsletter-feedback home-newsletter-feedback-error" role="alert"><?= e($newsletterError) ?></p>
            <?php endif; ?>
            <form class="home-newsletter-form" method="post" action="<?= APP_URL ?>/public/newsletter-subscribe.php">
                <?= csrfField() ?>
                <div class="home-newsletter-field">
                    <label class="visually-hidden" for="newsletter-email">อีเมลของคุณ</label>
                    <input type="email" id="newsletter-email" name="email" placeholder="<?= e($homeContent['newsletter']['placeholder'] ?? 'อีเมลของคุณ') ?>" required autocomplete="email">
                    <button type="submit"><?= e($homeContent['newsletter']['button'] ?? 'สมัครรับข่าวสาร') ?></button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
