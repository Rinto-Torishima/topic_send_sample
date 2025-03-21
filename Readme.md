## firebase プッシュ通知 topic送信　サンプル

### 機能

- PWAとしてインストール可能
- iOSのSafariでプッシュ通知を受信
- プッシュ通知のtopic登録
- topic購読解除機能
- topicを購読しているユーザーへの通知送信

### 必要条件

- Docker
- ngrok (localhostまたはhttpsでないとwebpush(プッシュ通知)が動かないため、iphoneなどで動かす場合はhttpsで動かす必要がある)
- iOS 16.4以上のデバイス（Safari）→ iphoneを使って受信する場合

### 環境構築
* frontendディレクトリの下記ファイルの設定を自分の環境に変更
	* firebase-messaging-sw.js.example
	* .env.examplse
* backendディレクトリの下記ファイルの設定を自分の環境に変更
  * .env.example
  * serviceAccountKey.json.example
    * consoleから取得
    * プロジェクトの設定のサービスアカウントタブからファイル取得して置き換え
 

* ルートディレクトリ
	```
  docker-compose up -d
  ```
* frontend ディレクトリ
	```
  npm run dev
  ```

### ngrokでの公開

別のターミナルで以下のコマンドを実行して、ローカル環境を公開

```bash
ngrok http 5173
```

### iOSデバイスでのアクセス

1. iOSデバイスのSafariでngrokのURLにアクセス
2. ホーム画面に追加
3. ホーム画面からアプリを起動
