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
import { Button } from '@/components/ui/button';
import { Icon } from '@iconify/vue';
defineProps<{title : string}>()
</script>

<template>
     <AlertDialog>
    <AlertDialogTrigger>
       <Button  class="text-md  cursor-pointer hover:bg-black/60 flex justify-center items-center gap-2">
            <Icon icon="gridicons:add"/>
            <span class="hidden sm:block text-sm">
                Tambah {{  title }}
            </span>
        </Button>
    </AlertDialogTrigger>
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle>Tambah {{ title }}</AlertDialogTitle>
      </AlertDialogHeader>
      <AlertDialogDescription>
          <slot name="content"></slot>
      </AlertDialogDescription>
      <AlertDialogFooter>
        <AlertDialogCancel>Tutup</AlertDialogCancel>
        <AlertDialogAction>Tambah</AlertDialogAction>
      </AlertDialogFooter>
    </AlertDialogContent>
  </AlertDialog>
</template>