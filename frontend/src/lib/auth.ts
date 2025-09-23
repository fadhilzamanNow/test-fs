import { clearUser, setUser } from "../store/user";
import http from "./axios";

export async function login(payload: { email: string; password: string }) {
  try {
    const { data } = await http.post('auth/login', payload)

     localStorage.setItem('auth_token', data.token)

    const userData = await getMe()
    setUser(userData)

    return data
  } catch (err: any) {
    console.error('Login failed:', err)
    throw new Error(err?.response?.data?.message ?? 'Login gagal')
  }
}

export async function register(payload: {
  username: string
  email: string
  password: string
  role_name: string
  module_name: string
}) {
  try {
    const { data } = await http.post('/auth/register', payload)

    if (data.token) {
      localStorage.setItem('auth_token', data.token)
      localStorage.setItem('auth_module', data.user.module)
    }

    return data
  } catch (err: any) {
    console.error('Register failed:', err)
    throw new Error(err?.response?.data?.message ?? 'Registrasi gagal')
  }
}


export async function logout() {
  try {
    await http.post('/auth/logout')
  } catch (err) {
    console.warn('Logout API failed, clearing anyway')
  } finally {
    localStorage.removeItem('auth_token')
    clearUser()
  }
}

export async function getMe() {
  try {
    const { data } = await http.get('/auth/me')
    return data 
  } catch (err: any) {
    console.error('Fetching user failed:', err)
    throw new Error(err?.response?.data?.message ?? 'Tidak dapat mengambil data user')
  }
}
