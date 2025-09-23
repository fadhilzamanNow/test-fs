// src/composables/useAuth.ts
import { ref, computed } from "vue";
import type { Ref } from "vue";
import { http } from "../lib/axios";
type User = { id: string; name: string; email: string };

const user: Ref<User | null> = ref(null);
const loading = ref(false);
const error = ref<string | null>(null);
const isAuthenticated = computed(() => !!user.value);

async function login(payload: { email: string; password: string }) {
  loading.value = true;
  error.value = null;
  try {
    const { data } = await http.post<{ token: string }>("/api/login", payload);
    localStorage.setItem("auth_token", data.token);
    await fetchUser();
  } catch (e: any) {
    error.value = e?.response?.data?.message ?? "Login failed";
  } finally {
    loading.value = false;
  }
}

async function register(payload: { name: string; email: string; password: string }) {
  loading.value = true;
  error.value = null;
  try {
    const { data } = await http.post<{ token: string }>("/api/register", payload);
    localStorage.setItem("auth_token", data.token);
    await fetchUser();
  } catch (e: any) {
    error.value = e?.response?.data?.message ?? "Register failed";
  } finally {
    loading.value = false;
  }
}

async function logout() {
  localStorage.removeItem("auth_token");
  user.value = null;
}

async function fetchUser() {
  try {
    const { data } = await http.get<User>("/api/me");
    user.value = data;
  } catch {
    user.value = null;
  }
}

export function useAuth() {
  return { user, isAuthenticated, loading, error, login, register, logout, fetchUser };
}
