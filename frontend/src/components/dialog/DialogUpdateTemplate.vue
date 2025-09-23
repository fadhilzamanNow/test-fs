<script setup lang="ts">import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger,
} from '@/components/ui/alert-dialog'
import { Icon } from '@iconify/vue';
defineProps<{title : string}>()
</script>

<template>
     <AlertDialog>
    <AlertDialogTrigger>
        <div class="px-2 py-1 text-yellow-500 hover:text-yellow-500/60 hover:bg-white/40 hover:border-yellow-500/60  border border-yellow-500 flex text-2xl justify-center items-center rounded-md cursor-pointer gap-1">
            <Icon icon="solar:pen-bold" />
            <span class="hidden sm:block text-xs">Edit</span>
        </div>
    </AlertDialogTrigger>
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle>Edit {{ title }}</AlertDialogTitle>
      </AlertDialogHeader>
      <AlertDialogDescription>
          <slot name="content"></slot>
      </AlertDialogDescription>
      <AlertDialogFooter>
        <AlertDialogCancel>Tutup</AlertDialogCancel>
        <slot name="send"></slot>
      </AlertDialogFooter>
    </AlertDialogContent>
  </AlertDialog>
</template>