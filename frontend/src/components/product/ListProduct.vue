<script setup lang="ts">
import { ref, watchEffect } from 'vue'
import ContentBox from '../content/ContentBox.vue'
import {
  Table,
  TableHeader,
  TableHead,
  TableRow,
  TableBody,
  TableCell,
} from '@/components/ui/table'
import { getAllProducts } from '@/lib/product'
import ProductDetail from '../dialog/ProductDetail.vue'
import ProductUpdate from '../dialog/ProductUpdate.vue'
import ProductDelete from '../dialog/ProductDelete.vue'
import ProductCreate from '../dialog/ProductCreate.vue'
import { startLoading, stopLoading } from '@/store/loading'
import { useUser } from '@/store/user';
const userInfo = useUser().user.value
const rows = ref<any[]>([])
const total = ref(7)
const error = ref<string | null>(null)

const search = ref('')
const page = ref(1)
const perPage = ref(7)

async function fetchProducts() {
  try {
    startLoading();
    error.value = null
    const data = await getAllProducts(perPage.value, page.value, search.value)
    rows.value =  rows.value = data.data.map((item: any, index: number) => ({
      ...item,
      number: (page.value - 1) * perPage.value + index + 1,
    }))      // adjust to match your backend response
    total.value = data.total
  } catch (err: any) {
    error.value = err.message
  } finally {
    stopLoading();
  }
}

watchEffect(() => {
  fetchProducts()
})
</script>

<template>
        <ContentBox     title="Produk"
    :search="search"
    :page="page"
    :items-per-page="perPage"
    :total="total"
    @update:search="(q) => { search = q; page = 1 }"
    @update:page="page = $event">
        <template #create>
                <ProductCreate @created="fetchProducts"/>
        </template>
          <template #tablehead>
                <TableHead class="font-bold max-w-max">No</TableHead>
                <TableHead class="font-bold max-w-max">Nama</TableHead>
                <TableHead class="font-bold max-w-max">Aksi</TableHead>
          </template>

          <template #tablebody>
                 <TableRow v-for="item in rows" :key="item.id" >
                    <TableCell>{{ item.number }}</TableCell>
                    <TableCell>{{ item.name }}</TableCell>
                    <TableCell class="flex gap-2">
                            <ProductDetail  :product="item" />
                            <ProductUpdate v-if="userInfo.role === 'Manager'" :product="item" @updated="fetchProducts" />
                            <ProductDelete v-if="userInfo.role === 'Manager'"" :product="item" @deleted="fetchProducts" />
                    </TableCell>
                </TableRow>
          </template>
        </ContentBox>
</template>