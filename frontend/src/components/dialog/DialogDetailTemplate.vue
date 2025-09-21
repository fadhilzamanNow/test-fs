<script setup lang="ts">
import {
  AlertDialog,
  AlertDialogContent,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger,
  AlertDialogCancel,
  AlertDialogDescription,
} from "@/components/ui/alert-dialog"
import { Icon } from "@iconify/vue";



defineProps<{title : string}>()
</script>

<template>
  <AlertDialog>
    <AlertDialogTrigger as-child>
         <div class="px-2 py-1 border border-green-500  text-2xl  text-green-500 hover:text-green-500/60 hover:border-green-500/60 flex justify-center items-center rounded-md cursor-pointer gap-1">
                    <Icon icon="famicons:eye" />
                    <span class="hidden sm:block text-xs font-medium">Lihat</span>
        </div>
    </AlertDialogTrigger>
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle>
          Detail {{ title }}
        </AlertDialogTitle>
        <AlertDialogDescription>
          <slot name="content"></slot>
        </AlertDialogDescription>
      </AlertDialogHeader>
      <AlertDialogFooter>
          <AlertDialogCancel>Tutup</AlertDialogCancel>
      </AlertDialogFooter>
    </AlertDialogContent>
  </AlertDialog>
</template>