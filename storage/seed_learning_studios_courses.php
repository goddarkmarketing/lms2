<?php
declare(strict_types=1);

/**
 * Add กวดวิชา Learning Studios courses (ปกหนังสือ 2569) and retire the previous brand's courses.
 * Covers: assets/images/courses/ls/<slug>.jpg
 * Run: C:\xampp\php\php.exe storage/seed_learning_studios_courses.php
 */

require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/database.php';
require_once dirname(__DIR__) . '/includes/functions.php';

header('Content-Type: text/plain; charset=UTF-8');

$pdo = db();
$pdo->exec('SET NAMES utf8mb4');

$subjects = [
    'math' => 'คณิตศาสตร์',
    'sci' => 'วิทยาศาสตร์',
    'eng' => 'ภาษาอังกฤษ',
    'thai' => 'ภาษาไทย',
];
$prep = 'เตรียม GATE/GIFTED/EP/EPLUS';

$courses = [];
$sort = 100;

$add = static function (string $slug, string $title, string $subtitle, string $category, string $level, string $type, array $highlights, bool $featured = false) use (&$courses, &$sort): void {
    $sort += 10;
    $courses[] = [
        'slug' => $slug,
        'title' => $title,
        'subtitle' => $subtitle,
        'description' => $title . "\n\n" . $subtitle . "\n\nกวดวิชา Learning Studios — Learn Unlocked, Lead with Logic.\nสอบถามรอบเรียนและราคาได้ที่ Line @learn.studios หรือโทร 065-614-4988",
        'category' => $category,
        'level' => $level,
        'course_type' => $type,
        'highlights' => implode('|', $highlights),
        'image_url' => 'images/courses/ls/' . $slug . '.jpg',
        'is_featured' => $featured ? 1 : 0,
        'sort_order' => $sort,
    ];
};

$levelOf = static fn(int $n): string => $n <= 2 ? 'beginner' : ($n === 3 ? 'intermediate' : 'advanced');

foreach ([1, 2] as $n) {
    foreach (['thai', 'math', 'sci', 'eng'] as $s) {
        $add("l{$n}-core-{$s}", "CORE CONCEPT {$subjects[$s]} LEVEL {$n}", "สรุปเนื้อหาเข้มข้น GATE/GIFTED/EP/EPLUS · Hybrid (Onsite + ZOOM)", 'hsk', $levelOf($n), 'hybrid', ["LEVEL {$n}", 'สรุปเนื้อหาเข้มข้น', 'Onsite + Online'], $n === 1);
    }
    foreach (['thai', 'math', 'sci', 'eng'] as $s) {
        $add("l{$n}-prep-{$s}", "{$prep} {$subjects[$s]} LEVEL {$n}", "เตรียมสอบเข้า ม.1 GATE/GIFTED/EP/EPLUS · Hybrid (Onsite + ZOOM)", 'exam_prep', $levelOf($n), 'hybrid', ["LEVEL {$n}", 'เตรียมสอบเข้า ม.1', 'Onsite + Online'], $n === 1);
    }
}

$examEp = ['เจาะสนามสอบ EP/EPLUS 3 วิชา (คณิต-วิทย์-อังกฤษ)', 'เจาะแนวข้อสอบ EP/EPLUS'];
$examGate = ['เจาะสนามสอบ GATE/GIFTED 4 วิชา (คณิต-วิทย์-อังกฤษ-ไทย)', 'เจาะแนวข้อสอบ GATE/GIFTED'];
$examPatumwan = ['เจาะสนามสอบ ปทุมวัน 4 วิชา (คณิต-วิทย์-ไทย-สังคม)', 'เจาะแนวข้อสอบโรงเรียนปทุมวันฯ'];
$drill = static fn(int $grade): array => ["ตะลุยโจทย์แข่งขัน คณิต-วิทย์ ป.{$grade}", "ฝึกโจทย์แข่งขันคณิตศาสตร์และวิทยาศาสตร์ ชั้นประถมศึกษาปีที่ {$grade}"];
$fiveSub = static fn(int $grade): array => ["รวม 5 วิชา ป.{$grade}", "คณิต วิทย์ ไทย อังกฤษ สังคม ชั้นประถมศึกษาปีที่ {$grade}"];

$levelSets = [
    3 => [
        ['core', 'math'], ['core', 'sci'], ['prep', 'thai'], ['prep', 'math'], ['prep', 'sci'],
        ['exam', 'ep', $examEp], ['exam', 'gate', $examGate], ['exam', 'patumwan', $examPatumwan],
        ['drill', 3], ['drill', 4], ['5sub', 3], ['5sub', 4],
    ],
    4 => [
        ['core', 'math'], ['core', 'sci'], ['prep', 'thai'], ['prep', 'math'], ['prep', 'sci'],
        ['exam', 'gate', $examGate], ['drill', 3], ['drill', 4], ['5sub', 3], ['5sub', 4],
    ],
    5 => [
        ['core', 'math'], ['core', 'sci'], ['prep', 'thai'], ['prep', 'math'], ['prep', 'sci'],
        ['exam', 'gate', $examGate], ['drill', 3], ['drill', 4], ['5sub', 3], ['5sub', 4],
    ],
];

foreach ($levelSets as $n => $items) {
    $lv = $levelOf($n);
    foreach ($items as $item) {
        [$kind, $key] = $item;
        $tags = ["LEVEL {$n}", 'Onsite + Online'];
        switch ($kind) {
            case 'core':
                $add("l{$n}-core-{$key}", "CORE CONCEPT {$subjects[$key]} LEVEL {$n}", 'สรุปเนื้อหาเข้มข้น GATE/GIFTED/EP/EPLUS · Hybrid (Onsite + ZOOM)', 'hsk', $lv, 'hybrid', array_merge($tags, ['สรุปเนื้อหาเข้มข้น']));
                break;
            case 'prep':
                $add("l{$n}-prep-{$key}", "{$prep} {$subjects[$key]} LEVEL {$n}", 'เตรียมสอบเข้า ม.1 GATE/GIFTED/EP/EPLUS · Hybrid (Onsite + ZOOM)', 'exam_prep', $lv, 'hybrid', array_merge($tags, ['เตรียมสอบเข้า ม.1']));
                break;
            case 'exam':
                [$t, $sub] = $item[2];
                $add("l{$n}-exam-{$key}", "{$t} LEVEL {$n}", "{$sub} · Hybrid (Onsite + ZOOM)", 'exam_prep', $lv, 'hybrid', array_merge($tags, ['เจาะสนามสอบ']));
                break;
            case 'drill':
                [$t, $sub] = $drill($key);
                $add("l{$n}-drill-p{$key}", "{$t} LEVEL {$n}", "{$sub} · Hybrid (Onsite + ZOOM)", 'exam_prep', $lv, 'hybrid', array_merge($tags, ["ป.{$key}"]));
                break;
            case '5sub':
                [$t, $sub] = $fiveSub($key);
                $add("l{$n}-5sub-p{$key}", "{$t} LEVEL {$n}", "{$sub} · Hybrid (Onsite + ZOOM)", 'foundation', $lv, 'hybrid', array_merge($tags, ["ป.{$key}"]));
                break;
        }
    }
}

foreach ([1, 2] as $book) {
    $on = "ONLINE {$book}";
    $lv = $book === 1 ? 'beginner' : 'intermediate';
    $tags = [$on, 'เรียนออนไลน์', "เล่ม {$book}"];
    if ($book === 1) {
        $add('on1-prep-eng-1', "{$prep} ภาษาอังกฤษ 1", 'คอร์สออนไลน์ เตรียมสอบเข้า ม.1 GATE/GIFTED/EP/EPLUS', 'exam_prep', $lv, 'recorded', $tags);
    }
    $add("on{$book}-algebra-{$book}", "{$prep} พีชคณิต {$book}", 'คอร์สออนไลน์ เตรียมสอบเข้า ม.1 GATE/GIFTED/EP/EPLUS', 'exam_prep', $lv, 'recorded', $tags);
    $add("on{$book}-geometry-{$book}", "{$prep} เรขาคณิต {$book}", 'คอร์สออนไลน์ เตรียมสอบเข้า ม.1 GATE/GIFTED/EP/EPLUS', 'exam_prep', $lv, 'recorded', $tags);
    foreach (['math', 'sci'] as $s) {
        $add("on{$book}-drill-ep-{$s}-{$book}", "ตะลุยโจทย์ EP/EPLUS {$subjects[$s]} {$book}", 'คอร์สออนไลน์ ตะลุยโจทย์แนวข้อสอบ EP/EPLUS', 'exam_prep', $lv, 'recorded', $tags);
    }
    foreach (['math', 'sci'] as $s) {
        $add("on{$book}-drill-gate-{$s}-{$book}", "ตะลุยโจทย์ GATE/GIFTED {$subjects[$s]} {$book}", 'คอร์สออนไลน์ ตะลุยโจทย์แนวข้อสอบ GATE/GIFTED', 'exam_prep', $lv, 'recorded', $tags);
    }
    foreach ([['p3', 3, 'math'], ['p3', 3, 'sci'], ['p4', 4, 'math'], ['p4', 4, 'sci'], ['p4', 4, 'eng']] as [$code, $grade, $s]) {
        $add("on{$book}-{$code}-{$s}-{$book}", "{$subjects[$s]} ป.{$grade} เล่ม {$book}", "คอร์สออนไลน์ {$subjects[$s]} ชั้นประถมศึกษาปีที่ {$grade}", 'foundation', $lv, 'recorded', $tags);
    }
    if ($book === 2) {
        $add('on2-physics', 'ฟิสิกส์ (Physics)', 'คอร์สออนไลน์ ฟิสิกส์สำหรับสอบแข่งขันและสอบเข้า ม.1', 'hsk', $lv, 'recorded', [$on, 'เรียนออนไลน์', 'ฟิสิกส์']);
        $add('on2-earth-sci', 'วิทย์โลก (Earth & Astronomy)', 'คอร์สออนไลน์ โลกและดาราศาสตร์สำหรับสอบแข่งขันและสอบเข้า ม.1', 'hsk', $lv, 'recorded', [$on, 'เรียนออนไลน์', 'โลกและดาราศาสตร์']);
    }
}

foreach ([
    ['sci-map-bio', 'SCI-MAP: BIO-MAP สรุปเนื้อหาชีววิทยา', 'ชีววิทยา'],
    ['sci-map-chem', 'SCI-MAP: CHEM-MAP สรุปเนื้อหาเคมี', 'เคมี'],
    ['sci-map-phy', 'SCI-MAP: PHY-MAP สรุปเนื้อหาฟิสิกส์', 'ฟิสิกส์'],
    ['sci-map-earth-astro', 'SCI-MAP: EARTH & ASTRO MAP สรุปเนื้อหาโลกและดาราศาสตร์', 'โลกและดาราศาสตร์'],
] as [$slug, $title, $topic]) {
    $add($slug, $title, 'สรุปครบ จบในเล่มเดียว สำหรับสอบแข่งขันและสอบเข้า ม.1', 'hsk', 'intermediate', 'recorded', ['SCI-MAP SERIES', "สรุป{$topic}", 'สอบแข่งขัน / สอบเข้า ม.1']);
}

$missing = array_filter($courses, static fn($c) => !is_file(BASE_PATH . '/assets/' . $c['image_url']));
if ($missing) {
    fwrite(STDERR, "Missing covers:\n" . implode("\n", array_column($missing, 'slug')) . "\n");
    exit(1);
}

$retired = $pdo->exec("UPDATE courses SET is_active = 0, is_featured = 0 WHERE slug IN ('m1-intensive-live','m1-intensive-online','m4-intensive-live','m4-intensive-online','alevel-social-live','alevel-social-online','foundation-primary','foundation-lower-secondary','foundation-upper-secondary')");
echo "retired previous-brand courses: {$retired}\n";

$upsert = $pdo->prepare('
    INSERT INTO courses (slug, title, subtitle, description, category, level, price, duration_hours, lesson_count, image_url, highlights, is_featured, is_active, course_type, sort_order)
    VALUES (:slug, :title, :subtitle, :description, :category, :level, 0, 0, 0, :image_url, :highlights, :is_featured, 1, :course_type, :sort_order)
    ON DUPLICATE KEY UPDATE
        title = VALUES(title), subtitle = VALUES(subtitle), description = VALUES(description),
        category = VALUES(category), level = VALUES(level), image_url = VALUES(image_url),
        highlights = VALUES(highlights), is_featured = VALUES(is_featured), is_active = 1,
        course_type = VALUES(course_type), sort_order = VALUES(sort_order)
');

foreach ($courses as $course) {
    $upsert->execute($course);
}
echo 'upserted courses: ' . count($courses) . "\n";
