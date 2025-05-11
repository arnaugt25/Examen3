<template>
    <Navbar />
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="text-center m-4">
            <h1 class="font-bold text-xl mb-2">Lista de Anuncis</h1>
            <button @click="CrearType" class="bg-gray-400 py-2 px-4 rounded-lg">Crear Anunci</button>
        </div>
        <div>
        <!-- <div class="mb-4">
            <input type="text" v-model="search" placeholder="Buscar por nombre o categoria"
            class="w-full px-4 py-2 border border-black rounded-lg "  aria-label="nombre"/>
        </div> -->
        <select v-model="filters.category" 
                @change="filtrarPorCategoria"
                class="w-full px-4 py-2 md:px-2 md:py-1 border rounded-lg text-base md:text-md mb-4 border-black">
          <option value="">Totes categorías</option>
          <option v-for="category in categories" :key="category" :value="category">{{ category }}</option>
        </select>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full table-fixed">
                <thead>
                    <tr class="bg-gray-400">
                        <th class="text-left border border-black p-2">Name</th>
                        <th class="text-left border border-black p-2">Categoria</th>
                        <th class="text-left border border-black p-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="anunci in anuncis" :key="anunci.id">
                        <td class="text-left border border-black p-2">{{ anunci.titol }}</td>
                        <td class="text-left border border-black p-2">{{ anunci.category.name }}</td>
                        <td class="text-left border border-black p-2">
                            <div class="flex gap-2">
                                <Link :href="route('anunci.show', anunci.id)" class="text-green-600">Ver</Link>
                                <Link :href="route('anunci.edit', anunci.id)" class="text-blue-600">Editar</Link>
                                <button @click="Delete(anunci.id)" class="text-red-600">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-if="anuncis.length === 0" class="mt-4 text-center text-gray-500">
            No se encontraron resultados
        </div>
    </div>

</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, defineProps, computed, onMounted, onUnmounted, watch } from 'vue';
import axios from 'axios';
import Navbar from '@/components/Navbar.vue';

const props = defineProps({
    anuncis: Array
});

const filters = ref({
  search: '',
  category: '',
  date: '',
  titol: ''
});

const anuncis = ref(props.anuncis);
const categories = computed(() => [...new Set(props.anuncis.map(e => e.category?.name).filter(Boolean))]);

function CrearType() {
    router.visit('/anunci/create')
}

function Delete(id) {
  axios.post(`/anunci/${id}`, {
    _method: 'DELETE'
  })
  .then(() => {
    anuncis.value = anuncis.value.filter(item => item.id !== id);
  })
  .catch(() => console.error('Error al eliminar'));
}

function filtrarPorCategoria() {
    if (!filters.value.category) {
        anuncis.value = props.anuncis;
        return;
    }

    axios.get('/filter-anuncis', {
        params: {
            category: filters.value.category
        }
    })
    .then(response => {
        anuncis.value = response.data;
    })
    .catch(error => {
        console.error('Error al filtrar por categoría:', error);
        anuncis.value = props.anuncis.filter(anunci => 
            anunci.category?.name === filters.value.category
        );
    });
}

onMounted(() => {
  anuncis.value = [...props.anuncis];
});
</script>