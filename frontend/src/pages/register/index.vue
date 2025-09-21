<script setup lang="ts">

import { RouterLink } from 'vue-router';
import { Select,SelectTrigger,SelectContent, SelectValue,SelectGroup, SelectItem } from '../../components/ui/select';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';

const roleItems : string[] = ["Manager", "Staff"]
const moduleItems : string[] = ["PPIC", "Produksi"]


</script>


<template>
    <main class="w-full h-screen bg-slate-200 flex justify-center items-center ">
        <div class="w-full max-w-md min-h-70 bg-white mx-auto flex flex-col px-4 py-6 rounded-xl gap-6 items-center">
             <div class="flex flex-col gap-2 w-full">
                <Label for="name">Name</Label>
                <Input id="name" type="text" placeholder="Your Name" />
            </div>
            <div class="flex flex-col gap-2 w-full">
                <Label for="email">Email</Label>
                <Input id="email" type="email" placeholder="Your Email" />
            </div>
            <div class="flex flex-col gap-2 w-full">
                <Label>Password</Label>
                <Input type="text" placeholder="Your Password" />
            </div>
            <div class="flex flex-col gap-2 w-full">
                <Label>Jabatan</Label>
                <Select>
                    <SelectTrigger class="w-full">
                        <SelectValue placeholder="Pilih Jabatan"  />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem v-for="item in roleItems" :value="item">
                                {{ item }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
            </div>
             <div class="flex flex-col gap-2 w-full">
                <Label>Modul</Label>
                <Select>
                    <SelectTrigger class="w-full">
                        <SelectValue placeholder="Pilih Modul"  />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem v-for="item in moduleItems" :value="item">
                                {{ item }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
            </div>
            <Button class="w-full">Daftar</Button>
            <p class="flex gap-2 ">
                <span>Sudah memiliki akun?</span>
                <RouterLink class="text-blue-600 hover:text-blue-600/80 underline cursor-pointer" to="/login">Login</RouterLink>
            </p>
        </div>
    </main>
</template>