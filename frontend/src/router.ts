import { createRouter, createWebHistory } from 'vue-router/auto'
import { routes } from 'vue-router/auto-routes'
import { installGuards } from './router/guard'

export const router = createRouter({
  history: createWebHistory(),
  routes,
})

installGuards(router)