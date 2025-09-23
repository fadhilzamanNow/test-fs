<script setup lang="ts">
import DialogDeleteTemplate from './DialogDeleteTemplate.vue'
import { AlertDialogAction } from '@/components/ui/alert-dialog'
import { deleteProduct } from '@/lib/product'
import { startLoading, stopLoading } from '@/store/loading'
import type { productData } from '@/lib/utils'

const props = defineProps<{ product: productData }>()
const emit = defineEmits<{ (e: 'deleted'): void }>()

async function handleDelete() {
  try {
    startLoading()
    await deleteProduct(props.product.id)
    emit('deleted') // tell parent to refetch list
  } catch (err: any) {
    console.error(err)
    alert(err.message ?? 'Gagal menghapus produk')
  } finally {
    stopLoading()
  }
}
</script>

<template>
  <DialogDeleteTemplate title="Produk">
    <template #content>
      Apakah anda yakin ingin menghapus <b>{{ props.product.name }}</b>?
    </template>

    <template #send>
      <AlertDialogAction
        class="bg-red-500 hover:bg-red-500/60"
        @click="handleDelete"
      >
        Hapus
      </AlertDialogAction>
    </template>
  </DialogDeleteTemplate>
</template>
