<script setup lang="ts">
import DialogDeleteTemplate from './DialogDeleteTemplate.vue'
import { AlertDialogAction } from '@/components/ui/alert-dialog'
import { startLoading, stopLoading } from '@/store/loading'
import { deletePlan } from '@/lib/plan';
import { Plan } from './PlanDetail.vue';
const props = defineProps<{ plan: Plan }>()
const emit = defineEmits<{ (e: 'deleted'): void }>()

async function handleDelete() {
  try {
    startLoading()
    await deletePlan(props.plan.id)
    emit('deleted') // notify parent (PlanProduct.vue) to refresh
  } catch (err: any) {
    console.error(err)
    alert(err.message ?? 'Gagal menghapus rencana produksi')
  } finally {
    stopLoading()
  }
}
</script>

<template>
  <DialogDeleteTemplate title="Rencana Produksi">
    <template #content>
      Apakah anda yakin ingin menghapus
      <b>{{ props.plan.plan_name }}</b>?
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
