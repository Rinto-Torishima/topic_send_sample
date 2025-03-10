import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueJsx from '@vitejs/plugin-vue-jsx'
import vueDevTools from 'vite-plugin-vue-devtools'

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    vueJsx(),
    vueDevTools(),
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    },
  },
  server: {
    proxy: {
      "/api": {
        target: "http://localhost:8000",
        changeOrigin: true,
        secure: false,  // HTTPSを使わない場合は false
      },
    },
    host: '0.0.0.0',  // 外部アクセスを許可
    port: 5173,  // Vite のデフォルトポート
    strictPort: true,  // 固定ポートを使用
    allowedHosts: ['.ngrok-free.app'],  // ngrokのホストを許可
  }
})
