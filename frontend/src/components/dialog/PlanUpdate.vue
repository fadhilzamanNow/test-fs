<script setup lang="ts">
import { ref } from 'vue'
import { z } from 'zod'
import DialogUpdateTemplate from './DialogUpdateTemplate.vue'
import { Label } from '@/components/ui/label'
import { AlertDialogAction } from '@/components/ui/alert-dialog'
import { changePlanStatus } from '@/lib/plan' // expects (id, status, notes?)
import { startLoading, stopLoading } from '@/store/loading'
import type { Plan, PlanStatus } from './PlanDetail.vue'

import {
  Select,
  SelectTrigger,
  SelectContent,
  SelectItem,
  SelectGroup,
  SelectValue,
} from '@/components/ui/select'

const props = defineProps<{ plan: Plan }>()
const emit = defineEmits<{ (e: 'updated'): void }>()

const status = ref<PlanStatus>(props.plan.status)
const notes = ref<string>('') // only used for rejected
const errorMessage = ref<string | null>(null)

// Require notes when status is rejected
const statusSchema = z.object({
  status: z.enum(['pending', 'approved', 'rejected']),
  notes: z.string().optional(),
}).superRefine((val, ctx) => {
  if (val.status === 'rejected' && (!val.notes || val.notes.trim().length === 0)) {
    ctx.addIssue({
      code: z.ZodIssueCode.custom,
      message: 'Catatan wajib diisi saat status ditolak',
      path: ['notes'],
    })
  }
})

async function handleUpdateStatus() {
  const result = statusSchema.safeParse({ status: status.value, notes: notes.value })
  if (!result.success) {
    errorMessage.value = result.error.issues.map(i => i.message).join(', ')
    return
  }

  try {
    startLoading()
    errorMessage.value = null
    // pass notes only if rejected
    const payloadNotes = status.value === 'rejected' ? notes.value.trim() : undefined
    // @ts-ignore in case your helper overload lacks notes type
    await changePlanStatus(props.plan.id, status.value, payloadNotes)
    emit('updated')
  } catch (err: any) {
    errorMessage.value = err?.message ?? 'Gagal mengubah status'
  } finally {
    stopLoading()
  }
}
</script>

<template>
  <DialogUpdateTemplate title="Ubah Status Rencana">
    <template #content>
      <form class="flex flex-col gap-4 my-4" @submit.prevent>
        <div class="flex flex-col gap-2">
          <Label>Status:</Label>
          <Select v-model="status">
            <SelectTrigger class="w-full">
              <SelectValue placeholder="Pilih Status" />
            </SelectTrigger>
            <SelectContent>
              <SelectGroup>
                <SelectItem value="pending">Pending</SelectItem>
                <SelectItem value="approved">Approved</SelectItem>
                <SelectItem value="rejected">Rejected</SelectItem>
              </SelectGroup>
            </SelectContent>
          </Select>
        </div>

        <!-- Notes only when rejected -->
        <div v-if="status === 'rejected'" class="flex flex-col gap-2">
          <Label>Catatan Penolakan:</Label>
          <textarea
            v-model="notes"
            rows="3"
            class="border rounded-md px-3 py-2 text-sm"
            placeholder="Tuliskan alasan penolakan"
          />
        </div>

        <span v-if="errorMessage" class="text-sm text-red-600">{{ errorMessage }}</span>
      </form>
    </template>

    <template #send>
      <AlertDialogAction @click="handleUpdateStatus">Simpan</AlertDialogAction>
    </template>
  </DialogUpdateTemplate>
</template>
