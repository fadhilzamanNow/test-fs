<!-- src/components/page/OrderList.vue -->
<script setup lang="ts">
import { ref, watchEffect } from 'vue'
import ContentBox from '@/components/content/ContentBox.vue'
import { TableCell, TableHead, TableRow } from '@/components/ui/table'
import { Order } from '@/lib/utils'
import { getAllOrders } from '@/lib/order'
import StatusButton from '../button/StatusButton.vue'
import OrderUpdate from '../dialog/OrderUpdate.vue'




const rows = ref<Order[]>([])
const total = ref(0)
const search = ref('')
const page = ref(1)
const perPage = ref(7)
const error = ref<string | null>(null)

async function fetchOrders() {
  try {
    error.value = null
    const data = await getAllOrders(perPage.value, page.value, search.value)
    rows.value = (data.data as Order[]).map((o, i) => ({
      ...o,
      number: (page.value - 1) * perPage.value + i + 1,
    }))
    total.value = data.total ?? 0
    console.log(rows.value)
  } catch (e: any) {
    error.value = e.message
  }
}
watchEffect(() => { fetchOrders() })
</script>

<template>
  <ContentBox
    title="Daftar Order"
    :search="search"
    :page="page"
    :items-per-page="perPage"
    :total="total"
    @update:search="(q) => { search = q; page = 1 }"
    @update:page="(p) => { page = p }"
  >
    <template #create>
      <OrderCreate @created="fetchOrders" />
    </template>

    <template #tablehead>
      <TableHead>No</TableHead>
      <TableHead>Rencana</TableHead>
      <TableHead>Produk</TableHead>
      <TableHead>Status</TableHead>
      <TableHead>Aksi</TableHead>
    </template>

    <template #tablebody>
      <TableRow v-for="o in rows" :key="o.id">
        <TableCell>{{ o.number }}</TableCell>
        <TableCell>{{ o.plan.plan_name }}</TableCell>
        <TableCell>{{ o.plan.product.name }}</TableCell>
        <TableCell class="capitalize"><StatusButton :status="o.status" /> </TableCell>
        <TableCell class="flex gap-2">
            <OrderUpdate :order="o" v-if="o.status !== 'done'" />
          <OrderStatusUpdate :order="o" @updated="fetchOrders" />
          <OrderDelete :order="o" @deleted="fetchOrders" />
        </TableCell>
      </TableRow>
    </template>
  </ContentBox>
</template>
