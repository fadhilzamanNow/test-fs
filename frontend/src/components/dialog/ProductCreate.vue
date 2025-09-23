<script setup lang="ts">
import { ref } from 'vue'
import { z } from 'zod'
import { Input } from '../ui/input'
import { Label } from '../ui/label'
import DialogCreateTemplate from './DialogCreateTemplate.vue'
import { AlertDialogAction } from '@/components/ui/alert-dialog'
import { createProduct } from '@/lib/product'
import { startLoading, stopLoading } from '@/store/loading'
// form state
const name = ref('')
const errorMessage = ref<string | null>(null)

const emit = defineEmits<{ (e: 'created'): void }>()

// Zod schema
const productSchema = z.object({
  name: z.string().min(2, 'Nama produk minimal 2 karakter'),
})

async function handleCreate() {
  // validate with Zod
  const result = productSchema.safeParse({ name: name.value })
  if (!result.success) {
    errorMessage.value = result.error.issues.map(i => i.message).join(', ')
    return
  }

  try {
    startLoading()
    errorMessage.value = null

    await createProduct({
      sku: `SKU-${Date.now()}`, // generate SKU
      name: name.value,
      stock: 0,
    })

    name.value = ''
    emit('created') // tell parent to refetch list
  } catch (err: any) {
    errorMessage.value = err.message ?? 'Gagal menambahkan produk'
  } finally {
    stopLoading()
  }
}
</script>

<template>
  <DialogCreateTemplate title="Produk">
    <!-- form content -->
    <template #content>
      <form class="flex flex-col gap-4 my-4" @submit.prevent>
        <div class="flex flex-col gap-2">
          <Label>Nama Produk:</Label>
          <Input v-model="name" placeholder="Masukkan nama Produk" />
          <span v-if="errorMessage" class="text-sm text-red-600">{{ errorMessage }}</span>
        </div>
      </form>
    </template>

    <!-- action button -->
    <template #send>
      <AlertDialogAction @click="handleCreate">Tambah</AlertDialogAction>
    </template>
  </DialogCreateTemplate>
</template>
