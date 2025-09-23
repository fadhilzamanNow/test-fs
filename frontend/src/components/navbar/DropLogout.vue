<script setup lang="ts">
import {
  DropdownMenu,
  DropdownMenuTrigger,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
} from '@/components/ui/dropdown-menu'
import { clearUser } from '@/store/user'
import { useRouter } from 'vue-router'
import { useUser } from '@/store/user';
const userInfo = useUser().user.value

const router = useRouter()

function handleLogout() {
  localStorage.removeItem('auth_token')
  clearUser()
  router.push('/login')
}
</script>

<template>
  <DropdownMenu>
    <!-- Trigger -->
    <DropdownMenuTrigger as-child>
      <div class="flex items-center gap-0 sm:gap-2 cursor-pointer group">
        <span
          class="p-3 leading-2 bg-black text-white rounded-md text-xl group-hover:bg-black/70"
        >
          F
        </span>
        <span
          class="text-md transition-all w-0 overflow-hidden sm:w-max group-hover:text-black/70 group-hover:underline"
        >
        {{ userInfo.username }}
        </span>
      </div>
    </DropdownMenuTrigger>

    <!-- Dropdown -->
    <DropdownMenuContent align="end" class="w-40">
      <DropdownMenuLabel>Account</DropdownMenuLabel>
      <DropdownMenuSeparator />
      <DropdownMenuItem @click="handleLogout">
        Logout
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>
