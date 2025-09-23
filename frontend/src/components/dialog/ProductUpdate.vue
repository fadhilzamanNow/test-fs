<script setup lang="ts">
import { ref } from 'vue'
import { z } from 'zod'
import DialogUpdateTemplate from './DialogUpdateTemplate.vue'
import { Label } from '@/components/ui/label'
import { Input } from '@/components/ui/input'
import { AlertDialogAction } from '@/components/ui/alert-dialog'
import { updateProduct } from '@/lib/product'
import { startLoading, stopLoading } from '@/store/loading'
import type { productData } from '@/lib/utils'

const props = defineProps<{ product: productData }>()
const emit = defineEmits<{ (e: 'updated'): void }>()

// local state
const name = ref(props.product.name)
const errorMessage = ref<string | null>(null)

// zod schema
const productSchema = z.object({
  name: z.string().min(2, 'Nama produk minimal 2 karakter'),
})

async function handleUpdate() {
  // validate
  const result = productSchema.safeParse({ name: name.value })
  if (!result.success) {
    errorMessage.value = result.error.issues.map(i => i.message).join(', ')
    return
  }

  try {
    startLoading()
    errorMessage.value = null

    await updateProduct(props.product.id, {
      name: name.value,
    })

    emit('updated') // notify parent to refetch
  } catch (err: any) {
    errorMessage.value = err.message ?? 'Gagal memperbarui produk'
  } finally {
    stopLoading()
  }
}
</script>

<template>
  <DialogUpdateTemplate title="Produk">
    <template #content>
      <form class="flex flex-col gap-4 my-4" @submit.prevent>
        <div class="flex flex-col gap-2">
          <Label>Nama Produk:</Label>
          <Input v-model="name" placeholder="Masukkan nama produk" />
          <span v-if="errorMessage" class="text-sm text-red-600">{{ errorMessage }}</span>
        </div>
      </form>
    </template>

    <template #send>
      <AlertDialogAction @click="handleUpdate">Ubah</AlertDialogAction>
    </template>
  </DialogUpdateTemplate>
</template>
