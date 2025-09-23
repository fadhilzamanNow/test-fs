<script setup lang="ts">
import { format, parseISO } from 'date-fns'
import { Label } from '@/components/ui/label'
import DialogDetailTemplate from './DialogDetailTemplate.vue'

export type OrderStatus = 'waiting' | 'in_progress' | 'done'

export interface ProductRef {
  id: string
  name: string
  created_at?: string
}

export interface PlanRef {
  id: string
  plan_name: string
}

export interface Order {
  id: string
  order_no: string
  plan_id: string
  quantity: number
  status: OrderStatus
  created_at: string
  // expansions
  plan?: PlanRef
  product?: ProductRef
  // optional metadata
  created_by?: string
  number?: number
}

const props = defineProps<{ order: Order }>()
</script>

<template>
  <DialogDetailTemplate title="Detail Order">
    <template #content>
      <div class="flex flex-col gap-4 my-4">

    

        <div class="flex flex-col gap-1">
          <Label class="font-semibold">Rencana:</Label>
          <span>{{ props.order.plan?.plan_name ?? '-' }}</span>
        </div>

      

        <div class="flex flex-col gap-1">
          <Label class="font-semibold">Jumlah:</Label>
          <span>{{ props.order.quantity }}</span>
        </div>

        <div class="flex flex-col gap-1">
          <Label class="font-semibold">Status:</Label>
          <span class="capitalize">{{ props.order.status.replace('_',' ') }}</span>
        </div>

        <div class="flex flex-col gap-1" v-if="props.order.created_by">
          <Label class="font-semibold">Penanggung Jawab:</Label>
          <span class="capitalize">{{ props.order.created_by }}</span>
        </div>

        <div class="flex flex-col gap-1">
          <Label class="font-semibold">Dibuat pada:</Label>
          <span>
            {{ props.order.created_at ? format(parseISO(props.order.created_at), 'MMMM do, yyyy') : '-' }}
          </span>
        </div>
      </div>
    </template>
  </DialogDetailTemplate>
</template>
