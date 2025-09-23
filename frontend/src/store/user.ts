import { ref } from 'vue'

export interface User {
  id: string
  name: string
  email: string
  role:  string
  module: string
}


const stored = localStorage.getItem('user')
const user = ref<User | null>(stored ? JSON.parse(stored) : null)

export function useUser() {
  return { user }
}

export function setUser(u: User) {
  user.value = u
  localStorage.setItem('user', JSON.stringify(u))

}

export function clearUser() {
  user.value = null
  localStorage.removeItem('user')
}

export function hydrateUser() {
  const raw = localStorage.getItem('user')
  if (raw) {
    try {
      user.value = JSON.parse(raw)
    } catch {
      clearUser()
    }
  }
}
