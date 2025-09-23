<script setup lang=ts>
import { productData } from '@/lib/utils';
import DialogDetailTemplate from './DialogDetailTemplate.vue';
import { Label } from '@/components/ui/label';
import { parseISO, format } from 'date-fns';
defineProps<{product : productData}>();

</script>

<template>
    <DialogDetailTemplate title="Product">
        <template #content>
            <form class="flex flex-col gap-4" >
                <div class="flex flex-col gap-2">
                  <Label class="font-semibold text-base">Nama Produk: </Label>
                  <span class="text-sm">{{ product.name }}</span>
                </div>
                <div class="flex flex-col gap-2">
                  <Label class="font-semibold text-base">Dibuat Tanggal: </Label>
                  <span class="text-sm">{{ format(parseISO(product.created_at, {local}), "MMMM do, yyyy", ) }}</span>
                </div>
              </form>
        </template>
    </DialogDetailTemplate>
</template>