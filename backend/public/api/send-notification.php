<?php
require_once '/var/www/config/config.php';
require_once "/var/www/vendor/autoload.php";


use Google\Auth\Credentials\ServiceAccountCredentials;

// OPTIONSリクエストを処理 (CORS対策)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// POSTリクエストのみ許可
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "POSTリクエストのみ許可されています"]);
    exit;
}

// JSONデータを取得
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["success" => false, "error" => "JSONのデコードに失敗しました"]);
    error_log("JSONデコードエラー: " . json_last_error_msg());
    exit;
}

if (!isset($data["topic"]) || !isset($data["title"]) || !isset($data["message"])) {
    echo json_encode(["success" => false, "error" => "必要なパラメータがありません"]);
    exit;
}

$topic = $data["topic"];
$title = $data["title"];
$message = $data["message"];

// FCMエンドポイント
$url = FCM_URL;

//  `Bearer Token` を取得
function getAccessToken() {
  $credentials = new ServiceAccountCredentials(
      "https://www.googleapis.com/auth/firebase.messaging",
      json_decode(file_get_contents(FCM_CREDENTIALS), true)
  );
  $accessToken = $credentials->fetchAuthToken();
  return $accessToken["access_token"] ?? null;
}

$accessToken = getAccessToken();
if (!$accessToken) {
  echo json_encode(["success" => false, "error" => "FCMの認証トークン取得に失敗しました"]);
  exit;
}

// `v1` API 用のデータ形式
$fields = [
  'message' => [
      'topic' => $topic,
      'notification' => [
          'title' => $title,
          'body' => $message,
      ],
      'webpush' => [
          'fcm_options' => [
              'link' => 'http://localhost:5173/'
          ]
      ]
  ]
];

// cURLリクエストの設定
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  'Authorization: Bearer ' . $accessToken, //  `Bearer` トークンを使用
  'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

//  リクエスト送信
$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// エラーログ出力（デバッグ用）
error_log("FCMレスポンス: " . $result);

if ($httpCode === 200) {
  echo json_encode(["success" => true, "message" => "通知が送信されました"]);
} else {
  echo json_encode(["success" => false, "error" => "通知の送信に失敗しました", "details" => $result]);
}
?>