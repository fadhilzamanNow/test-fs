<script setup lang="ts">
import { ItemTypes } from '@/lib/utils';
import { Icon } from '@iconify/vue';
import SidebarItem from './SidebarItem.vue';
import { inject, toRef, watchEffect } from 'vue';
import { useUser } from '@/store/user';



const expand = toRef(inject("expand"))
const sidebarItemList : ItemTypes[] = [
    {label : "Produk", icon : Icon, name : "lucide:boxes", mode : "product", module : "PPIC" },
    {label : "Rencana Produksi", icon : Icon, name : "fa7-regular:folder-closed", mode : "product-plan", module : "PPIC"},
    {label : "Rencana Log", icon : Icon, name : "ic:round-history", mode : "plan-log", module : "PPIC"},
     {label : "Order", icon : Icon, name : "lets-icons:order", mode : "orders", module : "Production"},
    {label : "Order Log", icon : Icon, name : "ic:outline-history", mode : "order-log", module : "Production"},
];

const miniExpand = toRef(inject("miniExpand"))
const userInfo = useUser().user.value

</script>

<template>
    <aside :class="['fixed bg-white h-screen z-100 block sm:hidden transition-all', miniExpand ? 'w-3/4 visible opacity-100' : 'w-0 invisible opacity-0']">
          <nav class="h-full flex flex-col bg-white border-r shadow-sm">
                <ul class="flex-1 px-3">
                     <li  v-for="(item,i) in sidebarItemList" :key="i" >
                            <SidebarItem :label="item.label" :icon="item.icon" :name="item.name" :mode="item.mode" v-if="item.module === userInfo.module" />
                        </li>
                </ul>
                <div :class="['transition-all overflow-hidden ', miniExpand ? 'w-52 pl-0 ' : 'w-0 ']">
                        <h1 class="font-bold text-xl px-3">{{ userInfo.module }}</h1>
                        <h1 class="font-semibold text-lg px-3">{{ userInfo.role }}</h1>
                </div>
            </nav>
    </aside>
</template>