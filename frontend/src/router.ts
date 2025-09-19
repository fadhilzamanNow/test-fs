import { createRouter, createWebHistory } from 'vue-router/auto'
import { routes} from 'vue-router/auto-routes'
/* const routes = [
  { path: '/login', component: Login },
] */

export const router = createRouter({
    history: createWebHistory(),
    routes
})
