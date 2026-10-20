<?php

declare(strict_types=1);

require_once __DIR__ . '/functions.php';

function getJsonSetting(string $key, array $default): array
{
    $raw = trim(getSetting($key, ''));
    if ($raw === '') {
        return $default;
    }
    try {
        $decoded = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
        return is_array($decoded) ? $decoded : $default;
    } catch (Throwable) {
        return $default;
    }
}

function saveJsonSetting(string $key, array $value): void
{
    saveSetting($key, json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
}

function defaultFaqItems(): array
{
    return [
        ['q' => 'รูปแบบการเรียน Hybrid คืออะไร?', 'a' => 'เป็นการเรียนออนไลน์สดผ่าน ZOOM ควบคู่ไปกับรอบ Onsite โดยคุณครูจะสอนทั้งรูปแบบ Onsite และ Online ไปพร้อมกันในเวลาเดียวกัน (เรียนรู้ไปพร้อมกันแบบ Real-time)', 'scope' => 'main'],
        ['q' => 'นักเรียนรอบ Onsite สามารถเรียนย้อนหลังผ่านช่องทางใดได้บ้าง?', 'a' => 'สามารถรับชมวิดีโอย้อนหลัง (เทปบันทึกจากคอร์สเรียนสด) ได้ทางกลุ่มปิดบน Facebook โดยสามารถแจ้งความประสงค์ขอเข้ากลุ่มกับแอดมินผ่านทาง Line Official Account ของสถาบัน', 'scope' => 'main'],
        ['q' => 'ชำระเงินแล้วขอคืนเงินสด หรือย้ายรอบเรียนได้ไหม?', 'a' => 'สถาบันไม่สามารถคืนเป็นเงินสด ย้ายรอบ หรือย้ายที่นั่งได้ค่ะ แต่สามารถเปลี่ยนยอดชำระเป็นเครดิตสะสม (Credit Hold) เพื่อใช้สมัครคอร์สอื่นภายใน 1 ปีได้', 'scope' => 'main'],
        ['q' => 'หากต้องการเปลี่ยนคอร์สเรียน ต้องแจ้งล่วงหน้ากี่วัน?', 'a' => 'กรุณาแจ้งล่วงหน้าอย่างน้อย 7 วันก่อนเริ่มเรียนครั้งแรก หรือแจ้งก่อนที่ทางสถาบันจะจัดส่งหนังสือเรียน (กรณีคอร์สออนไลน์)', 'scope' => 'main'],
        ['q' => 'ถ้าเริ่มเรียนไปแล้ว แต่อยากยกเลิกหรือเปลี่ยนคอร์ส จะคำนวณเงินคืนอย่างไร?', 'a' => 'สถาบันจะเปลี่ยนยอดเป็นเครดิตสะสม โดยหักค่าหนังสือคอร์สเดิม 300 บาท/เล่ม และหักค่าเรียนตามจำนวนครั้งที่ได้เรียนไปแล้ว', 'scope' => 'main'],
        ['q' => 'หากขาดเรียน สามารถเรียนชดเชยได้ทางไหนบ้าง?', 'a' => 'สามารถขอเรียนชดเชยในรูปแบบออนไลน์ หรือรับชมวิดีโอย้อนหลังผ่านกลุ่มปิดบน Facebook (ยกเว้น คอร์สเรียน Onsite / Online ที่ระบุว่าไม่สามารถรับชมย้อนหลัง)', 'scope' => 'main'],
        ['q' => 'ทำหนังสือเรียนหาย หรือต้องการซื้อหนังสือเรียนเพิ่ม ได้หรือไม่?', 'a' => 'ทางสถาบันจำกัดสิทธิ์หนังสือเรียนแจกฟรี 1 เล่ม/คอร์ส หากทำสูญหายหรือต้องการสั่งซื้อหนังสือเรียนเพิ่ม สามารถแจ้งขอซื้อเพิ่มเติมได้ในราคา 300 บาท/เล่ม', 'scope' => 'main'],
    ];
}

function getStoredFaqItems(): array
{
    return getJsonSetting('content_faq_json', defaultFaqItems());
}

function getFaqItemsByScope(string $scope): array
{
    return array_values(array_filter(
        getStoredFaqItems(),
        static fn(array $item): bool => ($item['scope'] ?? 'main') === $scope && trim($item['q'] ?? '') !== ''
    ));
}

function defaultHomepageContent(): array
{
    return [
        'why' => [
            'eyebrow' => 'จุดเด่นของเรา',
            'title' => 'ทำไมต้องเรียนกับ Learning Studios',
            'subtitle' => 'Learn Unlocked, Lead with Logic. เรียนเป็นระบบ ครบทุกวิชา สอบแข่งขันและสอบเข้า ม.1',
            'cards' => [
                ['title' => 'ทีมครูคุณภาพ', 'text' => 'ครูผู้สอนคณิตศาสตร์ วิทยาศาสตร์ ภาษาอังกฤษ ภาษาไทยและสังคม'],
                ['title' => 'หลักสูตรตรงจุด', 'text' => 'เตรียมสอบเข้า ม.1 โรงเรียนชั้นนำ และสอบแข่งขัน'],
                ['title' => 'เรียน Hybrid', 'text' => 'เรียน Onsite หรือ Online สดผ่าน ZOOM พร้อมกันแบบ Real-time'],
                ['title' => 'ดูแลใกล้ชิด', 'text' => 'ทีมงานพร้อมให้คำปรึกษาตลอดการเรียน'],
            ],
        ],
        'courses' => [
            'title' => 'คอร์สเรียนยอดนิยม',
            'subtitle' => 'เลือกคอร์สที่เหมาะกับระดับและเป้าหมายของคุณ',
        ],
        'instructor' => [
            'title' => 'พบกับครูผู้สอน',
        ],
        'reviews' => [
            'title' => 'รีวิวจากผู้ปกครอง',
            'subtitle' => 'เสียงจากผู้ปกครองที่ไว้วางใจกวดวิชา Learning Studios',
            'items' => [
                ...defaultHomeReviewItems(),
            ],
        ],
        'steps' => [
            'title' => 'ขั้นตอนการเรียน',
            'subtitle' => 'เริ่มต้นติวกับ Learning Studios ได้ใน 4 ขั้นตอนง่ายๆ',
            'items' => defaultHomeStepItems(),
        ],
        'faq' => [
            'title' => 'คำถามที่พบบ่อย',
            'subtitle' => 'คำตอบสำหรับคำถามที่ผู้เรียนถามบ่อยที่สุด',
        ],
        'newsletter' => [
            'title' => 'รับข่าวสารและโปรโมชั่นพิเศษ',
            'subtitle' => 'ไม่พลาดทุกคอร์สเรียนและกิจกรรมดีๆ',
            'placeholder' => 'อีเมลของคุณ',
            'button' => 'สมัครรับข่าวสาร',
        ],
        'trust' => defaultHomeTrustItems(),
    ];
}

function defaultHomeTrustItems(): array
{
    return [
        ['label' => 'คอร์สเรียน', 'value' => '', 'mode' => 'courses'],
        ['label' => 'ครูผู้สอนทุกวิชา', 'value' => '8', 'mode' => 'manual', 'icon' => 'users'],
        ['label' => 'Onsite + Online สด', 'value' => 'Hybrid', 'mode' => 'manual', 'icon' => 'monitor-smartphone'],
        ['label' => 'ครบทุกระดับ', 'value' => 'LEVEL 1–5', 'mode' => 'manual', 'icon' => 'layers'],
    ];
}

function defaultHomeStepItems(): array
{
    return [
        ['title' => 'สมัครสมาชิก', 'text' => 'ลงทะเบียนและเลือกคอร์สที่เหมาะกับระดับของน้อง'],
        ['title' => 'ชำระเงิน', 'text' => 'โอนเงินหรือสแกน PromptPay แล้วแจ้งสลิป'],
        ['title' => 'เข้าเรียน', 'text' => 'เรียน Onsite หรือ Online สดผ่าน ZOOM พร้อมดูย้อนหลัง'],
        ['title' => 'พร้อมสอบ', 'text' => 'ฝึกโจทย์และทบทวนบทเรียน มั่นใจก่อนวันจริง'],
    ];
}

function defaultHomeReviewItems(): array
{
    return [
        ['quote' => 'เนื้อหาเข้าใจง่าย มีเทคนิคทำข้อสอบชัดเจน ลูกเตรียมสอบเข้า ม.1 ได้มั่นใจขึ้นมาก', 'name' => 'คุณแม่มุก', 'course' => 'เตรียม GATE/GIFTED คณิตศาสตร์', 'initial' => 'ม', 'hue' => 220],
        ['quote' => 'คุณครูอธิบายละเอียด เป็นกันเอง ลูกชอบเรียนและทำโจทย์วิทย์ได้ดีขึ้นชัดเจน', 'name' => 'คุณพ่อก้อง', 'course' => 'CORE CONCEPT วิทยาศาสตร์', 'initial' => 'ก', 'hue' => 45],
        ['quote' => 'เลือกได้ทั้ง Onsite และ ZOOM สด สะดวกมาก ขาดเรียนก็ดูย้อนหลังได้', 'name' => 'คุณแม่นิด', 'course' => 'เรียน Hybrid LEVEL 3', 'initial' => 'น', 'hue' => 0],
        ['quote' => 'หนังสือเรียนสรุปดีมาก โจทย์เยอะ ลูกทบทวนเองที่บ้านได้ทุกวัน', 'name' => 'คุณแม่บี', 'course' => 'ตะลุยโจทย์ ป.4', 'initial' => 'บ', 'hue' => 200],
        ['quote' => 'ภาษาอังกฤษดีขึ้นเยอะ ลูกกล้าพูดและทำข้อสอบ EP ได้คล่องขึ้น', 'name' => 'คุณแม่มิ้น', 'course' => 'เตรียม EP ภาษาอังกฤษ', 'initial' => 'ม', 'hue' => 260],
        ['quote' => 'คอร์สออนไลน์เรียนซ้ำได้ ลูกค่อยๆ ฝึกพีชคณิตจนเข้าใจ', 'name' => 'คุณพ่อโอ', 'course' => 'พีชคณิต ONLINE', 'initial' => 'อ', 'hue' => 30],
        ['quote' => 'ติดต่อแอดมินทาง Line ง่าย ตอบไว ช่วยแนะนำคอร์สให้เหมาะกับระดับของลูก', 'name' => 'คุณแม่เจ', 'course' => 'CORE CONCEPT LEVEL 1', 'initial' => 'จ', 'hue' => 150],
        ['quote' => 'SCI-MAP สรุปวิทย์เป็นภาพ จำง่าย ลูกชอบมาก', 'name' => 'คุณแม่ฟ้า', 'course' => 'SCI-MAP', 'initial' => 'ฟ', 'hue' => 190],
    ];
}

function getHomepageContent(): array
{
    $stored = getJsonSetting('content_homepage_json', defaultHomepageContent());
    return array_replace_recursive(defaultHomepageContent(), $stored);
}

function getHomeReviews(): array
{
    $items = getHomepageContent()['reviews']['items'] ?? [];
    return is_array($items) ? $items : [];
}

function defaultContactContent(): array
{
    return [
        'header_title' => 'ติดต่อเรา',
        'header_subtitle' => 'ทีมงานกวดวิชา Learning Studios พร้อมให้คำปรึกษาเรื่องคอร์ส การสมัครเรียน และการชำระเงิน',
        'intro_eyebrow' => 'Learning Studios',
        'intro_title' => 'มีคำถาม? เราช่วยได้',
        'intro_lead_suffix' => 'เลือกช่องทางที่สะดวกที่สุด ทีมงานจะตอบกลับโดยเร็วที่สุด',
        'perks' => [
            'ปรึกษาคอร์สติวสอบและการเรียนได้ฟรี',
            'ตอบกลับภายใน 24 ชั่วโมง (วันทำการ)',
            'ข้อมูลของคุณปลอดภัย ไม่เปิดเผยต่อบุคคลที่สาม',
        ],
        'bottom_title' => 'พร้อมเริ่มเรียนแล้ว?',
        'bottom_text' => 'เลือกคอร์สที่เหมาะกับระดับของคุณ แล้วสมัครเรียนได้ทันที',
        'phone_hours' => 'จันทร์–อาทิตย์ 10:00–20:00 น.',
        'facebook_label' => 'กวดวิชา Learning Studios',
    ];
}

function defaultTermsHtml(): string
{
    return <<<'HTML'
<h2>นโยบายและเงื่อนไขการเรียน</h2>
<h3>1. นโยบายการย้ายวัน/เปลี่ยนคอร์ส และยกเลิกการเรียน</h3>
<ul>
<li><strong>การชำระเงิน:</strong> เมื่อชำระค่าเรียนแล้ว สถาบันขอสงวนสิทธิ์ไม่คืนเงินสด ย้ายวันเรียน หรือย้ายที่นั่งทุกกรณี</li>
<li><strong>การเปลี่ยนเป็นเครดิต (Credit Hold):</strong> หากจำเป็นต้องยกเลิกเรียน สามารถเปลี่ยนยอดชำระเป็นเครดิตสะสม เพื่อใช้นำไปสมัครคอร์สอื่นได้ภายในระยะเวลา 1 ปี</li>
<li><strong>การเปลี่ยนคอร์ส (ก่อนเปิดเรียน):</strong> รบกวนแจ้งล่วงหน้าอย่างน้อย 7 วันก่อนวันเรียนแรก หรือก่อนการจัดส่งหนังสือ (สำหรับคอร์สออนไลน์)</li>
<li><strong>การเปลี่ยน/ยกเลิกคอร์ส (หลังเริ่มเรียนไปแล้ว):</strong> สถาบันขอสงวนสิทธิ์หักค่าใช้จ่ายส่วนต่าง ดังนี้
<ul>
<li>ค่าหนังสือเรียน 300 บาท/เล่ม (สำหรับหนังสือคอร์สที่ยกเลิก)</li>
<li>ค่าเรียนตามจำนวนครั้งที่เรียนไปแล้ว (คิดเฉลี่ยรายครั้งจากราคาเต็ม)</li>
<li>ดำเนินการเชิญ Facebook Account ออกจากกลุ่มเรียน</li>
</ul>
</li>
</ul>
<h3>2. การลาหยุดและการเรียนชดเชย</h3>
<p>กรณีนักเรียนลาหยุด สามารถเข้าเรียนชดเชยในรูปแบบออนไลน์ หรือดูวิดีโอย้อนหลังผ่านกลุ่มปิด Facebook ได้ทุกคอร์สเรียน</p>
<h3>3. ข้อปฏิบัติและการเตรียมตัวสำหรับนักเรียน</h3>
<ul>
<li><strong>สมาธิในห้องเรียน:</strong> ขอความร่วมมือฝากโทรศัพท์มือถือกับเจ้าหน้าที่ก่อนเข้าห้องเรียนทุกครั้ง</li>
<li><strong>ของใช้ส่วนตัว:</strong> ให้นักเรียนเตรียมอุปกรณ์เครื่องเขียน, เสื้อกันหนาว, ของใช้จำเป็น และยารักษาโรคประจำตัว (ถ้ามี)</li>
<li><strong>ทรัพย์สินส่วนตัว:</strong> กรุณาดูแลของมีค่าด้วยตนเอง ทางสถาบันขอสงวนสิทธิ์ไม่รับผิดชอบกรณีสูญหายทุกกรณี</li>
<li><strong>อุปกรณ์ส่วนรวม:</strong> ขอความร่วมมือร่วมกันดูแล หากทำทรัพย์สินของสถาบันชำรุดเสียหาย จะมีการประเมินและเรียกเก็บค่าใช้จ่ายตามจริง</li>
<li><strong>สื่อการเรียน:</strong> หนังสือเรียนจำกัดสิทธิ์ 1 เล่ม ต่อ 1 คน ต่อ 1 คอร์สเรียนเท่านั้น</li>
</ul>
HTML;
}

function getContactContent(): array
{
    $stored = getJsonSetting('content_contact_json', defaultContactContent());
    return array_replace_recursive(defaultContactContent(), $stored);
}

function leonaMediaUrl(string $stored, string $fallbackAsset): string
{
    $stored = trim($stored);
    if ($stored === '') {
        return asset($fallbackAsset);
    }
    if (preg_match('#^https?://#i', $stored)) {
        return $stored;
    }
    if (str_starts_with($stored, 'uploads/')) {
        return APP_URL . '/' . ltrim($stored, '/');
    }
    return asset($stored);
}

function publicContactEmail(): string
{
    $email = trim(getSetting('contact_email', ''));
    if ($email !== '' && !str_ends_with(strtolower($email), '@wenxin.local')) {
        return $email;
    }
    return '';
}

/** Apply client updates once: contact email and promo coupon codes. */
function ensureLeonaClientUpdates(): void
{
    static $done = false;
    if ($done) {
        return;
    }
    $done = true;
    try {
        if (getSetting('leona_client_patch', '') !== '2026-10-02' && getSetting('leona_client_patch', '') !== '2026-10-12-social') {
        $email = trim(getSetting('contact_email', ''));
        $admin = trim(getSetting('email_admin', ''));
        if ($email === '' || str_ends_with(strtolower($email), '@wenxin.local')) {
            saveSetting('contact_email', 'ballcub555@gmail.com');
        }
        if ($admin === '' || str_ends_with(strtolower($admin), '@wenxin.local')) {
            saveSetting('email_admin', 'ballcub555@gmail.com');
        }
        $from = trim(getSetting('email_from', ''));
        if ($from === '' || str_ends_with(strtolower($from), '@wenxin.local')) {
            saveSetting('email_from', 'ballcub555@gmail.com');
        }

        $upsert = db()->prepare('
            INSERT INTO coupons (code, discount_type, discount_value, min_amount, max_uses, used_count, is_active)
            VALUES (?, "percent", ?, 0, 0, 0, 1)
            ON DUPLICATE KEY UPDATE discount_type = "percent", discount_value = VALUES(discount_value), is_active = 1
        ');
        $upsert->execute(['FIRST5', 5]);
        $upsert->execute(['RETURN10', 10]);
        db()->prepare('UPDATE coupons SET is_active = 0 WHERE code = ?')->execute(['FIRST25']);
        saveSetting('leona_client_patch', '2026-10-02');
        }
        if (getSetting('leona_subject_patch', '') !== 'social') {
            $rows = db()->query('SELECT setting_key, setting_value FROM site_settings')->fetchAll();
            $update = db()->prepare('UPDATE site_settings SET setting_value = ? WHERE setting_key = ?');
            foreach ($rows as $row) {
                $value = (string) ($row['setting_value'] ?? '');
                if (!str_contains($value, 'ภาษาจีน')) {
                    continue;
                }
                $update->execute([str_replace('ภาษาจีน', 'สังคมศึกษา', $value), $row['setting_key']]);
            }
            saveSetting('leona_subject_patch', 'social');
            resetSettingsCache();
        }
    } catch (Throwable $e) {
        // Database may not be ready yet.
    }
}

function defaultFooterContent(): array
{
    return [
        'copyright' => 'กวดวิชา Learning Studios. All Rights Reserved.',
        'col_courses' => 'คอร์สเรียน',
        'col_about' => 'เกี่ยวกับเรา',
        'col_help' => 'ช่วยเหลือ',
        'col_contact' => 'ติดต่อเรา',
        'about_links' => [
            ['label' => 'เกี่ยวกับเรา', 'url' => '/public/index.php'],
            ['label' => 'อาจารย์ผู้สอน', 'url' => '/public/instructor.php'],
            ['label' => 'รีวิวจากผู้เรียน', 'url' => '/public/index.php#reviews'],
            ['label' => 'บอร์ดประชาสัมพันธ์', 'url' => '/public/announcements.php'],
        ],
        'help_links' => [
            ['label' => 'คำถามที่พบบ่อย', 'url' => '/public/faq.php'],
            ['label' => 'วิธีการสมัครเรียน', 'url' => '/public/register.php'],
            ['label' => 'แจ้งชำระเงิน', 'url' => '__checkout__'],
            ['label' => 'ติดต่อเรา', 'url' => '/public/contact.php'],
        ],
    ];
}

function getFooterContent(): array
{
    $stored = getJsonSetting('content_footer_json', defaultFooterContent());
    return array_replace_recursive(defaultFooterContent(), $stored);
}

function defaultFaqPageContent(): array
{
    return [
        'page_title' => 'คำถามที่พบบ่อย',
        'page_subtitle' => 'รวบรวมคำตอบสำหรับคำถามที่ผู้เรียนถามบ่อยที่สุด',
        'cta_title' => 'ไม่พบคำตอบที่ต้องการ?',
        'cta_text' => 'โทรหาทีมงานกวดวิชา Learning Studios เราพร้อมให้คำปรึกษาเรื่องคอร์สและการสมัครเรียน',
        'promo_eyebrow' => 'ยังมีคำถาม?',
        'promo_title' => 'ทีมงานพร้อมช่วยเหลือ',
        'promo_text' => 'สอบถามเรื่องคอร์ส การชำระเงิน หรือการใช้งานระบบได้ทันที',
    ];
}

function getFaqPageContent(): array
{
    $stored = getJsonSetting('content_faq_page_json', defaultFaqPageContent());
    return array_replace_recursive(defaultFaqPageContent(), $stored);
}

function parseFaqItemsFromPost(array $questions, array $answers, array $scopes): array
{
    $items = [];
    foreach ($questions as $i => $q) {
        $q = trim((string) $q);
        $a = trim((string) ($answers[$i] ?? ''));
        if ($q === '' && $a === '') {
            continue;
        }
        $scope = (string) ($scopes[$i] ?? 'main');
        if (!in_array($scope, ['main', 'homepage_extra'], true)) {
            $scope = 'main';
        }
        $items[] = ['q' => $q, 'a' => $a, 'scope' => $scope];
    }
    return $items;
}

function parseReviewItemsFromPost(array $quotes, array $names, array $courses, array $initials, array $hues): array
{
    $items = [];
    foreach ($quotes as $i => $quote) {
        $quote = trim((string) $quote);
        if ($quote === '') {
            continue;
        }
        $name = trim((string) ($names[$i] ?? ''));
        $items[] = [
            'quote' => $quote,
            'name' => $name,
            'course' => trim((string) ($courses[$i] ?? '')),
            'initial' => trim((string) ($initials[$i] ?? mb_substr($name, 0, 1))),
            'hue' => (int) ($hues[$i] ?? 0),
        ];
    }
    return $items;
}

function faqScopeLabel(string $scope): string
{
    return $scope === 'homepage_extra' ? 'หน้าแรก' : 'หน้า FAQ';
}

function getContentSectionRows(): array
{
    $home = getHomepageContent();
    $contact = getContactContent();
    $footer = getFooterContent();
    $faqPage = getFaqPageContent();
    $faqItems = getStoredFaqItems();
    $faqMainCount = count(getFaqItemsByScope('main'));
    $faqHomeCount = count(getFaqItemsByScope('homepage_extra'));

    return [
        [
            'tab' => 'home',
            'title' => $home['why']['title'] ?? 'หน้าแรก',
            'summary' => $home['why']['subtitle'] ?? '',
            'category' => 'หน้าแรก',
            'meta' => count($home['reviews']['items'] ?? []) . ' รีวิว · ' . count($home['steps']['items'] ?? []) . ' ขั้นตอน',
            'status' => 'เผยแพร่',
            'view_url' => APP_URL . '/public/index.php',
            'icon' => 'home',
        ],
        [
            'tab' => 'contact',
            'title' => $contact['header_title'] ?? 'ติดต่อเรา',
            'summary' => $contact['header_subtitle'] ?? '',
            'category' => 'ติดต่อ',
            'meta' => trim(getSetting('line_id', '')) !== '' ? 'มี Line' : 'ยังไม่ตั้ง Line',
            'status' => 'เผยแพร่',
            'view_url' => APP_URL . '/public/contact.php',
            'icon' => 'contact',
        ],
        [
            'tab' => 'footer',
            'title' => 'Footer — ' . ($footer['col_contact'] ?? 'ติดต่อเรา'),
            'summary' => getSetting('site_tagline', ''),
            'category' => 'ท้ายเว็บ',
            'meta' => (count($footer['about_links'] ?? []) + count($footer['help_links'] ?? [])) . ' ลิงก์',
            'status' => 'เผยแพร่',
            'view_url' => APP_URL . '/public/index.php#contact',
            'icon' => 'footer',
        ],
        [
            'tab' => 'faq',
            'title' => $faqPage['page_title'] ?? 'คำถามที่พบบ่อย',
            'summary' => $faqPage['page_subtitle'] ?? '',
            'category' => 'FAQ',
            'meta' => $faqMainCount . ' ข้อ FAQ · ' . $faqHomeCount . ' ข้อหน้าแรก',
            'status' => 'เผยแพร่',
            'view_url' => APP_URL . '/public/faq.php',
            'icon' => 'faq',
        ],
    ];
}

function contentBlockLucideIcon(string $icon, int $size = 18): string
{
    $map = [
        'sparkles' => 'sparkles',
        'chart-column' => 'chart-column',
        'graduation-cap' => 'graduation-cap',
        'book-open' => 'book-open',
        'users' => 'users',
        'star' => 'star',
        'list-ordered' => 'list-ordered',
        'circle-help' => 'circle-help',
        'mail' => 'mail',
        'phone' => 'phone',
        'map-pinned' => 'map-pinned',
        'link' => 'link',
        'life-buoy' => 'life-buoy',
        'panel-bottom' => 'panel-bottom',
        'file-text' => 'file-text',
        'messages-square' => 'messages-square',
    ];

    return lucide_icon($map[$icon] ?? 'file-text', ['size' => $size, 'stroke' => '1.75']);
}

function getContentBlockRows(string $tab): array
{
    $home = getHomepageContent();
    $contact = getContactContent();
    $footer = getFooterContent();
    $faqPage = getFaqPageContent();
    $faqItems = getStoredFaqItems();
    $tagline = trim(getSetting('site_tagline', ''));

    return match ($tab) {
        'home' => [
            [
                'block' => 'general',
                'title' => 'ข้อมูลทั่วไป & Hero',
                'summary' => $tagline,
                'category' => 'หน้าแรก',
                'meta' => 'สโลแกน · Hero',
                'status' => 'เผยแพร่',
                'icon' => 'sparkles',
                'view_url' => APP_URL . '/public/index.php',
            ],
            [
                'block' => 'trust',
                'title' => 'แถบสถิติ',
                'summary' => $home['trust'][0]['label'] ?? '',
                'category' => 'หน้าแรก',
                'meta' => count($home['trust'] ?? []) . ' รายการ',
                'status' => 'เผยแพร่',
                'icon' => 'chart-column',
                'view_url' => APP_URL . '/public/index.php',
            ],
            [
                'block' => 'why',
                'title' => $home['why']['title'] ?? 'ทำไมต้องเรียนกับ Wenxin',
                'summary' => $home['why']['subtitle'] ?? '',
                'category' => 'หน้าแรก',
                'meta' => count($home['why']['cards'] ?? []) . ' การ์ด',
                'status' => 'เผยแพร่',
                'icon' => 'graduation-cap',
                'view_url' => APP_URL . '/public/index.php',
            ],
            [
                'block' => 'courses',
                'title' => $home['courses']['title'] ?? 'คอร์สยอดนิยม',
                'summary' => $home['courses']['subtitle'] ?? '',
                'category' => 'หน้าแรก',
                'meta' => 'หัวข้อส่วนคอร์ส',
                'status' => 'เผยแพร่',
                'icon' => 'book-open',
                'view_url' => APP_URL . '/public/index.php#courses',
            ],
            [
                'block' => 'instructor',
                'title' => $home['instructor']['title'] ?? 'ผู้สอน',
                'summary' => getSetting('instructor_name', ''),
                'category' => 'หน้าแรก',
                'meta' => 'หัวข้อส่วนผู้สอน',
                'status' => 'เผยแพร่',
                'icon' => 'users',
                'view_url' => APP_URL . '/public/index.php#instructor',
            ],
            [
                'block' => 'reviews',
                'title' => $home['reviews']['title'] ?? 'รีวิวผู้เรียน',
                'summary' => $home['reviews']['subtitle'] ?? '',
                'category' => 'หน้าแรก',
                'meta' => count($home['reviews']['items'] ?? []) . ' รีวิว',
                'status' => 'เผยแพร่',
                'icon' => 'star',
                'view_url' => APP_URL . '/public/index.php',
            ],
            [
                'block' => 'steps',
                'title' => $home['steps']['title'] ?? 'ขั้นตอนการเรียน',
                'summary' => $home['steps']['subtitle'] ?? '',
                'category' => 'หน้าแรก',
                'meta' => count($home['steps']['items'] ?? []) . ' ขั้นตอน',
                'status' => 'เผยแพร่',
                'icon' => 'list-ordered',
                'view_url' => APP_URL . '/public/index.php',
            ],
            [
                'block' => 'faq',
                'title' => $home['faq']['title'] ?? 'FAQ บนหน้าแรก',
                'summary' => $home['faq']['subtitle'] ?? '',
                'category' => 'หน้าแรก',
                'meta' => 'หัวข้อส่วน FAQ',
                'status' => 'เผยแพร่',
                'icon' => 'circle-help',
                'view_url' => APP_URL . '/public/index.php#faq',
            ],
            [
                'block' => 'newsletter',
                'title' => $home['newsletter']['title'] ?? 'รับข่าวสาร',
                'summary' => $home['newsletter']['subtitle'] ?? '',
                'category' => 'หน้าแรก',
                'meta' => 'ฟอร์มสมัครรับข่าว',
                'status' => 'เผยแพร่',
                'icon' => 'mail',
                'view_url' => APP_URL . '/public/index.php',
            ],
        ],
        'contact' => [
            [
                'block' => 'channels',
                'title' => 'ช่องทางติดต่อ',
                'summary' => trim(getSetting('line_id', '')) !== '' ? 'Line: ' . getSetting('line_id') : 'ยังไม่ตั้ง Line',
                'category' => 'ติดต่อ',
                'meta' => 'Line · โทร · โซเชียล',
                'status' => 'เผยแพร่',
                'icon' => 'phone',
                'view_url' => APP_URL . '/public/contact.php',
            ],
            [
                'block' => 'page',
                'title' => $contact['header_title'] ?? 'ข้อความหน้าติดต่อ',
                'summary' => $contact['header_subtitle'] ?? '',
                'category' => 'ติดต่อ',
                'meta' => count($contact['perks'] ?? []) . ' จุดเด่น',
                'status' => 'เผยแพร่',
                'icon' => 'map-pinned',
                'view_url' => APP_URL . '/public/contact.php',
            ],
        ],
        'footer' => [
            [
                'block' => 'general',
                'title' => 'ข้อมูลทั่วไป',
                'summary' => $footer['copyright'] ?? '',
                'category' => 'ท้ายเว็บ',
                'meta' => 'สโลแกน · ลิขสิทธิ์ · หัวคอลัมน์',
                'status' => 'เผยแพร่',
                'icon' => 'panel-bottom',
                'view_url' => APP_URL . '/public/index.php#contact',
            ],
            [
                'block' => 'about_links',
                'title' => 'ลิงก์เกี่ยวกับเรา',
                'summary' => $footer['col_about'] ?? '',
                'category' => 'ท้ายเว็บ',
                'meta' => count($footer['about_links'] ?? []) . ' ลิงก์',
                'status' => 'เผยแพร่',
                'icon' => 'link',
                'view_url' => APP_URL . '/public/index.php#contact',
            ],
            [
                'block' => 'help_links',
                'title' => 'ลิงก์ช่วยเหลือ',
                'summary' => $footer['col_help'] ?? '',
                'category' => 'ท้ายเว็บ',
                'meta' => count($footer['help_links'] ?? []) . ' ลิงก์',
                'status' => 'เผยแพร่',
                'icon' => 'life-buoy',
                'view_url' => APP_URL . '/public/index.php#contact',
            ],
        ],
        'faq' => [
            [
                'block' => 'page',
                'title' => $faqPage['page_title'] ?? 'ตั้งค่าหน้า FAQ',
                'summary' => $faqPage['page_subtitle'] ?? '',
                'category' => 'FAQ',
                'meta' => 'หัวข้อ · CTA',
                'status' => 'เผยแพร่',
                'icon' => 'file-text',
                'view_url' => APP_URL . '/public/faq.php',
            ],
            [
                'block' => 'items',
                'title' => 'รายการคำถาม',
                'summary' => 'จัดการคำถาม-คำตอบทั้งหมด',
                'category' => 'FAQ',
                'meta' => count($faqItems) . ' ข้อ',
                'status' => 'เผยแพร่',
                'icon' => 'messages-square',
                'view_url' => APP_URL . '/public/faq.php',
            ],
        ],
        default => [],
    };
}

function getFaqItemAdminRows(): array
{
    $rows = [];
    foreach (getStoredFaqItems() as $index => $item) {
        $rows[] = [
            'index' => $index,
            'title' => $item['q'] ?? '',
            'category' => faqScopeLabel($item['scope'] ?? 'main'),
            'meta' => mb_strimwidth(strip_tags($item['a'] ?? ''), 0, 60, '...'),
            'status' => 'เผยแพร่',
            'icon' => 'circle-help',
            'view_url' => APP_URL . '/public/faq.php',
        ];
    }

    return $rows;
}

function contentBlockTitle(string $tab, string $block): string
{
    foreach (getContentBlockRows($tab) as $row) {
        if (($row['block'] ?? '') === $block) {
            return (string) ($row['title'] ?? $block);
        }
    }
    if ($tab === 'faq' && $block === 'item') {
        return 'แก้ไขคำถาม';
    }

    return $block;
}

function contentBlockAllowed(string $tab, string $block): bool
{
    if ($block === '') {
        return false;
    }
    if ($tab === 'faq' && in_array($block, ['item', 'items'], true)) {
        return true;
    }

    foreach (getContentBlockRows($tab) as $row) {
        if (($row['block'] ?? '') === $block) {
            return true;
        }
    }

    return false;
}
