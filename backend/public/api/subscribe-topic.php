<?php
require_once '/var/www/vendor/autoload.php'; // Firebase Admin SDK 用のライブラリ
require_once '/var/www/config/config.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\MulticastSendReport;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\Topic;

// Firebase Admin SDK の初期化
$factory = (new Factory)->withServiceAccount(FCM_CREDENTIALS);
$messaging = $factory->createMessaging();

// JSON リクエストを取得
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data["token"]) || !isset($data["topic"])) {
    echo json_encode(["error" => "トークンまたはトピックがありません"]);
    exit;
}

$token = $data["token"];
$topic = trim($data["topic"]);

if ($topic === "") {
    echo json_encode(["error" => "トピック名が空です"]);
    exit;
}

// トピックに登録
$messaging->subscribeToTopic($topic, [$token]);

echo json_encode(["message" => "トピック「{$topic}」に登録成功"]);
?>