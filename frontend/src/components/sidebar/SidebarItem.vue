<script setup lang="ts">
import { inject, toRef, } from 'vue';
import type { ItemTypes, modeType } from '../../lib/utils';
defineProps<ItemTypes>();


const expand = toRef(inject("expand"))
const selected = toRef(inject("selected"))

const emit = defineEmits<{
    (e : 'choose', modes : modeType) : void
}>();


</script>


<template>
    <li :class="['relative flex items-center py-2 px-3 my-1 font-medium cursor-pointer  rounded-md' , !expand && 'justify-center gap-0', selected === mode ? 'bg-black text-white' : 'hover:bg-slate-200']" @click="() => emit('choose', mode)"  >
        <component :is="icon" :icon="name" class="size-10 text-xl p-2  transition-colors"/>
        <span :class="['inline-block overflow-hidden transition-all text-nowrap ', expand ? 'w-52' : 'w-0']">{{ label }}</span>
    </li>
</template>
