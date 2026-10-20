<?php
declare(strict_types=1);

/**
 * Rebrand site content to กวดวิชา Learning Studios from client brief.
 * Run: C:\xampp\php\php.exe storage/seed_learning_studios.php
 */

require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/database.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/site_content.php';

header('Content-Type: text/plain; charset=UTF-8');

db()->exec('SET NAMES utf8mb4');

echo "=== กวดวิชา Learning Studios rebrand ===\n";

function rebrandText(string $value): string
{
    $value = strtr($value, [
        'กวดวิชาเดอะลีโอน่า' => 'กวดวิชา Learning Studios',
        'เดอะลีโอน่า' => 'Learning Studios',
        'THE LEONA TUTORS' => 'Learning Studios',
        'ครูบอล' => 'คุณครู',
        '082-8672627' => '065-614-4988',
    ]);
    $value = (string) preg_replace('/(?<=[\x{0E00}-\x{0E7F}])Learning Studios/u', ' Learning Studios', $value);
    return (string) preg_replace('/Learning Studios(?=[\x{0E00}-\x{0E7F}])/u', 'Learning Studios ', $value);
}

function rebrandArray(array $data): array
{
    array_walk_recursive($data, static function (&$v): void {
        if (is_string($v)) {
            $v = rebrandText($v);
        }
    });
    return $data;
}

$tagline = 'Learn Unlocked, Lead with Logic. เรียนเป็นระบบ ครบทุกวิชา สอบแข่งขันและสอบเข้า ม.1';

$settings = [
    'site_title' => 'กวดวิชา Learning Studios',
    'site_tagline' => $tagline,
    'hero_title' => 'Learning Studios',
    'hero_subtitle' => 'Learn Unlocked, Lead with Logic.',
    'phone' => '065-614-4988',
    'line_id' => '@learn.studios',
    'facebook_url' => 'https://www.facebook.com/search/top?q=' . rawurlencode('กวดวิชา Learning Studios'),
    'email_from_name' => 'กวดวิชา Learning Studios',
    'contact_email' => '',
    'instructor_name' => 'ครูแพรว',
    'instructor_role' => 'Co-founder กวดวิชา Learning Studios',
    'instructor_tagline' => 'ครูผู้สอนวิชาคณิตศาสตร์ · เตรียมสอบเข้า ม.1 และสอบแข่งขัน',
    'instructor_bio' => "ครูแพรว Co-founder กวดวิชา Learning Studios ครูผู้สอนวิชาคณิตศาสตร์\nกวดวิชาสำหรับเตรียมสอบเข้า ม.1 โรงเรียนชั้นนำ และสอบแข่งขัน",
    'instructor_quote' => 'Learn Unlocked, Lead with Logic.',
    'instructor_credentials' => 'Co-founder กวดวิชา Learning Studios|ครูผู้สอนวิชาคณิตศาสตร์|เตรียมสอบเข้า ม.1 โรงเรียนชั้นนำ|ติวสอบแข่งขัน',
    'instructor_highlights' => 'เรียนเป็นระบบ ครบทุกวิชา|เรียน Hybrid: Onsite + Online สดผ่าน ZOOM พร้อมกัน|ดูวิดีโอย้อนหลังผ่านกลุ่มปิด Facebook|หนังสือเรียนฟรี 1 เล่มต่อคอร์ส',
    'terms_html' => defaultTermsHtml(),
    'privacy_policy_html' => rebrandText(getSetting('privacy_policy_html', '')),
];

foreach ($settings as $key => $value) {
    saveSetting($key, $value);
    echo "setting: {$key}\n";
}

saveJsonSetting('content_faq_json', defaultFaqItems());
echo "content_faq_json replaced (" . count(defaultFaqItems()) . " items)\n";

$homeDefaults = defaultHomepageContent();
$home = rebrandArray(getJsonSetting('content_homepage_json', $homeDefaults));
$home['why'] = $homeDefaults['why'];
$home['instructor'] = $homeDefaults['instructor'];
$home['steps']['subtitle'] = $homeDefaults['steps']['subtitle'];
$home['reviews']['subtitle'] = $homeDefaults['reviews']['subtitle'];
saveJsonSetting('content_homepage_json', $home);
echo "content_homepage_json updated\n";

$contact = rebrandArray(getJsonSetting('content_contact_json', defaultContactContent()));
$contact['facebook_label'] = 'กวดวิชา Learning Studios';
$contact['intro_eyebrow'] = 'Learning Studios';
saveJsonSetting('content_contact_json', $contact);
echo "content_contact_json updated\n";

$footer = rebrandArray(getJsonSetting('content_footer_json', defaultFooterContent()));
$footer['copyright'] = 'กวดวิชา Learning Studios. All Rights Reserved.';
saveJsonSetting('content_footer_json', $footer);
echo "content_footer_json updated\n";

$faqPage = rebrandArray(getJsonSetting('content_faq_page_json', defaultFaqPageContent()));
$faqPage['cta_text'] = 'ทักแอดมินทาง Line @learn.studios หรือโทร 065-614-4988 เราพร้อมให้คำปรึกษาเรื่องคอร์สและการสมัครเรียน';
saveJsonSetting('content_faq_page_json', $faqPage);
echo "content_faq_page_json updated\n";

resetSettingsCache();
echo "=== DONE ===\n";
