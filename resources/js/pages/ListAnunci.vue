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
        <select v-model="filters.category" class="w-full px-4 py-2 md:px-2 md:py-1 border rounded-lg text-base md:text-md mb-4 border-black">
          <option >Totes categorías</option>
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
                    <tr v-for="anunci in filteredEvents" :key="anunci.id">
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
        <div v-if="filteredEvents.length === 0" class="mt-4 text-center text-gray-500">
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
  category: 'Totes categorías',
  date: '',
  titol: ''
});

const anunci = ref(props.anuncis);
const categories = computed(() => [...new Set(props.anuncis.map(e => e.category?.name).filter(Boolean))]);

function CrearType() {
    router.visit('/anunci/create')
}

function Delete(id) {
  axios.post(`/anunci/${id}`, {
    _method: 'DELETE'
  })
  .then(() => {
    filteredEvents.value = filteredEvents.value.filter(item => item.id !== id);
    anunci.value = anunci.value.filter(item => item.id !== id);
  })
  .catch(() => console.error('Error al eliminar'));
}


const filteredEvents = ref([...props.anuncis]);

onMounted(() => {
  filteredEvents.value = [...props.anuncis];
});

watch(() => filters.value.category, (category) => {
  if (!category || category === 'Totes categorías') {
    filteredEvents.value = [...props.anuncis];
  } else {
    axios.get('/anunci')
      .then(() => {
        filteredEvents.value = props.anuncis.filter(anunci =>
          anunci.category && anunci.category.name === category
        );
      })
      .catch(() => {
        filteredEvents.value = props.anuncis.filter(anunci =>
          anunci.category && anunci.category.name === category
        );
      });
  }
});
</script>