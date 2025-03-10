## firebase topic指定通知送信　サンプル

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
	````
  npm run dev
  ````
