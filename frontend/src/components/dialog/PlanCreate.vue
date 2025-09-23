<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { z } from 'zod'
import { Input } from '../ui/input'
import { Label } from '../ui/label'
import DialogCreateTemplate from './DialogCreateTemplate.vue'
import { AlertDialogAction } from '@/components/ui/alert-dialog'

import { startLoading, stopLoading } from '@/store/loading'

// shadcn-vue select
import {
  Select,
  SelectTrigger,
  SelectContent,
  SelectItem,
  SelectGroup,
  SelectValue,
} from '@/components/ui/select'
import { getAllProducts } from '@/lib/product'
import { createPlan } from '@/lib/plan'

// state
const planName = ref('')
const productId = ref('')
const quantity = ref<number | null>(null)
const products = ref<any[]>([])
const errorMessage = ref<string | null>(null)

const emit = defineEmits<{ (e: 'created'): void }>()

// Zod schema
const planSchema = z.object({
  plan_name: z.string().min(2, 'Nama rencana minimal 2 karakter'),
  product_id: z.string().min(1, 'Produk harus dipilih'),
  quantity: z.number().min(1, 'Jumlah minimal 1'),
})

// fetch products for dropdown
onMounted(async () => {
  try {
    const data = await getAllProducts(100, 1)
    products.value = data.data
  } catch (err) {
    console.error(err)
  }
})

async function handleCreate() {
  const result = planSchema.safeParse({
    plan_name: planName.value,
    product_id: productId.value,
    quantity: quantity.value,
  })

  if (!result.success) {
    errorMessage.value = result.error.issues.map(i => i.message).join(', ')
    return
  }

  try {
    startLoading()
    errorMessage.value = null

    await createPlan({
      plan_name: planName.value,
      product_id: productId.value,
      quantity: quantity.value!,
    })

    // reset form
    planName.value = ''
    productId.value = ''
    quantity.value = null

    emit('created')
  } catch (err: any) {
    errorMessage.value = err.message ?? 'Gagal membuat rencana produksi'
  } finally {
    stopLoading()
  }
}
</script>

<template>
  <DialogCreateTemplate title="Rencana Produksi">
    <template #content>
      <form class="flex flex-col gap-4 my-4" @submit.prevent>
        <!-- plan name -->
        <div class="flex flex-col gap-2">
          <Label>Nama Rencana:</Label>
          <Input v-model="planName" placeholder="Masukkan nama rencana" />
        </div>

        <!-- product select (shadcn-vue) -->
        <div class="flex flex-col gap-2">
          <Label>Pilih Produk:</Label>
          <Select v-model="productId">
            <SelectTrigger class="w-full">
              <SelectValue placeholder="Pilih Produk" />
            </SelectTrigger>
            <SelectContent>
              <SelectGroup>
                <SelectItem
                  v-for="p in products"
                  :key="p.id"
                  :value="p.id"
                >
                  {{ p.name }}
                </SelectItem>
              </SelectGroup>
            </SelectContent>
          </Select>
        </div>

        <!-- quantity -->
        <div class="flex flex-col gap-2">
          <Label>Jumlah:</Label>
          <Input
            v-model.number="quantity"
            type="number"
            min="1"
            placeholder="Masukkan jumlah"
          />
        </div>

        <!-- error -->
        <span v-if="errorMessage" class="text-sm text-red-600">{{ errorMessage }}</span>
      </form>
    </template>

    <template #send>
      <AlertDialogAction @click="handleCreate">Tambah</AlertDialogAction>
    </template>
  </DialogCreateTemplate>
</template>
