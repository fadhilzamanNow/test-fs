<script setup lang="ts">


import { Input } from '../ui/input';
import { Label } from '../ui/label';
import DialogCreateTemplate from './DialogCreateTemplate.vue';


</script>

<template>
<DialogCreateTemplate title="Produk">
    <template #content>
        <form class="flex flex-col gap-4 my-4">
            <div class="flex flex-col gap-2">
                <Label>Nama Produk:</Label>
                <Input placeholder="Masukkan nama Produk"/>
            </div>
        </form>
    </template>
</DialogCreateTemplate>
</template>