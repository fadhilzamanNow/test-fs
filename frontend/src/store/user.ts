import { ref } from 'vue'

export interface User {
  id: string
  name: string
  email: string
  role:  string
  module: string
}

const user = ref<User | null>(null)

export function useUser() {
  return { user }
}

export function setUser(u: User) {
  user.value = u
}

export function clearUser() {
  user.value = null
}
