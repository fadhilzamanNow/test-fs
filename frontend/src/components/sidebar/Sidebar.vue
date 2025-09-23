<script setup lang="ts">
import { Icon } from '@iconify/vue';
import { inject, provide, ref, toRef } from 'vue';
import { ItemTypes, modeType } from '@/lib/utils';
import SidebarItem from './SidebarItem.vue';
import { useAuth } from '@/composables/useAuth';
import { useUser } from '@/store/user';

const sidebarItemList : ItemTypes[] = [
    {label : "Produk", icon : Icon, name : "lucide:boxes", mode : "product" },
    {label : "Rencana Produksi", icon : Icon, name : "fa7-regular:folder-closed", mode : "product-plan"},
    {label : "Rencana Log", icon : Icon, name : "ic:round-history", mode : "plan-log"},
     {label : "Order", icon : Icon, name : "lets-icons:order", mode : "orders"},
    {label : "Order Log", icon : Icon, name : "ic:outline-history", mode : "order-log"},
];


const expand = toRef(inject('expand'))
const userInfo = useUser().user.value

</script>

<template>
        <aside class="h-[calc(100vh-4rem)] w-0 invisible sm:min-w-max sm:max-w-max sm:visible sticky top-16 transition-all opacity-0 sm:opacity-100">
                <nav class="h-full flex flex-col bg-white border-r shadow-sm">
                    <ul class="flex-1 px-3">
                        <SidebarItem v-for="(item,i) in sidebarItemList" :key="i" :label="item.label" :icon="item.icon" :name="item.name" :mode="item.mode" />
                    </ul>
                    <div :class="['transition-all overflow-hidden ', expand ? 'w-52 pl-0 ' : 'w-0 ']">
                        <h1 class="font-bold text-xl px-3">{{ userInfo.module }}</h1>
                        <h1 class="font-semibold text-lg px-3">{{ userInfo.role }}</h1>
                    </div>
                </nav>
            <div class="absolute  top-4 -right-1 translate-x-1/2 font-bold text-3xl hover:text-black/60 hover:text-4xl transition-all" @click="expand = !expand">
                <Icon icon="icon-park-solid:left-c" v-if="expand" />
                <Icon icon="icon-park-solid:right-c"  v-else />
            </div>
           
    
        </aside>
</template>