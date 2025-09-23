import type { ClassValue } from "clsx"
import { clsx } from "clsx"
import { twMerge } from "tailwind-merge"
import type { Component } from "vue"

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs))
}

export interface ItemTypes {
    label : string,
    icon : Component,
    name : string,
    mode : modeType
}

export interface productData {
    num : number,
    id : string,
    name : string,
}

export type modeType = "product" | "product-plan"  | "plan-log" | "orders" | "order-log";

// src/types/order.ts
export type OrderStatus = 'waiting' | 'in_progress' | 'done'

export interface Order {
  id: string
  order_no: string
  plan_id: string
  quantity: number
  status: OrderStatus
  created_at: string

  // expanded
  plan: {
    id: string
    plan_name: string
  }
  product: {
    id: string
    name: string
  }

  // client-only helper
  number?: number
}
