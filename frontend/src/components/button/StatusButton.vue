<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { statusRencanaProduksi } from '@/lib/dummy';
defineProps<{status : statusRencanaProduksi}>()
</script>

<template>
    <Button v-if="status === 'approved'" class="border border-green-500 text-green-500 px-4 py-2 flex justify-center items-center bg-transparent min-w-25">
        {{ status }}
    </Button>
    <Button v-else-if="status === 'rejected'" class="border border-red-500 text-red-500 px-4 py-2 flex justify-center items-center bg-transparent min-w-25">
        {{ status }}
    </Button>
     <Button v-else-if="status === 'pending'" class="border border-yellow-500 text-yellow-500 px-4 py-2 flex justify-center items-center bg-transparent min-w-25">
        {{ status }}
    </Button>
    <Button v-else-if="status === 'draft'" class="border border-gray-300 text-gray-300 px-4 py-2 flex justify-center items-center bg-transparent min-w-25">
        {{ status }}
    </Button>
</template>