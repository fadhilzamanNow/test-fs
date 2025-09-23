<script setup lang="ts">
import { useRoute } from 'vue-router';
import ListProduct from '../product/ListProduct.vue';
import PlanProduct from '../product/PlanProduct.vue';
import { watch, watchEffect } from 'vue';
import ListOrder from '../product/ListOrder.vue';
import ListOrderLogs from '../product/ListOrderLogs.vue';
import ListPlanLog from '../product/ListPlanLog.vue';

const path = useRoute<'/(private)/[module]'>()
import { useUser } from '@/store/user';
const userInfo = useUser().user.value

</script>

<template>
<div class="justify-center items-center mx-auto w-full px-5 lg:px-20 sm:px-10 py-5  transition-all min-h-[calc(100vh-4rem)] ">
        <main class="bg-white rounded-md h-full">

             <ListProduct v-if="path.params.module === 'product' && userInfo.module === 'PPIC'" />
             <PlanProduct v-else-if="path.params.module === 'product-plan' && userInfo.module === 'PPIC'" />
             <ListPlanLog v-else-if="path.params.module === 'plan-log' && userInfo.module === 'PPIC'" />
             <ListOrder v-else-if="path.params.module === 'orders' && userInfo.module === 'Production'"/>
             <ListOrderLogs v-else-if="path.params.module === 'order-log' && userInfo.module === 'Production' "/>

        </main> 
    </div>
</template>