<!-- src/components/page/ListPlanLog.vue -->
<script setup lang="ts">
import { ref, watchEffect } from 'vue'
import ContentBox from '@/components/content/ContentBox.vue'
import { TableCell, TableHead, TableRow } from '@/components/ui/table'
import { getAllPlanLogs } from '@/lib/planLogs'
import { PlanLog } from '@/lib/utils'
import { format, formatISO } from 'date-fns'
import StatusButton from '../button/StatusButton.vue'

const rows = ref<PlanLog[]>([])
const total = ref(0)
const search = ref('')
const page = ref(1)
const perPage = ref(7)
const error = ref<string | null>(null)

async function fetchPlanLogs() {
  try {
    error.value = null
    const res = await getAllPlanLogs(perPage.value, page.value, search.value)
    rows.value = (res.data ?? []).map((log, i) => ({
      ...log,
      number: (page.value - 1) * perPage.value + i + 1,
    }))
    total.value = res.total ?? 0
  } catch (e: any) {
    error.value = e.message ?? 'Gagal memuat log'
  }
}

watchEffect(() => {
  fetchPlanLogs()
})
</script>

<template>
  <ContentBox
    title="Log Rencana Produksi"
    :search="search"
    :page="page"
    :items-per-page="perPage"
    :total="total"
    @update:search="(q) => { search = q; page = 1 }"
    @update:page="(p) => { page = p }"
  >

  <template #create>
    
  </template>
    <!-- Table head -->
    <template #tablehead>
      <TableHead>No</TableHead>
      <TableHead>Rencana</TableHead>
      <TableHead>Dari</TableHead>
      <TableHead>Ke</TableHead>
      <TableHead>Waktu</TableHead>
    </template>

    <!-- Table body -->
    <template #tablebody>
      <TableRow v-for="log in rows" :key="log.id">
        <TableCell>{{ log.number }}</TableCell>
        <TableCell>{{ log.plan?.plan_name ?? '-' }}</TableCell>
        <TableCell ><StatusButton :status="log.from_status" /></TableCell>
        <TableCell ><StatusButton :status="log.to_status" /></TableCell>
        <TableCell>{{ format(formatISO(log.created_at), "MMMM do, yyyy") }}</TableCell>
      </TableRow>
    </template>
  </ContentBox>
</template>
