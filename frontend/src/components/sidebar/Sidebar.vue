<script setup lang="ts">
import { Icon } from '@iconify/vue';
import { inject, provide, ref, toRef } from 'vue';
import { ItemTypes, modeType } from '@/lib/utils';
import SidebarItem from './SidebarItem.vue';



const sidebarItemList : ItemTypes[] = [
    {label : "Product", icon : Icon, name : "lucide:boxes", mode : "product" },
    {label : "Production Plan", icon : Icon, name : "fa7-regular:folder-closed", mode : "product-plan"}
];

const expand = toRef(inject('expand'))

</script>

<template>
        <aside class="h-[calc(100vh-4rem)] w-0 invisible sm:min-w-max sm:max-w-max sm:visible sticky top-16 transition-all opacity-0 sm:opacity-100">
                <nav class="h-full flex flex-col bg-white border-r shadow-sm">
                    <ul class="flex-1 px-3">
                        <SidebarItem v-for="(item,i) in sidebarItemList" :key="i" :label="item.label" :icon="item.icon" :name="item.name" :mode="item.mode" />
                    </ul>
                </nav>
            <div class="absolute  top-4 -right-1 translate-x-1/2 font-bold text-3xl hover:text-black/60 hover:text-4xl transition-all" @click="expand = !expand">
                <Icon icon="icon-park-solid:left-c" v-if="expand" />
                <Icon icon="icon-park-solid:right-c"  v-else />
            </div>
           
    
        </aside>
</template>