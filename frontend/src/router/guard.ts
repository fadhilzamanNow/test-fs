// src/router/guards.ts
import type { Router, RouteLocationNormalized } from 'vue-router';
import http from '../lib/axios';
import { useAuth } from '../composables/useAuth';

export function installAuthGuards(router: Router): void {
  const { fetchUser, user } = useAuth();
  let bootstrapped = false;

  // 401 -> drop token + go to /login
  http.interceptors.response.use(
    r => r,
    err => {
      if (err?.response?.status === 401) {
        localStorage.removeItem('auth_token');
        const cur = router.currentRoute.value;
        if (cur.path !== '/login') {
          router.replace({ path: '/login', replace: true });
        }
      }
      return Promise.reject(err);
    }
  );

  router.beforeEach(async (to: RouteLocationNormalized) => {
    // Debug (leave while testing)
    console.log('[guard] to=', to.fullPath, 'meta=', to.meta, 'user?', !!user.value);

    // Bootstrap session once
    if (!bootstrapped) {
      bootstrapped = true;
      try { await fetchUser(); } catch {}
    }

    // Block visiting /login when already authed
    if (to.path === '/login' && user.value) {
      return { path: '/', replace: true };
    }

    // Only protect routes that declare it
    if (to.meta?.requiresAuth && !user.value) {
      // You said you want just /login (no redirect query)
      return { path: '/login', replace: true };
    }

    return true;
  });
}
