import { createApp } from "vue";
import App from "./App.vue";
import router from "./router"; // Vue Router をインポート

const app = createApp(App);

app.use(router); // ✅ Vue Router を登録

app.mount("#app");
if ("serviceWorker" in navigator) {
  navigator.serviceWorker
    .register("/firebase-messaging-sw.js")
    .then((registration) => {
      console.log("Service Worker 登録成功:", registration);
    })
    .catch((error) => {
      console.error("Service Worker 登録失敗:", error);
    });
}
