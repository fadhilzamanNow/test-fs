<!-- src/components/dialog/OrderLogsDetail.vue -->
<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { Table, TableHeader, TableHead, TableRow, TableBody, TableCell } from '@/components/ui/table'
import { AlertDialog, AlertDialogContent, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger } from '@/components/ui/alert-dialog'
import { Button } from '@/components/ui/button'
import { Icon } from '@iconify/vue'
import { getOrderLogsByOrderId } from '@/lib/orderLogs'
import { OrderLog } from '@/lib/utils'

const props = defineProps<{ orderId: string; planName: string }>()
const logs = ref<OrderLog[]>([])
const loading = ref(false)
const error = ref<string | null>(null)

async function fetchLogs() {
  try {
    loading.value = true
    error.value = null
    const data = await getOrderLogsByOrderId(props.orderId)
    logs.value = (data.data as OrderLog[]).map((log, i) => ({
      ...log,
      number: i + 1,
    }))
  } catch (err: any) {
    error.value = err.message
  } finally {
    loading.value = false
  }
}

onMounted(() => { fetchLogs() })
</script>

<template>
  <AlertDialog>
    <AlertDialogTrigger as-child>
      <Button variant="outline" size="sm" class="flex items-center gap-1">
        <Icon icon="mdi:history" class="text-lg" />
        Logs
      </Button>
    </AlertDialogTrigger>
    <AlertDialogContent class="max-w-3xl">
      <AlertDialogHeader>
        <AlertDialogTitle>Riwayat Order ({{ planName }})</AlertDialogTitle>
      </AlertDialogHeader>

      <div v-if="loading" class="p-6 text-center text-slate-500">Memuat log...</div>
      <div v-else-if="error" class="p-6 text-center text-red-600">{{ error }}</div>
      <div v-else>
        <Table>
          <TableHeader>
            <TableRow>
              <TableHead>No</TableHead>
              <TableHead>Dari</TableHead>
              <TableHead>Ke</TableHead>
              <TableHead>Diubah Oleh</TableHead>
              <TableHead>Waktu</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-for="log in logs" :key="log.id">
              <TableCell>{{ log.number }}</TableCell>
              <TableCell class="capitalize">{{ log.from_status }}</TableCell>
              <TableCell class="capitalize">{{ log.to_status }}</TableCell>
              <TableCell>{{ log.changer?.name ?? '-' }}</TableCell>
              <TableCell>{{ new Date(log.created_at).toLocaleString() }}</TableCell>
            </TableRow>
            <TableRow v-if="!logs.length">
              <TableCell colspan="5" class="text-center text-slate-500">
                Belum ada log
              </TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </AlertDialogContent>
  </AlertDialog>
</template>
