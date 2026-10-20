<?php
declare(strict_types=1);

require dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/site_content.php';

$content = getJsonSetting('content_homepage_json', defaultHomepageContent());
$content['trust'] = defaultHomeTrustItems();
$content['steps']['items'] = defaultHomeStepItems();
$content['reviews']['items'] = defaultHomeReviewItems();
$content['courses']['subtitle'] = 'คอร์สเตรียมสอบเข้า ม.1 และสอบแข่งขัน เลือกให้เหมาะกับระดับของน้อง';
$content['newsletter']['subtitle'] = 'ไม่พลาดรอบเรียนใหม่ คอร์สใหม่ และโปรโมชั่นจาก Learning Studios';

saveSetting('content_homepage_json', json_encode($content, JSON_UNESCAPED_UNICODE));
echo "content_homepage_json updated\n";
