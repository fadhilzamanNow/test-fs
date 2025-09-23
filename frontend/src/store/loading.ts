import { ref } from 'vue'

const isLoading = ref(false)

export function useLoading() {
  return { isLoading }
}

export function startLoading() {
  isLoading.value = true
}

export function stopLoading() {
  isLoading.value = false
}
