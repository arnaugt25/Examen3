<template>
    <Navbar/>
    <Cookies />

    <div class="text-center text-xl p-4">
        <h1>Benvingut a la meva web d'anuncis (Arnau Garcia)</h1>
    </div>
    <div class="text-center">
        <button @click="LlistaAnunci" class="py-2 px-4 bg-green-500 rounded-lg mb-4">Llista de Anuncis</button>
    </div>

    <div class="text-center">
        <button @click="Profile" class="py-2 px-4 bg-blue-500 rounded-lg">Profile</button>
    </div>
                  
</template>

<script setup>
import Navbar from '@/components/Navbar.vue';
import Cookies from "@/components/Cookies.vue";
import { router } from '@inertiajs/vue3';

function LlistaAnunci(){
    router.visit('/anunci')
}

function Profile(){
    router.visit('/settings')
}



</script>