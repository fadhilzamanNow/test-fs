import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import tailwindcss from '@tailwindcss/vite'
import path from 'node:path'
import VueRouter from 'unplugin-vue-router/vite'

// https://vite.dev/config/
export default defineConfig({
  plugins: [VueRouter(),vue(), tailwindcss()],
  resolve : {
    alias : {
      "@" : path.resolve(__dirname,"./src")
    }
  }
})
