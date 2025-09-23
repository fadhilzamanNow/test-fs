// router/guard.ts
import type { Router } from 'vue-router'
import { useUser, hydrateUser } from '../store/user'
export function installGuards(router: Router) {
  const { user } = useUser()

  router.beforeEach((to) => {
    // ensure user is hydrated on reload
    if (!user.value) hydrateUser()

    const token = localStorage.getItem('auth_token')
    const isAuth = !!token

    // if not logged in and trying private
    if (!isAuth && to.path !== '/login' && to.path !== '/register') {
      return { path: '/login', replace: true }
    }

    if (!user.value) return true // still no user info yet, allow

    // now redirect based on module
    if (user.value.module === 'PPIC') {
      if (!['/product', '/product-plan', '/plan-log'].includes(to.path)) {
        return { path: '/product', replace: true }
      }
    } else if (user.value.module === 'Production') {
      if (!['/orders', '/order-log'].includes(to.path)) {
        return { path: '/orders', replace: true }
      }
    }

    return true
  })
}
