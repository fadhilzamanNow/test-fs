<script setup lang="ts">
import { useLoading } from '@/store/loading';
const { isLoading } = useLoading()
</script>

<template>
     <div
      v-if="isLoading"
      class="absolute inset-0 z-50 bg-black/20 backdrop-blur-sm flex items-center justify-center"
    >
      <div class="animate-spin h-12 w-12 border-4 border-white border-t-transparent rounded-full"></div>
    </div>
</template>