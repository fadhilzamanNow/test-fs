<script setup lang="ts">
import { Table, TableHeader, TableHead, TableRow, TableBody, TableCell } from '@/components/ui/table';
import { Input } from '@/components/ui/input';
import { Pagination, PaginationContent, PaginationItem, PaginationPrevious, PaginationNext } from '@/components/ui/pagination';
import { Icon } from '@iconify/vue';
import { productData } from '@/lib/utils';
import ProductDetail from '../dialog/ProductDetail.vue';
import ProductUpdate from '../dialog/ProductUpdate.vue';
import ProductDelete from '../dialog/ProductDelete.vue';



defineProps<{title : string}>()
</script>

<template>
    <div class="h-full flex flex-col gap-4">
        <div class="flex justify-start w-full  p-4 px-10 border-b-gray-200 border-b ">
            <h1 class="text-2xl font-semibold">
                {{ title }}
            </h1>
        </div>
    <div class="px-10 flex flex-col  gap-10  flex-1">
    <div class="flex justify-between gap-2">
        <div class="relative w-max ">
            <Input :placeholder="`Cari ` + title" class="max-w-80" />
            <Icon icon="mdi:magnify" class=" absolute text-black/20 top-1/2 -translate-y-1/2 right-2 text-xl" />
        </div>
        <slot name="create"></slot>
    </div>
      <div class="flex-1 py-4 flex flex-col justify-between">
        <Table>
            <TableHeader>
                <TableRow>
                    <slot name="tablehead"></slot>
                </TableRow>
            </TableHeader>
            <TableBody>
                <slot name="tablebody"></slot>
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
    </div>
</template>

