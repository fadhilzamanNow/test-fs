<script setup lang="ts">
import { Icon } from '@iconify/vue';
import { inject } from 'vue';
import DropLogout from './DropLogout.vue';
const expand = inject("expand")
const miniExpand = inject("miniExpand")
</script>

<template>
    <nav class="px-4 sm:px-6 py-4 bg-white border-b-slate-400 w-full flex sticky top-0 z-50 justify-between items-center">
        <div class="flex gap-2 items-center">
            <div class="sm:hidden p-2 hover:bg-slate-200 rounded-md cursor-pointer block">
                <Icon icon="radix-icons:hamburger-menu" class="  size-6 rounded-xl "  @click="miniExpand = true" />
            </div>
            <h1 class="font-extrabold text-2xl">Elitech Vision</h1>
        </div>
        <DropLogout />
    </nav>
</template>