<template>
  <div class="container">
    <h2>通知送信フォーム</h2>

    <div class="form-group">
      <label for="topic">トピック:</label>
      <input id="topic" v-model="topic" type="text" placeholder="トピック名" />
    </div>

    <div class="form-group">
      <label for="title">タイトル:</label>
      <input id="title" v-model="title" type="text" placeholder="通知タイトル" />
    </div>

    <div class="form-group">
      <label for="message">メッセージ:</label>
      <textarea id="message" v-model="message" placeholder="通知内容"></textarea>
    </div>

    <button @click="sendNotification" :disabled="isLoading">
      {{ isLoading ? '送信中...' : '通知を送信' }}
    </button>

    <div v-if="result" class="result">
      {{ result }}
    </div>
    <div class="back-link-wrapper">
      <router-link to="/" class="back-link">戻る</router-link>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";

const topic = ref("");
const title = ref("");
const message = ref("");
const isLoading = ref(false);
const result = ref(null);

const sendNotification = async () => {
  if (!topic.value || !title.value || !message.value) {
    result.value = "すべてのフィールドを入力してください";
    return;
  }

  isLoading.value = true;
  try {
    const response = await fetch("/api/send-notification.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        topic: topic.value,
        title: title.value,
        message: message.value,
      }),
    });

    const data = await response.json();
    result.value = data.success
      ? "通知が正常に送信されました"
      : `エラー: ${data.error || "不明なエラー"}`;
  } catch (error) {
    result.value = `エラー: ${error.message}`;
  } finally {
    isLoading.value = false;
  }
};
</script>

<style scoped>
.container {
  max-width: 500px;
  margin: 2rem auto;
  background: white;
  padding: 2rem;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  text-align: center;
}

h2 {
  font-size: 1.5rem;
  margin-bottom: 1rem;
}

.form-group {
  margin-bottom: 1rem;
  text-align: left;
}

label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}

input,
textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 1rem;
}

textarea {
  resize: vertical;
  height: 80px;
}

button {
  background: #28a745;
  color: white;
  border: none;
  padding: 0.8rem 1.5rem;
  border-radius: 5px;
  cursor: pointer;
  transition: background 0.3s;
}

button:hover {
  background: #218838;
}

.result {
  margin-top: 1rem;
  padding: 0.5rem;
  background: #f8f9fa;
  border-left: 5px solid #007bff;
  color: #333;
  text-align: left;
}

.button-wrapper,
.back-link-wrapper {
  margin-top: 1rem;
  text-align: center;
}

.back-link {
  display: inline-block;
  margin-top: 1rem;
  color: #007bff;
  text-decoration: none;
  font-weight: bold;
}

.back-link:hover {
  text-decoration: underline;
}
</style>
