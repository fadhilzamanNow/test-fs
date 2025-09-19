<script setup lang="ts">
import { Icon } from '@iconify/vue';
import { provide, ref, watchEffect } from 'vue';
import type { ItemTypes, modeType } from '../../lib/utils';
import SidebarItem from './SidebarItem.vue';

const expand = ref<boolean>(true)

const selectedMode = ref<modeType>("prod")

const sidebarItemList : ItemTypes[] = [
    {label : "Product", icon : Icon, name : "lucide:boxes", mode : "prod" },
    {label : "Production Plan", icon : Icon, name : "fa7-regular:folder-closed", mode : "prodplan"}
];

provide("expand", expand)
provide("selected", selectedMode)

const chooseMode = (mode : modeType) =>{
    console.log("run")
    selectedMode.value = mode
}



</script>

<template>
    <div class="sticky top-16 ">
        <aside class="h-[calc(100vh-4rem)] hidden sm:block max-w-max relative ">
            <nav class="h-full flex flex-col bg-white border-r shadow-sm">
                <ul class="flex-1 px-3">
                    <SidebarItem v-for="(item,i) in sidebarItemList" :key="i" :label="item.label" :icon="item.icon" :name="item.name" :mode="item.mode" @choose="chooseMode" />
                </ul>
            </nav>
            <div class="absolute  top-4 right-0 translate-x-1/2 font-bold text-3xl hover:text-black/60 hover:text-4xl transition-all" @click="expand = !expand">
                <Icon icon="icon-park-solid:left-c" v-if="expand" />
                <Icon icon="icon-park-solid:right-c"  v-else />
            </div>
           
    
        </aside>
    </div>
</template>