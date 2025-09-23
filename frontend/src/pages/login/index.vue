<script setup lang="ts">
import { ref } from 'vue'
import { useRouter, useRoute, RouterLink } from 'vue-router'
import { z } from 'zod'

import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { login } from '@/lib/auth'
import { useUser } from '@/store/user'
// shadcn/ui alert-dialog
import {
  AlertDialog,
  AlertDialogTrigger,
  AlertDialogContent,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogCancel,
  AlertDialogAction,
} from '@/components/ui/alert-dialog'
import { Icon } from '@iconify/vue'

const { user } = useUser()
const email = ref('')
const password = ref('')
const loading = ref(false)
const showError = ref(false)       // controls dialog visibility
const errorMessage = ref('')       // message for the dialog
const showPassword = ref(false);
const router = useRouter()
const route = useRoute()

const loginSchema = z.object({
  email: z.string().email('Email tidak valid'),
  password: z.string().min(6, 'Password minimal 6 karakter'),
})



async function onSubmit() {
  // validate with zod
  const result = loginSchema.safeParse({ email: email.value, password: password.value })
  if (!result.success) {
    errorMessage.value = result.error.issues.map((i) => i.message).join(', ')
    showError.value = true
    return
  }

  try {
    loading.value = true
    const data = await login({ email: email.value, password: password.value })

    // redirect
   if (user.value?.module === 'PPIC') router.replace('/product')
    else if (user.value?.module === 'Production') router.replace('/orders')
    else router.replace('/')
  } catch (err: any) {
    errorMessage.value = err.message ?? 'Login gagal'
    showError.value = true
  } finally {
    loading.value = false
  }
}

definePage({
  beforeEnter() {
    const authed = !!localStorage.getItem('auth_token')
    if (authed) {
      const userModule = localStorage.getItem('user').module
      if (userModule === 'PPIC') return { path: '/product', replace: true }
      if (userModule === 'Production') return { path: '/order', replace: true }
    }
    return true
  },
})
</script>

<template>
  <main class="w-full h-screen bg-white sm:bg-slate-200 flex justify-center items-center">
    <div
      class="w-full max-w-md min-h-70 bg-white mx-auto flex flex-col px-4 py-6 rounded-xl gap-6 items-center"
    >
      <form class="flex flex-col gap-6 w-full" @submit.prevent="onSubmit">
         <h1 class="font-extrabold text-2xl text-center">Elitech Vision</h1>
        <div class="flex flex-col gap-2 w-full">
          <Label for="email">Email</Label>
          <Input id="email" type="text" v-model="email" placeholder="Your Email" />
        </div>

        <div class="flex flex-col gap-2 w-full">
          <Label for="password">Password</Label>
          <div class="relative">
              <Input
                id="password"
                :type="!showPassword ? 'password' : 'text'"
                v-model="password"
                placeholder="Your Password"
              />
            <div class="absolute top-1/2 -translate-y-1/2 right-2" @click="showPassword = !showPassword">
                    <Icon icon="gravity-ui:eye" v-if="!showPassword" />
                    <Icon icon="gravity-ui:eye-slash" v-else />
                </div>
          </div>
        </div>

        <Button class="w-full" type="submit" :disabled="loading">
          {{ loading ? 'Logging in…' : 'Login' }}
        </Button>
      </form>

      <p class="flex gap-2">
        <span>Apakah anda belum memiliki akun?</span>
        <RouterLink
          class="text-blue-600 hover:text-blue-600/80 underline cursor-pointer"
          to="/register"
          >Daftar</RouterLink
        >
      </p>
    </div>

    <!-- Alert Dialog -->
    <AlertDialog :open="showError" @update:open="showError = $event">
      <AlertDialogContent>
        <AlertDialogHeader>
          <AlertDialogTitle>Login Gagal</AlertDialogTitle>
          <AlertDialogDescription>
            {{ errorMessage }}
          </AlertDialogDescription>
        </AlertDialogHeader>
        <AlertDialogFooter>
          <AlertDialogAction @click="showError = false">OK</AlertDialogAction>
        </AlertDialogFooter>
      </AlertDialogContent>
    </AlertDialog>
  </main>
</template>
