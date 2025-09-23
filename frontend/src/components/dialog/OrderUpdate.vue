<!-- src/components/dialog/OrderUpdate.vue -->
<script setup lang="ts">
import { ref, computed } from 'vue'
import { z } from 'zod'
import DialogUpdateTemplate from './DialogUpdateTemplate.vue'
import { Label } from '@/components/ui/label'
import { AlertDialogAction } from '@/components/ui/alert-dialog'
import { startLoading, stopLoading } from '@/store/loading'

import {
  Select,
  SelectTrigger,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectValue,
} from '@/components/ui/select'
import { Order, OrderStatus } from '@/lib/utils'
import { changeOrderStatus } from '@/lib/order'

const props = defineProps<{ order: Order }>()
const emit = defineEmits<{ (e: 'updated'): void }>()

const status = ref<OrderStatus>(props.order.status)
const errorMessage = ref<string | null>(null)

const schema = z.object({
  status: z.enum(['waiting', 'in_progress', 'done']),
})

// Dynamically allowed statuses
const allowedStatuses = computed(() => {
  switch (props.order.status) {
    case 'waiting':
      return ['waiting', 'in_progress']
    case 'in_progress':
      return ['in_progress', 'done']
    case 'done':
      return []
    default:
      return ['waiting']
  }
})

async function handleSave() {
  const parsed = schema.safeParse({ status: status.value })
  if (!parsed.success) {
    errorMessage.value = parsed.error.issues.map(i => i.message).join(', ')
    return
  }

  try {
    startLoading()
    errorMessage.value = null
    await changeOrderStatus(props.order.id, status.value)
    emit('updated')
  } catch (err: any) {
    errorMessage.value = err?.message ?? 'Gagal mengubah status order'
  } finally {
    stopLoading()
  }
}
</script>

<template>
  <DialogUpdateTemplate title="Ubah Status Order">
    <template #content>
      <form class="flex flex-col gap-4 my-4" @submit.prevent>
        <div class="flex flex-col gap-2">
          <Label>Status</Label>
          <Select v-model="status">
            <SelectTrigger class="w-full">
              <SelectValue placeholder="Pilih Status" />
            </SelectTrigger>
            <SelectContent>
              <SelectGroup>
                <SelectItem
                  v-for="s in allowedStatuses"
                  :key="s"
                  :value="s"
                >
                  {{ s.replace('_', ' ') }}
                </SelectItem>
              </SelectGroup>
            </SelectContent>
          </Select>
        </div>
        <span v-if="errorMessage" class="text-sm text-red-600">{{ errorMessage }}</span>
      </form>
    </template>

    <template #send>
      <AlertDialogAction @click="handleSave">Simpan</AlertDialogAction>
    </template>
  </DialogUpdateTemplate>
</template>
