<script setup lang="ts">
import ProductCreate from '../dialog/ProductCreate.vue'
import { ref, watchEffect } from 'vue'
import { TableCell, TableHead, TableRow } from '@/components/ui/table'
import ContentBox from '../content/ContentBox.vue'
import StatusButton from '../button/StatusButton.vue'
import { getAllPlans } from '@/lib/plan'

//@ts-ignore
import PlanCreate from '../dialog/PlanCreate.vue'
import PlanDetail from '../dialog/PlanDetail.vue'
import PlanUpdate from '../dialog/PlanUpdate.vue'
import PlanDelete from '../dialog/PlanDelete.vue'

// state
const rows = ref<any[]>([])
const total = ref(0)
const search = ref('')
const page = ref(1)
const perPage = ref(7)
const error = ref<string | null>(null)
const loading = ref(false)

async function fetchPlans() {
  try {
    loading.value = true
    error.value = null
    const data = await getAllPlans(perPage.value, page.value, search.value)
    // add `number` field for table display
    rows.value = data.data.map((item: any, index: number) => ({
      ...item,
      number: (page.value - 1) * perPage.value + index + 1,
    }))
    total.value = data.total
  } catch (err: any) {
    error.value = err.message
  } finally {
    loading.value = false
  }
}

// refetch when search/page changes
watchEffect(() => {
  fetchPlans()
})
</script>

<template>
  <ContentBox
    title="Rencana Produksi"
    :search="search"
    :page="page"
    :items-per-page="perPage"
    :total="total"
    @update:search="(q) => { search = q; page = 1 }"
    @update:page="page = $event"
  >
    <!-- create button slot -->
    <template #create>
      <PlanCreate @created="fetchPlans" />
     
    </template>

    <!-- table head -->
    <template #tablehead>
      <TableHead>No</TableHead>
      <TableHead>Nama Rencana</TableHead>
      <TableHead>Jatuh Tempo</TableHead>
      <TableHead>Status</TableHead>
      <TableHead>Aksi</TableHead>
    </template>
 
    <!-- table body -->
    <template #tablebody>
      <TableRow v-for="item in rows" :key="item.id">
        <TableCell>{{ item.number }}</TableCell>
        <TableCell>{{ item.plan_name }}</TableCell>
        <TableCell>{{ item.due_date }}</TableCell>
        <TableCell><StatusButton :status="item.status" /></TableCell>
        <TableCell class="flex gap-1">
            <PlanDetail :plan="item"/>
            <PlanUpdate v-if="item.status === 'pending'" :plan="item" @updated="fetchPlans" />
            <PlanDelete :plan="item" @deleted="fetchPlans"/>
          <!-- later: add PlanUpdate & PlanDelete -->
        </TableCell>
      </TableRow>
    </template>
  </ContentBox>
</template>
