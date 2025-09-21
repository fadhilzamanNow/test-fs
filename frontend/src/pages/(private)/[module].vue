<script setup lang="ts">

import MainBox from '@/components/main/MainBox.vue';
import Navbar from '@/components/navbar/Navbar.vue';
import Overlay from '@/components/overlay/Overlay.vue';
import MiniSidebar from '@/components/sidebar/MiniSidebar.vue';
import Sidebar from '@/components/sidebar/Sidebar.vue';
import { modeType } from '@/lib/utils';
import { provide, ref } from 'vue';
import { useRoute } from 'vue-router';

const expand = ref<boolean>(false)
const selectedMode = ref<modeType>("product")
const miniExpand = ref<boolean>(false);
provide("selected", selectedMode)
provide("expand", expand)
provide("miniExpand", miniExpand)

</script>

<template>
  <main class="min-h-screen bg-slate-200 flex flex-col">
    <Navbar class="h-16" />
    <div class="flex-1 flex">
        <Sidebar />
        <MainBox />
    </div>
    <Overlay />
    <MiniSidebar />
  </main>
</template>
