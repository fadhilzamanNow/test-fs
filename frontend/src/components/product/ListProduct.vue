<script setup lang="ts">
import { productData } from '@/lib/utils';
import ContentBox from '../content/ContentBox.vue';
import { TableHead, TableRow, TableCell } from '@/components/ui/table';
import ProductDetail from '../dialog/ProductDetail.vue';
import ProductUpdate from '../dialog/ProductUpdate.vue';
import ProductDelete from '../dialog/ProductDelete.vue';
import ProductCreate from "../dialog/ProductCreate.vue";

const tableHead = ["No", "Nama Produk", "Aksi"];
const tableData : productData[] = [
    {num : 1, id : "axc", name : "Kotak"},
    {num : 2, id: "asdasda", name : "Sesuatu"},
    {num : 1, id : "axc", name : "Kotak"},
    {num : 2, id: "asdasda", name : "Sesuatu"},
    {num : 1, id : "axc", name : "Kotak"},
    {num : 2, id: "asdasda", name : "Sesuatu"},
    {num : 1, id : "axc", name : "Kotak"},
]

</script>

<template>
        <ContentBox title="Produk">
        <template #create>
                <ProductCreate />
        </template>
          <template #tablehead>
                <TableHead v-for="(item,i) in tableHead" :key="i" :class="['font-bold max-w-max']">{{ item }}</TableHead>
          </template>

          <template #tablebody>
                 <TableRow v-for="item in tableData" :key="item.id" >
                    <TableCell>{{ item.num }}</TableCell>
                    <TableCell>{{ item.name }}</TableCell>
                    <TableCell class="flex gap-2">
                            <ProductDetail :product="item" />
                            <ProductUpdate :product="item" />
                            <ProductDelete :product="item" />
                    </TableCell>
                </TableRow>
          </template>
        </ContentBox>
</template>