<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// .env読み込み
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// 環境変数を取得
define('FCM_URL', $_ENV['FCM_URL']);
define('FCM_CREDENTIALS', $_ENV['FCM_CREDENTIALS']);
