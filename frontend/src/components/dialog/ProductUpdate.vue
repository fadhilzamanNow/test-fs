<script setup lang="ts">
import DialogUpdateTemplate from './DialogUpdateTemplate.vue';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { productData } from '@/lib/utils';

defineProps<{product : productData}>()

</script>

<template>
    <DialogUpdateTemplate title="Produk">
        <template #content>
            <form class="flex flex-col gap-2">
                <Label>Nama Produk:</Label>
                <Input :placeholder="product.name" />
            </form>
        </template>
    </DialogUpdateTemplate>
</template>