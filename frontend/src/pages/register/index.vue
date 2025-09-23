<script setup lang="ts">
import { ref } from 'vue'
import { useRouter, RouterLink } from 'vue-router'
import { z } from 'zod'
import { register } from '@/lib/auth'

import {
  Select,
  SelectTrigger,
  SelectContent,
  SelectValue,
  SelectGroup,
  SelectItem,
} from '@/components/ui/select'
import { Label } from '@/components/ui/label'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'

import {
  AlertDialog,
  AlertDialogContent,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogAction,
} from '@/components/ui/alert-dialog'
import { Icon } from '@iconify/vue'

const name = ref('')
const email = ref('')
const password = ref('')
const role = ref('')
const moduleName = ref('')
const showPassword = ref(false);
const loading = ref(false)

// dialogs
const showError = ref(false)
const errorMessage = ref('')
const showSuccess = ref(false)
const successMessage = ref('')

const router = useRouter()

const roleItems: string[] = ['Manager', 'Staff']
const moduleItems: string[] = ['PPIC', 'Production']

// validation schema
const registerSchema = z.object({
  name: z.string().min(2, 'Nama minimal 2 karakter'),
  email: z.string().email('Email tidak valid'),
  password: z.string().min(6, 'Password minimal 6 karakter'),
  role: z.string().nonempty('Pilih jabatan'),
  module: z.string().nonempty('Pilih modul'),
})

async function onSubmit() {
  const result = registerSchema.safeParse({
    name: name.value,
    email: email.value,
    password: password.value,
    role: role.value,
    module: moduleName.value,
  })

  if (!result.success) {
    errorMessage.value = result.error.issues.map((i) => i.message).join(', ')
    showError.value = true
    return
  }

  try {
    loading.value = true
    const data = await register({
      username: name.value,
      email: email.value,
      password: password.value,
      role_name: role.value,
      module_name: moduleName.value,
    })

    // if backend sends a message, show success dialog
    successMessage.value = data.message ?? 'Registrasi berhasil, silakan login'
    showSuccess.value = true
  } catch (err: any) {
    errorMessage.value = err.message ?? 'Registrasi gagal'
    showError.value = true
  } finally {
    loading.value = false
  }
}

// handler when clicking OK in success dialog
function handleSuccessClose() {
  showSuccess.value = false
  router.replace('/login')
}
</script>

<template>
  <main class="w-full h-screen bg-white sm:bg-slate-200 flex justify-center items-center">
    <div
      class="w-full max-w-md min-h-70 bg-white mx-auto flex flex-col px-4 py-6 rounded-xl gap-6 items-center"
    >
      <form class="flex flex-col gap-6 w-full" @submit.prevent="onSubmit">
        <h1 class="font-extrabold text-2xl text-center">Elitech Vision</h1>

        <div class="flex flex-col gap-2 w-full">
          <Label for="name">Name</Label>
          <Input id="name" v-model="name" type="text" placeholder="Your Name" />
        </div>
        <div class="flex flex-col gap-2 w-full">
          <Label for="email">Email</Label>
          <Input id="email" v-model="email" type="email" placeholder="Your Email" />
        </div>
        <div class="flex flex-col gap-2 w-full">
          <Label>Password</Label>
          <div class="relative">
              <Input v-model="password" :type="!showPassword ? 'password' : 'text'" placeholder="Your Password" />
                <div class="absolute top-1/2 -translate-y-1/2 right-2" @click="showPassword = !showPassword">
                    <Icon icon="gravity-ui:eye" v-if="!showPassword" />
                    <Icon icon="gravity-ui:eye-slash" v-else />
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-2 w-full">
          <Label>Jabatan</Label>
          <Select v-model="role">
            <SelectTrigger class="w-full">
              <SelectValue placeholder="Pilih Jabatan" />
            </SelectTrigger>
            <SelectContent>
              <SelectGroup>
                <SelectItem v-for="item in roleItems" :key="item" :value="item">
                  {{ item }}
                </SelectItem>
              </SelectGroup>
            </SelectContent>
          </Select>
        </div>
        <div class="flex flex-col gap-2 w-full">
          <Label>Modul</Label>
          <Select v-model="moduleName">
            <SelectTrigger class="w-full">
              <SelectValue placeholder="Pilih Modul" />
            </SelectTrigger>
            <SelectContent>
              <SelectGroup>
                <SelectItem v-for="item in moduleItems" :key="item" :value="item">
                  {{ item }}
                </SelectItem>
              </SelectGroup>
            </SelectContent>
          </Select>
        </div>
        <Button class="w-full" type="submit" :disabled="loading">
          {{ loading ? 'Mendaftarkan…' : 'Daftar' }}
        </Button>
      </form>

      <p class="flex gap-2">
        <span>Sudah memiliki akun?</span>
        <RouterLink
          class="text-blue-600 hover:text-blue-600/80 underline cursor-pointer"
          to="/login"
        >
          Login
        </RouterLink>
      </p>
    </div>

    <!-- Error Dialog -->
    <AlertDialog :open="showError" @update:open="showError = $event">
      <AlertDialogContent>
        <AlertDialogHeader>
          <AlertDialogTitle>Registrasi Gagal</AlertDialogTitle>
          <AlertDialogDescription>{{ errorMessage }}</AlertDialogDescription>
        </AlertDialogHeader>
        <AlertDialogFooter>
          <AlertDialogAction @click="showError = false">OK</AlertDialogAction>
        </AlertDialogFooter>
      </AlertDialogContent>
    </AlertDialog>

    <!-- Success Dialog -->
    <AlertDialog :open="showSuccess" @update:open="showSuccess = $event">
      <AlertDialogContent>
        <AlertDialogHeader>
          <AlertDialogTitle>Registrasi Berhasil</AlertDialogTitle>
          <AlertDialogDescription>{{ successMessage }}</AlertDialogDescription>
        </AlertDialogHeader>
        <AlertDialogFooter>
          <AlertDialogAction @click="handleSuccessClose">OK</AlertDialogAction>
        </AlertDialogFooter>
      </AlertDialogContent>
    </AlertDialog>
  </main>
</template>
