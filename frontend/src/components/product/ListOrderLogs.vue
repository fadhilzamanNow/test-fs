<!-- src/components/page/OrderLogs.vue -->
<script setup lang="ts">
import { ref, watchEffect } from 'vue'
import ContentBox from '@/components/content/ContentBox.vue'
import { TableCell, TableHead, TableRow } from '@/components/ui/table'
import { getAllOrderLogs } from '@/lib/orderLogs'
import { OrderLog } from '@/lib/utils'
import StatusButton from '../button/StatusButton.vue'
import { format, parseISO } from 'date-fns'

const rows = ref<OrderLog[]>([])
const total = ref(0)
const search = ref('')
const page = ref(1)
const perPage = ref(7)
const error = ref<string | null>(null)

async function fetchLogs() {
  try {
    error.value = null
    const data = await getAllOrderLogs(perPage.value, page.value, search.value)
    rows.value = (data.data as OrderLog[]).map((log, i) => ({
      ...log,
      number: (page.value - 1) * perPage.value + i + 1,
    }))
    total.value = data.total ?? 0
  } catch (e: any) {
    error.value = e.message
  }
}

watchEffect(() => {
  fetchLogs()
})
</script>

<template>
  <ContentBox
    title="Order Logs"
    :search="search"
    :page="page"
    :items-per-page="perPage"
    :total="total"
    @update:search="(q) => { search = q; page = 1 }"
    @update:page="(p) => { page = p }"
  >
    <template #tablehead>
      <TableHead>No</TableHead>
      <TableHead>Rencana</TableHead>
      <TableHead>Dari</TableHead>
      <TableHead>Ke</TableHead>
      <TableHead>Waktu Dibuat</TableHead>
    </template>

    <template #tablebody>
      <TableRow v-for="log in rows" :key="log.id">
        <TableCell>{{ log.number }}</TableCell>
        <TableCell>{{ log.order.plan.plan_name }}</TableCell>
        <TableCell class="capitalize"><StatusButton :status="log.from_status" /></TableCell>
        <TableCell class="capitalize"><StatusButton :status="log.to_status" /></TableCell>
        <TableCell>
            {{ format(parseISO(log.created_at),"MMMM do, yyyy") }}
        </TableCell>
      </TableRow>
    </template>
  </ContentBox>
</template>
