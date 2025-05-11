<template>
    <Navbar/>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="text-center m-4">
            <h1 class="font-bold text-xl mb-2">Lista de Anuncis</h1>
            <button @click="Volver" class="bg-gray-400 py-2 px-4 rounded-lg">Volver</button>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full table-fixed">
                <thead>
                    <tr class="bg-gray-400">
                        <th class="text-left border border-black p-2">Name</th>
                        <th class="text-left border border-black p-2">Categoria</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-left border border-black p-2">{{ anunci.titol }}</td>
                        <td class="text-left border border-black p-2">{{ anunci.category.name }}</td>
                        
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import {ref,defineProps, computed, onMounted, onUnmounted} from 'vue';
import axios from 'axios';
import Navbar from '@/components/Navbar.vue';

const props = defineProps({
    anunci: Array
});

const anunci = ref(props.anunci);

function Volver(){
    router.visit('/anunci')
}

// function Delete(id){
//     router.delete(route('anunci.destroy', id))
// }

function Delete(id) {
  router.delete(route('anunci.destroy', id), {
    preserveScroll: true,
    onSuccess: () => {
      anunci.value = anunci.value.filter(anunci => anunci.id !== id);
    }
  });
}
</script>