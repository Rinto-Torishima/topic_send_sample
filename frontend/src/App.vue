<template>
  <div>
    <!-- <nav>
      <router-link to="/">Home</router-link> |
      <router-link to="/about">About</router-link>
    </nav> -->

    <!-- 通知コンポーネント -->
    <!-- <Notification /> -->
    
    <!-- ルートコンポーネントを表示 -->
    <router-view />
  </div>
</template>

<script setup lang="ts">
import Notification from "./components/Notification.vue";
</script>
