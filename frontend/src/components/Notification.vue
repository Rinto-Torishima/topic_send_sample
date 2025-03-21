<template>
  <div class="container">
    <h2>プッシュ通知</h2>

    <div class="button-group">
      <button @click="getNotificationToken">通知を許可</button>
    </div>

    <p v-if="fcmToken" class="token">FCM Token: {{ fcmToken }}</p>

    <div class="topic-input-group">
      <input v-model="topicName" placeholder="トピック名を入力" />
    </div>

    <div class="topic-input-group">
      <button @click="subscribeToTopic">トピックを登録</button>
    </div>

    <div class="topic-input-group">
      <button @click="unsubscribeFromTopic" class="unsubscribe">トピックの購読を解除</button>
    </div>

    <router-link to="/notification_form" class="link">通知送信フォームへ</router-link>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import { requestForToken, onMessageListener } from "../firebase";
import type { MessagePayload } from "firebase/messaging";

interface TopicResponse {
  message: string
}

const fcmToken = ref<string | undefined>("");
const topicName = ref(""); // ユーザーが入力するトピック名

const getNotificationToken = async () => {
  fcmToken.value = await requestForToken();
};

const subscribeToTopic = async () => {
  if (!fcmToken.value) {
    alert("まず通知を許可してください");
    return;
  }
  if (!topicName.value.trim()) {
    alert("トピック名を入力してください");
    return;
  }

  try {
    const response = await fetch("/api/subscribe-topic.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        token: fcmToken.value,
        topic: topicName.value,
      }),
    });
    const result : TopicResponse = await response.json();
    alert(result.message);
  } catch (error) {
    console.error("トピック登録エラー:", error);
  }
};

const unsubscribeFromTopic = async () => {
  if (!fcmToken.value) {
    alert("まず通知を許可してください");
    return;
  }
  if (!topicName.value.trim()) {
    alert("トピック名を入力してください");
    return;
  }

  try {
    const response = await fetch("/api/unsubscribe-topic.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        token: fcmToken.value,
        topic: topicName.value,
      }),
    });
    const result : TopicResponse = await response.json();
    alert(result.message);
  } catch (error) {
    console.error("トピック購読解除エラー:", error);
  }
};

onMounted(async () => {
  // 通知がすでに許可されていればトークンを取得
  if (Notification.permission === "granted") {
    fcmToken.value = await requestForToken();
  }
  onMessageListener().then((payload: MessagePayload) => {
    alert(`新しい通知: ${payload.notification?.title ?? "タイトルなし"}`)
  });
});
</script>

<style scoped>
.container {
  max-width: 500px;
  margin: 2rem auto;
  text-align: center;
  background: #ffffff;
  padding: 1.5rem;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h2 {
  font-size: 1.5rem;
  margin-bottom: 1rem;
}

.button-group {
  display: flex;
  justify-content: center;
  margin-bottom: 1rem;
}

.topic-input-group {
  display: block;
  text-align: center;
  margin-bottom: 1rem;
}

input {
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 5px;
  width: 200px;
}

button {
  background: #007bff;
  color: white;
  border: none;
  padding: 0.8rem 1.5rem;
  border-radius: 5px;
  cursor: pointer;
  transition: background 0.3s;
}

button:hover {
  background: #0056b3;
}

.token {
  font-size: 0.9rem;
  word-break: break-all;
  color: #333;
  background: #f8f9fa;
  padding: 0.5rem;
  border-radius: 5px;
  margin-top: 1rem;
}

.link {
  display: inline-block;
  margin-top: 1rem;
  color: #007bff;
  text-decoration: none;
}

.link:hover {
  text-decoration: underline;
}

.unsubscribe {
  background: #dc3545;
}

.unsubscribe:hover {
  background: #a71d2a;
}

</style>
