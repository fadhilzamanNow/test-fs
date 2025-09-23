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
         <div class="px-2 py-1 border border-red-500 hover:border-red-500/60  text-red-500 hover:text-red-500/60 flex justify-center text-2xl items-center rounded-sm cursor-pointer gap-1 ">
                            <Icon icon="mdi:trash" />
                            <span class="hidden sm:block text-xs">Hapus</span>
        </div>
    </AlertDialogTrigger>
    <AlertDialogContent>
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