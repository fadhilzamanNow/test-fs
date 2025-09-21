<script setup lang="ts">
import { inject } from 'vue';

const expand = inject("expand")
</script>

<template>
     <main v-if="expand" :class="['fixed h-screen  z-75 bg-black/40 transition-all', expand ? 'w-full sm:w-0 overflow-hidden' : 'w-0']" @click="expand = false">

     </main>
</template>