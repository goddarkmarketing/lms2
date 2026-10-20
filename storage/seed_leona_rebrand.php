<?php
declare(strict_types=1);

/**
 * Rebrand LMS to กวดวิชาเดอะลีโอน่า (THE LEONA TUTORS) from client brief.
 * Run: C:\xampp\php\php.exe storage/seed_leona_rebrand.php
 */

require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/database.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/site_content.php';

header('Content-Type: text/plain; charset=UTF-8');

$pdo = db();
$pdo->exec("SET NAMES utf8mb4");

echo "=== THE LEONA TUTORS rebrand ===\n";

$settings = [
    'site_title' => 'กวดวิชาเดอะลีโอน่า',
    'site_tagline' => 'ติวสังคมศึกษา ศาสนา หน้าที่พลเมือง เศรษฐศาสตร์ ภูมิศาสตร์ ประวัติศาสตร์ และกฎหมาย — เน้นความเข้าใจควบคู่ทำข้อสอบ',
    'hero_title' => 'THE LEONA TUTORS',
    'hero_subtitle' => 'กวดวิชาเดอะลีโอน่า โดยครูบอล',
    'phone' => '082-8672627',
    'line_id' => '',
    'facebook_url' => 'https://www.facebook.com/search/top?q=%E0%B8%84%E0%B8%A3%E0%B8%B9%E0%B8%9A%E0%B8%AD%E0%B8%A5%20%E0%B8%AA%E0%B8%AD%E0%B8%99%E0%B8%AA%E0%B8%B1%E0%B8%87%E0%B8%84%E0%B8%A1',
    'email_from_name' => 'กวดวิชาเดอะลีโอน่า',
    'email_admin' => 'admin@theleonatutors.com',
    'contact_email' => 'admin@theleonatutors.com',
    'bank_name' => 'กรุงไทย',
    'bank_account_name' => 'นางสาวสินีนาฎ สุริยวาลย์',
    'bank_account_number' => '',
    'payment_note' => 'ชำระได้ด้วยโอนบัญชีกรุงไทย / สแกน QR Code หรือสอบถามชำระบัตรเครดิต หลังชำระกรุณาแจ้งหลักฐานเพื่อเปิดสิทธิ์เรียน (อายุการเข้าถึงคอร์ส 1 ปี)',
    'promptpay_enabled' => '1',
    'promptpay_id' => '0828672627',
    'promptpay_id_type' => 'phone',
    'instructor_name' => 'ครูบอล',
    'instructor_role' => 'ผู้สอนหลัก · กวดวิชาเดอะลีโอน่า',
    'instructor_tagline' => 'ติวสังคมศึกษาและประวัติศาสตร์ · เตรียมสอบเข้า ม.1 ม.4 และ A-Level',
    'instructor_bio' => 'ครูบอลผู้ก่อตั้งกวดวิชาเดอะลีโอน่า (THE LEONA TUTORS) สอนวิชาสังคมศึกษา ศาสนา หน้าที่พลเมือง เศรษฐศาสตร์ ภูมิศาสตร์ ประวัติศาสตร์ และกฎหมาย เน้นความเข้าใจควบคู่กับการทำข้อสอบ เหมาะกับนักเรียนประถมตอนปลายถึงมัธยมปลาย',
    'instructor_quote' => 'เข้าใจเนื้อหา วิเคราะห์โจทย์ แล้วไปสอบได้จริง',
    'instructor_credentials' => 'สอนวิชาสังคมศึกษาและประวัติศาสตร์|เน้นเตรียมสอบเข้า ม.1 / ม.4 และ A-Level|มีทั้งสอนสดและเรียนออนไลน์|เอกสารประกอบ + แบบฝึกหัดครบ',
    'instructor_highlights' => 'เนื้อหาเริ่มจากพื้นฐานไปสู่โจทย์ระดับสูง|เทคนิควิเคราะห์โจทย์ จับประเด็น ตัดตัวเลือก|มีเอกสารสรุปและข้อสอบฝึกทำ|เข้าถึงคอร์สได้ 1 ปีหลังสมัคร',
    'instructor_stat_students' => '1,000+',
    'instructor_stat_satisfaction' => '95%',
    'terms_html' => '<p><strong>นโยบายการเรียน — กวดวิชาเดอะลีโอน่า</strong></p><ul><li>อายุการสมัครลงเรียน <strong>1 ปี</strong> สามารถเข้ามาดูเนื้อหาได้ตลอดในช่วงเวลานี้</li><li>รูปแบบเรียนขึ้นกับคอร์ส: สอนสด และ/หรือ ออนไลน์ / วิดีโอย้อนหลัง</li><li>หากคอร์สมีระบบย้อนหลัง นักเรียนสามารถทบทวนตามเงื่อนไขของคอร์สนั้น</li><li>โปรโมชั่น: เรียนครั้งแรกลด 25% (รหัส FIRST25) · นักเรียนเก่าลด 10% (รหัส ALUMNI10)</li></ul>',
    'privacy_policy_html' => '<p>กวดวิชาเดอะลีโอน่า (THE LEONA TUTORS) เก็บรักษาข้อมูลส่วนบุคคลเพื่อการสมัครเรียน การชำระเงิน และการติดต่อเท่านั้น ไม่เปิดเผยต่อบุคคลที่สามโดยไม่จำเป็น</p>',
];

foreach ($settings as $key => $value) {
    saveSetting($key, $value);
    echo "setting: {$key}\n";
}

$homepage = defaultHomepageContent();
saveJsonSetting('content_homepage_json', $homepage);
echo "content_homepage_json updated\n";

$faq = defaultFaqItems();
saveJsonSetting('content_faq_json', $faq);
echo "content_faq_json updated\n";

$faqPage = defaultFaqPageContent();
saveJsonSetting('content_faq_page_json', $faqPage);
echo "content_faq_page_json updated\n";

$contact = defaultContactContent();
saveJsonSetting('content_contact_json', $contact);
echo "content_contact_json updated\n";

$footer = defaultFooterContent();
saveJsonSetting('content_footer_json', $footer);
echo "content_footer_json updated\n";

// Deactivate old HSK / test courses
$pdo->exec("UPDATE courses SET is_active = 0, is_featured = 0 WHERE slug LIKE 'hsk%' OR slug LIKE 'exam-prep-hsk%' OR slug LIKE 'e2e-%'");
echo "deactivated old courses\n";

$courses = [
    [
        'slug' => 'm1-intensive-live',
        'title' => 'คอร์สติวเข้มสอบเข้า ม.1 (สอนสด)',
        'subtitle' => 'จำนวน 70 ชั่วโมง · สอนสด',
        'description' => "คอร์สติวเข้มสอบเข้า ม.1 วิชาสังคมศึกษา จำนวน 70 ชั่วโมง รูปแบบสอนสด\n\nเน้นเนื้อหาที่ออกสอบบ่อย เทคนิคการทำข้อสอบ และการฝึกโจทย์อย่างเป็นระบบ\n\nราคาออนไลน์: 2,999 บาท",
        'category' => 'exam_prep',
        'level' => 'beginner',
        'price' => 6999,
        'duration_hours' => 70,
        'course_type' => 'live',
        'is_featured' => 1,
        'sort_order' => 10,
        'highlights' => "สอนสด 70 ชั่วโมง\nเน้นข้อสอบเข้า ม.1\nเอกสารประกอบการเรียน\nเข้าถึงคอร์ส 1 ปี",
    ],
    [
        'slug' => 'm1-intensive-online',
        'title' => 'คอร์สติวเข้มสอบเข้า ม.1 (ออนไลน์)',
        'subtitle' => 'จำนวน 70 ชั่วโมง · ออนไลน์ / ย้อนหลัง',
        'description' => "คอร์สติวเข้มสอบเข้า ม.1 วิชาสังคมศึกษา จำนวน 70 ชั่วโมง รูปแบบออนไลน์\n\nเน้นเนื้อหาที่ออกสอบบ่อย เทคนิคการทำข้อสอบ และการฝึกโจทย์อย่างเป็นระบบ\n\nราคาสอนสด: 6,999 บาท",
        'category' => 'exam_prep',
        'level' => 'beginner',
        'price' => 2999,
        'duration_hours' => 70,
        'course_type' => 'recorded',
        'is_featured' => 1,
        'sort_order' => 20,
        'highlights' => "ออนไลน์ 70 ชั่วโมง\nดูย้อนหลังได้\nเอกสารประกอบการเรียน\nเข้าถึงคอร์ส 1 ปี",
    ],
    [
        'slug' => 'm4-intensive-live',
        'title' => 'คอร์สติวเข้มสอบเข้า ม.4 (สอนสด)',
        'subtitle' => 'จำนวน 70 ชั่วโมง · สอนสด',
        'description' => "คอร์สติวเข้มสอบเข้า ม.4 วิชาสังคมศึกษา จำนวน 70 ชั่วโมง รูปแบบสอนสด\n\nราคาออนไลน์: 2,999 บาท",
        'category' => 'exam_prep',
        'level' => 'intermediate',
        'price' => 6999,
        'duration_hours' => 70,
        'course_type' => 'live',
        'is_featured' => 1,
        'sort_order' => 30,
        'highlights' => "สอนสด 70 ชั่วโมง\nเน้นข้อสอบเข้า ม.4\nเอกสารประกอบการเรียน\nเข้าถึงคอร์ส 1 ปี",
    ],
    [
        'slug' => 'm4-intensive-online',
        'title' => 'คอร์สติวเข้มสอบเข้า ม.4 (ออนไลน์)',
        'subtitle' => 'จำนวน 70 ชั่วโมง · ออนไลน์ / ย้อนหลัง',
        'description' => "คอร์สติวเข้มสอบเข้า ม.4 วิชาสังคมศึกษา จำนวน 70 ชั่วโมง รูปแบบออนไลน์\n\nราคาสอนสด: 6,999 บาท",
        'category' => 'exam_prep',
        'level' => 'intermediate',
        'price' => 2999,
        'duration_hours' => 70,
        'course_type' => 'recorded',
        'is_featured' => 1,
        'sort_order' => 40,
        'highlights' => "ออนไลน์ 70 ชั่วโมง\nดูย้อนหลังได้\nเอกสารประกอบการเรียน\nเข้าถึงคอร์ส 1 ปี",
    ],
    [
        'slug' => 'alevel-social-live',
        'title' => 'คอร์สติวเข้มสอบ A-Level สังคมศึกษา (สอนสด)',
        'subtitle' => 'เตรียมสอบ A-Level สังคมศึกษา · สอนสด',
        'description' => "คอร์สติวเข้มสอบ A-Level วิชาสังคมศึกษา รูปแบบสอนสด\n\nราคาออนไลน์: 2,999 บาท",
        'category' => 'exam_prep',
        'level' => 'advanced',
        'price' => 6999,
        'duration_hours' => 70,
        'course_type' => 'live',
        'is_featured' => 1,
        'sort_order' => 50,
        'highlights' => "สอนสด\nโฟกัส A-Level สังคม\nเทคนิคทำข้อสอบ\nเข้าถึงคอร์ส 1 ปี",
    ],
    [
        'slug' => 'alevel-social-online',
        'title' => 'คอร์สติวเข้มสอบ A-Level สังคมศึกษา (ออนไลน์)',
        'subtitle' => 'เตรียมสอบ A-Level สังคมศึกษา · ออนไลน์',
        'description' => "คอร์สติวเข้มสอบ A-Level วิชาสังคมศึกษา รูปแบบออนไลน์\n\nราคาสอนสด: 6,999 บาท",
        'category' => 'exam_prep',
        'level' => 'advanced',
        'price' => 2999,
        'duration_hours' => 70,
        'course_type' => 'recorded',
        'is_featured' => 1,
        'sort_order' => 60,
        'highlights' => "ออนไลน์\nโฟกัส A-Level สังคม\nดูย้อนหลังได้\nเข้าถึงคอร์ส 1 ปี",
    ],
    [
        'slug' => 'foundation-primary',
        'title' => 'คอร์สปรับพื้นฐานสังคม–ประวัติฯ (ประถมศึกษา)',
        'subtitle' => '20 ชั่วโมง · สด + ออนไลน์',
        'description' => "คอร์สปรับพื้นฐาน / เรียนเพิ่มเกรด วิชาสังคมศึกษา–ประวัติศาสตร์ สำหรับระดับประถมศึกษา จำนวน 20 ชั่วโมง เรียนได้ทั้งสดและออนไลน์",
        'category' => 'foundation',
        'level' => 'beginner',
        'price' => 999,
        'duration_hours' => 20,
        'course_type' => 'hybrid',
        'is_featured' => 1,
        'sort_order' => 70,
        'highlights' => "20 ชั่วโมง\nระดับประถมศึกษา\nสด + ออนไลน์\nเพิ่มเกรด / ปรับพื้นฐาน",
    ],
    [
        'slug' => 'foundation-lower-secondary',
        'title' => 'คอร์สปรับพื้นฐานสังคม–ประวัติฯ (มัธยมต้น)',
        'subtitle' => '20 ชั่วโมง · สด + ออนไลน์',
        'description' => "คอร์สปรับพื้นฐาน / เรียนเพิ่มเกรด วิชาสังคมศึกษา–ประวัติศาสตร์ สำหรับมัธยมศึกษาตอนต้น จำนวน 20 ชั่วโมง เรียนได้ทั้งสดและออนไลน์",
        'category' => 'foundation',
        'level' => 'beginner',
        'price' => 999,
        'duration_hours' => 20,
        'course_type' => 'hybrid',
        'is_featured' => 1,
        'sort_order' => 80,
        'highlights' => "20 ชั่วโมง\nมัธยมศึกษาตอนต้น\nสด + ออนไลน์\nเพิ่มเกรด / ปรับพื้นฐาน",
    ],
    [
        'slug' => 'foundation-upper-secondary',
        'title' => 'คอร์สปรับพื้นฐานสังคม–ประวัติฯ (มัธยมปลาย)',
        'subtitle' => '20 ชั่วโมง · สด + ออนไลน์',
        'description' => "คอร์สปรับพื้นฐาน / เรียนเพิ่มเกรด วิชาสังคมศึกษา–ประวัติศาสตร์ สำหรับมัธยมศึกษาตอนปลาย จำนวน 20 ชั่วโมง เรียนได้ทั้งสดและออนไลน์",
        'category' => 'foundation',
        'level' => 'intermediate',
        'price' => 1099,
        'duration_hours' => 20,
        'course_type' => 'hybrid',
        'is_featured' => 1,
        'sort_order' => 90,
        'highlights' => "20 ชั่วโมง\nมัธยมศึกษาตอนปลาย\nสด + ออนไลน์\nเพิ่มเกรด / ปรับพื้นฐาน",
    ],
];

$upsert = $pdo->prepare("
    INSERT INTO courses (
        slug, title, subtitle, description, category, level, price, duration_hours,
        lesson_count, highlights, is_featured, is_active, course_type, sort_order
    ) VALUES (
        :slug, :title, :subtitle, :description, :category, :level, :price, :duration_hours,
        0, :highlights, :is_featured, 1, :course_type, :sort_order
    )
    ON DUPLICATE KEY UPDATE
        title = VALUES(title),
        subtitle = VALUES(subtitle),
        description = VALUES(description),
        category = VALUES(category),
        level = VALUES(level),
        price = VALUES(price),
        duration_hours = VALUES(duration_hours),
        highlights = VALUES(highlights),
        is_featured = VALUES(is_featured),
        is_active = 1,
        course_type = VALUES(course_type),
        sort_order = VALUES(sort_order)
");

foreach ($courses as $course) {
    $upsert->execute($course);
    echo "course: {$course['slug']}\n";
}

// Coupons from brief
$pdo->exec("UPDATE coupons SET is_active = 0 WHERE code = 'WENXIN10'");
$couponStmt = $pdo->prepare("
    INSERT INTO coupons (code, discount_type, discount_value, min_amount, max_uses, used_count, expires_at, is_active)
    VALUES (?, 'percent', ?, 0, 0, 0, NULL, 1)
    ON DUPLICATE KEY UPDATE discount_type = 'percent', discount_value = VALUES(discount_value), is_active = 1, expires_at = NULL
");
$couponStmt->execute(['FIRST25', 25]);
$couponStmt->execute(['ALUMNI10', 10]);
echo "coupons: FIRST25 (25%), ALUMNI10 (10%)\n";

resetSettingsCache();
echo "=== DONE ===\n";
echo "Open: " . APP_URL . "/public/\n";
