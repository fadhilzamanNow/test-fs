<script setup lang="ts">
import { TableCell, TableHead, TableRow } from '@/components/ui/table';
import ContentBox from '../content/ContentBox.vue';
import { RencanaProduksi, rencanaProduksiData, rencanaProduksiHead } from '@/lib/dummy';
import { ref, watch, watchEffect } from 'vue';

import { parseISO, format } from 'date-fns';
import StatusButton from '../button/StatusButton.vue';

const rencanaData = ref<RencanaProduksi[]>([])

watchEffect(() => {
        const response = rencanaProduksiData
        rencanaData.value = response.map((v,i) => {
              return {...v, due_date : format(parseISO(v.due_date),"dd-MM-yyyy")}
        })
})
</script>

<template>
      <ContentBox title="Rencana Produksi">
        <template #create>
                <ProductCreate />
        </template>
          <template #tablehead>
                <TableHead v-for="(item,i) in rencanaProduksiHead" :key="i" :class="['font-bold max-w-max']">{{ item }}</TableHead>
                <TableHead>Aksi</TableHead>
          </template>

          <template #tablebody>
                 <TableRow v-for="item in rencanaData" :key="item.plan_no" >
                    <TableCell>{{ item.plan_no }}</TableCell>
                    <TableCell>{{ item.product }}</TableCell>
                    <TableCell>{{ item.quantity }}</TableCell>
                    <TableCell>{{ item.due_date }}</TableCell>
                    <TableCell><StatusButton :status="item.status" /></TableCell>
                    <TableCell></TableCell>
                </TableRow>
          </template>
        </ContentBox>
</template>