<script setup lang="ts">
import { Label } from '../../components/ui/label';
import { Input } from '../../components/ui/input';
import { Button } from '../../components/ui/button';
import { RouterLink } from 'vue-router';
</script>

<template>
    <main class="w-full h-screen bg-slate-200 flex justify-center items-center ">
        <div class="w-full max-w-md min-h-70 bg-white mx-auto flex flex-col px-4 py-6 rounded-xl gap-6 items-center">
            <div class="flex flex-col gap-2 w-full">
                <Label for="email">Email</Label>
                <Input id="email" type="text" placeholder="Your Email" />
            </div>
            <div class="flex flex-col gap-2 w-full">
                <Label>Password</Label>
                <Input type="text" placeholder="Your Password" />
            </div>
            
            <Button class="w-full">Login</Button>
            <p class="flex gap-2 ">
                <span>Apakah anda belum memilik akun?</span>
                <RouterLink class="text-blue-600 hover:text-blue-600/80 underline cursor-pointer" to="/register">Daftar</RouterLink>
            </p>
        </div>
    </main>
</template>