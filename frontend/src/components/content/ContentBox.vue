<script setup lang="ts">
import { ref, watch, computed } from 'vue'
import { Table, TableHeader, TableHead, TableRow, TableBody } from '@/components/ui/table'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import {
  Pagination,
  PaginationContent,
  PaginationItem,
  PaginationPrevious,
  PaginationNext,
} from '@/components/ui/pagination'
import { Icon } from '@iconify/vue'

// ── Props & Emits ─────────────────────────────────────────────
const props = defineProps<{
  title: string
  /** current search text (v-model) */
  search?: string
  /** 1-based current page (v-model) */
  page?: number
  /** total rows from server */
  total?: number
  /** rows per page */
  itemsPerPage?: number
  /** optional custom placeholder */
  placeholder?: string
}>()

const emit = defineEmits<{
  /** v-model for search */
  (e: 'update:search', v: string): void
  /** v-model for page */
  (e: 'update:page', v: number): void
  /** optional fired when user presses Enter in the search */
  (e: 'search', v: string): void
}>()

// ── Local state mirroring props (for nice input UX) ──────────
const localSearch = ref(props.search ?? '')
watch(
  () => props.search,
  v => {
    if (v !== undefined && v !== localSearch.value) localSearch.value = v
  }
)

// debounce emit for typing
let t: number | undefined
function onSearchInput(v: string) {
  localSearch.value = v
  if (t) window.clearTimeout(t)
  t = window.setTimeout(() => emit('update:search', localSearch.value.trim()), 300)
}
function onSearchEnter() {
  emit('update:search', localSearch.value.trim())
  emit('search', localSearch.value.trim())
}

// ── Pagination helpers ───────────────────────────────────────
const page = computed({
  get: () => props.page ?? 1,
  set: v => emit('update:page', v),
})
const itemsPerPage = computed(() => props.itemsPerPage ?? 10)
const total = computed(() => props.total ?? 0)
const totalPages = computed(() =>
  Math.max(1, Math.ceil(total.value / Math.max(1, itemsPerPage.value)))
)

function goPrev() {
  if (page.value > 1) page.value = page.value - 1
}
function goNext() {
  if (page.value < totalPages.value) page.value = page.value + 1
}
function goTo(p: number) {
  if (p !== page.value) page.value = p
}
</script>

<template>
  <div class="h-full flex flex-col gap-4">
    <!-- Header -->
    <div class="flex justify-start w-full p-4 px-10 border-b border-b-gray-200">
      <h1 class="text-2xl font-semibold">
        {{ title }}
      </h1>
    </div>

    <!-- Body -->
    <div class="px-10 flex flex-col gap-10 flex-1">
      <!-- Top bar: search + create slot -->
      <div class="flex justify-between gap-2">
        <div class="relative w-max">
          <Input
            :placeholder="placeholder ?? `Cari ${title}`"
            class="max-w-80 pr-9"
            :value="localSearch"
            @input="onSearchInput(($event.target as HTMLInputElement).value)"
            @keydown.enter.prevent="onSearchEnter"
          />
          <Icon
            icon="mdi:magnify"
            class="absolute text-black/20 top-1/2 -translate-y-4/6 right-2 text-xl pointer-events-none"
          />
        </div>

        <!-- optional right-side actions (e.g., Create button) -->
        <slot name="create" />
      </div>

      <!-- Table area -->
      <div class="flex-1 py-4 flex flex-col justify-between">
        <Table>
          <TableHeader>
            <TableRow>
              <slot name="tablehead" />
            </TableRow>
          </TableHeader>
          <TableBody>
            <slot name="tablebody" />
          </TableBody>
        </Table>

        <!-- Pagination -->
        <Pagination :items-per-page="itemsPerPage" :total="total" :default-page="page">
          <PaginationContent v-slot="{ items }">
            <button type="button" class="inline-flex" @click="goPrev">
              <PaginationPrevious />
            </button>

            <template v-for="(item, idx) in items" :key="idx">
              <PaginationItem
                v-if="item.type === 'page'"
                :value="item.value"
                :is-active="item.value === page"
                @click="goTo(item.value)"
              >
                {{ item.value }}
              </PaginationItem>
            </template>

            <button type="button" class="inline-flex" @click="goNext">
              <PaginationNext />
            </button>
          </PaginationContent>
        </Pagination>
      </div>
    </div>
  </div>
</template>
