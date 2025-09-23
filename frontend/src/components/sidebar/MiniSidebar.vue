<script setup lang="ts">
import { ItemTypes } from '@/lib/utils';
import { Icon } from '@iconify/vue';
import SidebarItem from './SidebarItem.vue';
import { inject, toRef, watchEffect } from 'vue';
import { useUser } from '@/store/user';



const expand = toRef(inject("expand"))
const sidebarItemList : ItemTypes[] = [
    {label : "Product", icon : Icon, name : "lucide:boxes", mode : "product" },
    {label : "Production Plan", icon : Icon, name : "fa7-regular:folder-closed", mode : "product-plan"}
];

const miniExpand = toRef(inject("miniExpand"))
const userInfo = useUser().user.value

</script>

<template>
    <aside :class="['fixed bg-white h-screen z-100 block sm:hidden transition-all', miniExpand ? 'w-3/4 visible opacity-100' : 'w-0 invisible opacity-0']">
          <nav class="h-full flex flex-col bg-white border-r shadow-sm">
                <ul class="flex-1 px-3">
                    <SidebarItem v-for="(item,i) in sidebarItemList" :key="i" :label="item.label" :icon="item.icon" :name="item.name" :mode="item.mode"  />
                </ul>
                <div :class="['transition-all overflow-hidden ', miniExpand ? 'w-52 pl-0 ' : 'w-0 ']">
                        <h1 class="font-bold text-xl px-3">{{ userInfo.module }}</h1>
                        <h1 class="font-semibold text-lg px-3">{{ userInfo.role }}</h1>
                </div>
            </nav>
    </aside>
</template>