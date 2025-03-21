import { initializeApp } from "firebase/app";
import { getMessaging, getToken, onMessage ,type MessagePayload} from "firebase/messaging";

// Firebase 設定
const firebaseConfig = {
  apiKey: import.meta.env.VITE_FIREBASE_API_KEY,
  authDomain: import.meta.env.VITE_FIREBASE_AUTH_DOMAIN,
  projectId: import.meta.env.VITE_FIREBASE_PROJECT_ID,
  storageBucket: import.meta.env.VITE_FIREBASE_STORAGE_BUCKET,
  messagingSenderId: import.meta.env.VITE_FIREBASE_MESSAGING_SENDER_ID,
  appId: import.meta.env.VITE_FIREBASE_APP_ID
};

// Firebase 初期化
const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

// FCM トークンを取得
export const requestForToken = async (): Promise<string | undefined> => {
  try {
    const token = await getToken(messaging, {
      vapidKey: import.meta.env.VITE_FIREBASE_VAPID_KEY
    });

    if (token) {
      console.log("FCM Token:", token);
      return token;
    } else {
      console.log("トークンが取得できませんでした。");
    }
  } catch (error) {
    console.error("トークン取得エラー:", error);
  }
};

// メッセージ受信イベントを登録
export const onMessageListener = (): Promise<MessagePayload> =>
  new Promise((resolve) => {
    onMessage(messaging, (payload) => {
      console.log("受信したメッセージ:", payload);
      resolve(payload);
    });
  });
