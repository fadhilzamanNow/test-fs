<script setup lang="ts">
import { Icon } from '@iconify/vue';
import { inject } from 'vue';
const expand = inject("expand")
</script>

<template>
    <nav class="px-4 sm:px-6 py-4 bg-white border-b-slate-400 w-full flex sticky top-0 z-50 justify-between items-center">
        <div class="flex gap-2 items-center">
            <div class="sm:hidden p-2 hover:bg-slate-200 rounded-md cursor-pointer block">
                <Icon icon="radix-icons:hamburger-menu" class="  size-6 rounded-xl "  @click="expand = true" />
            </div>
            <h1 class="font-extrabold text-2xl">Elitech Vision</h1>
        </div>
         <div class="flex items-center gap-0 sm:gap-2   cursor-pointer group">
                <span class="p-3 leading-2 bg-black text-white rounded-md text-xl group-hover:bg-black/70">F</span>
                <span class="text-md transition-all w-0 overflow-hidden sm:w-max group-hover:text-black/70 group-hover:underline ">Fadhil Isfadhillah</span>
            </div>
    </nav>
</template>