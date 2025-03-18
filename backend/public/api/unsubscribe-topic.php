<?php
require_once '/var/www/vendor/autoload.php';
require_once '/var/www/config/config.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\Topic;

// Firebase Admin SDK 初期化
$factory = (new Factory)->withServiceAccount(FCM_CREDENTIALS);
$messaging = $factory->createMessaging();

// JSON リクエスト取得
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

// トピックから購読解除
$messaging->unsubscribeFromTopic($topic, [$token]);

echo json_encode(["message" => "トピック「{$topic}」の購読を解除しました"]);
