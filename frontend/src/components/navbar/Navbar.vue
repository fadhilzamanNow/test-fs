<script setup lang="ts">
import { Icon } from '@iconify/vue';

</script>

<template>
    <nav class="px-4 sm:px-6 py-4 bg-white border-b-slate-400 w-full flex sticky top-0 z-50 justify-between items-center">
        <div class="flex gap-2 items-center">
            <Icon icon="radix-icons:hamburger-menu" class="block sm:hidden size-6" />
            <h1 class="font-extrabold text-2xl">Elitech Vision</h1>
        </div>
         <div class="flex items-center gap-0 sm:gap-2   cursor-pointer group">
                <span class="px-3 py-2 bg-black text-white rounded-md text-xl group-hover:bg-black/70">F</span>
                <span class="text-xl transition-all w-0 overflow-hidden sm:w-max group-hover:text-black/70 group-hover:underline ">Fadhil Isfadhillah</span>
            </div>
        

    </nav>
</template>