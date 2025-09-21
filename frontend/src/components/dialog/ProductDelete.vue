<script setup lang="ts">
import { productData } from '@/lib/utils';
import DialogDeleteTemplate from './DialogDeleteTemplate.vue';

defineProps<{product : productData}>()
</script>

<template>
    <DialogDeleteTemplate title="Produk">
        <template #content>
            Apakah anda yakin ingin menghapus {{ product.name }} ?
        </template>
    </DialogDeleteTemplate>
</template>