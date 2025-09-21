<script setup lang="ts">
import { inject, toRef, } from 'vue';
import  { ItemTypes, modeType } from '../../lib/utils';
import { RouterLink, useRoute } from 'vue-router';
defineProps<ItemTypes>();
const path = useRoute<'/(private)/[module]'>()
const expand = toRef(inject("expand"))
const miniExpand = toRef(inject("miniExpand"))
</script>


<template>
    <RouterLink :to="mode" :class="['relative flex items-center py-2 px-3 my-1 font-medium cursor-pointer  rounded-md' , !expand && 'justify-center gap-0 group', path.params.module === mode ? 'bg-black text-white' : 'hover:bg-slate-200']"   >
        <component :is="icon" :icon="name" class="size-10 text-xl p-2  transition-colors"/>
        <span :class="['inline-block overflow-hidden transition-all text-nowrap ', expand || miniExpand ? 'w-52' : 'w-0']">{{ label }}</span>
        <span v-if="!expand" class="absolute z-[9999999999999999999999999999] left-25 top-1/2 -translate-y-1/2 bg-black text-white  px-4 size-10 rounded-md flex justify-start items-center w-max invisible opacity-0 transition-all group-hover:visible group-hover:opacity-100">{{ label }}</span>
    </RouterLink>
</template>
