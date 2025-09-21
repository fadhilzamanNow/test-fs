<script setup lang="ts">
import { AlertDialog,AlertDialogTrigger,AlertDialogContent, AlertDialogHeader, AlertDialogDescription, AlertDialogTitle, AlertDialogFooter } from '@/components/ui/alert-dialog';

</script>

<template>
        <AlertDialog>
            <AlertDialogTrigger as-child>
                <slot name="trigger">Trigger</slot>
            </AlertDialogTrigger>
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>
                        <slot name="title">Judul</slot>
                    </AlertDialogTitle>
                    <AlertDialogDescription>
                        <slot name="description">Deskripsi</slot>
                    </AlertDialogDescription>
                </AlertDialogHeader>
                    <AlertDialogFooter>
                        <slot name="footer">Footer</slot>
                    </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
</template>