<script setup lang="ts">
import { format, parseISO } from 'date-fns';
import { Label } from '@/components/ui/label'
import DialogDetailTemplate from './DialogDetailTemplate.vue';

export type PlanStatus = 'pending' | 'approved' | 'rejected';

export interface ProductRef {
  id: string;
  name: string;
  created_at: string; 
}

export interface Plan {
  id: string;
  product_id: string;
  plan_name: string;
  status: PlanStatus;
  quantity: number;
  due_date: string | null;   x
  created_at: string;       
  created_by: string;        
  product: ProductRef;      
  number?: number;      
  note? : string;     
}


const props = defineProps<{ plan: Plan }>()
</script>

<template>
  <DialogDetailTemplate title="Rencana Produksi">
    <template #content>
      <div class="flex flex-col gap-4 my-4">
        <div class="flex flex-col gap-1">
          <Label class="font-semibold">Nama Rencana:</Label>
          <span>{{ props.plan.plan_name }}</span>
        </div>

        <div class="flex flex-col gap-1">
          <Label class="font-semibold">Produk:</Label>
          <span>{{ props.plan.product?.name }}</span>
        </div>

        <div class="flex flex-col gap-1">
          <Label class="font-semibold">Jumlah:</Label>
          <span>{{ props.plan.quantity }}</span>
        </div>

        <div class="flex flex-col gap-1">
          <Label class="font-semibold">Jatuh Tempo:</Label>
          <span>{{ props.plan.due_date ?? '-' }}</span>
        </div>

        <div class="flex flex-col gap-1">
          <Label class="font-semibold">Status:</Label>
          <span class="capitalize">{{ props.plan.status }}</span>
        </div>
        <div class="flex flex-col gap-1" v-if="props.plan.status === 'rejected'">
          <Label class="font-semibold">Alasan Ditolak :</Label>
          <span class="capitalize">{{ props.plan.note }}</span>
        </div>
        <div class="flex flex-col gap-1">
          <Label class="font-semibold">Penanggung Jawab:</Label>
          <span class="capitalize">{{ props.plan.created_by }}</span>
        </div>
         <div class="flex flex-col gap-1">
          <Label class="font-semibold">Dibuat pada:</Label>
          <span>{{ format(parseISO(props.plan.created_at),"MMMM do, yyyy" )}}</span>
        </div>
      </div>
    </template>
  </DialogDetailTemplate>
</template>
