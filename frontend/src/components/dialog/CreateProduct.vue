<script setup langs="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import Dialog from './Dialog.vue';
import { AlertDialogAction, AlertDialogCancel } from '@/components/ui/alert-dialog';
</script>

<template>
<Dialog>
    <template #trigger>
        <Button  class="text-md  cursor-pointer hover:bg-black/60">Tambah Produk</Button>
    </template>    
    <template #title>
        <h1>Buat Produk</h1>
    </template>
    <template #description>
        <form class="flex flex-col gap-4 my-4">
            <div class="flex flex-col gap-2">
                <Label>Nama Produk</Label>
                <Input placeholder="Masukkan nama Produk" @enter="(e) => e.preventDefault()"/>
            </div>
        </form>
    </template>
    <template #footer>
        <AlertDialogAction as-child>
            <Button class="border border-gray-400/60 text-gray-400/60 bg-white hover:bg-white/60 hover:text-gray-400/60 hover:border-gray-400/60 cursor-pointer">Cancel</Button>
        </AlertDialogAction>
        <AlertDialogAction @click="(e) => console.log('isi e',e)" as-child>
            <Button class="disabled:cursor-not-allowed cursor-not-allowed"  >Submit</Button>
        </AlertDialogAction>
    </template>
</Dialog>
</template>