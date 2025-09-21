<script setup lang="ts">
import { inject } from 'vue';

const expand = inject("expand")
const miniExpand = inject("miniExpand")
</script>

<template>
     <main v-if="miniExpand" :class="['fixed h-screen  z-75 bg-black/40 transition-all', miniExpand ? 'w-full sm:w-0 overflow-hidden' : 'w-0']" @click="miniExpand = false">

     </main>
</template>