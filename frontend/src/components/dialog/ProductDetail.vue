<script setup lang=ts>
import { productData } from '@/lib/utils';
import DialogDetailTemplate from './DialogDetailTemplate.vue';

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
              </form>
        </template>
    </DialogDetailTemplate>
</template>