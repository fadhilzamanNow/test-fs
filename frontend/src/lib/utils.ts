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

export type modeType = "product" | "product-plan"  
