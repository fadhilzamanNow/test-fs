<script setup lang="ts">
import { Table, TableHeader, TableHead, TableRow, TableBody, TableCell } from '@/components/ui/table';
import { Input } from '@/components/ui/input';
import { Pagination, PaginationContent, PaginationItem, PaginationPrevious, PaginationNext } from '@/components/ui/pagination';
import CreateProduct from '../dialog/CreateProduct.vue';

const tableHead = ["No", "Nama Produk", "Aksi"];

interface productData {
    num : number,
    id : string,
    name : string
}

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
    <div class="px-10 flex flex-col  gap-10  flex-1">
    <div class="flex justify-between gap-2">
            <Input placeholder="Cari Produk" class="max-w-80" />
            <CreateProduct />
    </div>
      <div class="flex-1 py-4 flex flex-col justify-between">
        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead v-for="(item,i) in tableHead" :key="i" :class="['font-bold max-w-max']">{{ item }}</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="item in tableData" :key="item.id" >
                    <TableCell>{{ item.num }}</TableCell>
                    <TableCell>{{ item.name }}</TableCell>
                    <TableCell>action</TableCell>
                </TableRow>
            </TableBody>
        </Table>
        <Pagination v-slot="{page}" :items-per-page="10" :total="30" :default-page="1">
            <PaginationContent v-slot="{items}">
                <PaginationPrevious />
                <template v-for="(item, index) in items" :key="index">
                    <PaginationItem v-if="item.type === 'page'" :value="item.value" :is-active="item.value === page"> {{ item.value}}</PaginationItem>
                </template>
                <PaginationNext />
            </PaginationContent>


        </Pagination>
    </div>
    </div>
</template>

