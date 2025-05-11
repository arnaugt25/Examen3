<template>

    <Head title="Crear Cateory" />

    <div class="container mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">Editar Sport</h1>

        <div class="bg-white p-4 border rounded">
            <form @submit.prevent="submit">
                <div class="mb-3">
                    <label for="titol" class="block mb-1">titol:</label>
                    <input
                        type="text"
                        id="titol"
                        v-model="form.titol"
                        class="w-full border p-2 rounded"
                        required
                    />
                </div>

                <div class="mb-3">
                    <label for="descripcio" class="block mb-1">Description:</label>
                    <input
                        type="text"
                        id="descripcio"
                        v-model="form.descripcio"
                        class="w-full border p-2 rounded"
                        required
                    />
                </div>
                <div class="mb-3">
                    <label for="date" class="block mb-1">Data:</label>
                    <input
                        type="date"
                        id="date"
                        v-model="form.date"
                        class="w-full border p-2 rounded"
                        required
                    />
                </div>
                <div class="mb-3">
                    <label for="hora" class="block mb-1">Hora:</label>
                    <input
                        type="time"
                        id="hora"
                        v-model="form.hora"
                        class="w-full border p-2 rounded"
                        required
                    />
                </div>
                <div class="mb-3">
                    <label for="email" class="block mb-1">Email:</label>
                    <input
                        type="email"
                        id="email"
                        v-model="form.email"
                        class="w-full border p-2 rounded"
                        required
                    />
                </div>

                <div class="mb-3">
                    <label for="category" class="block mb-1">Categoria:</label>
                    <select
                        id="category_id"
                        title="Categoria"
                        v-model="form.category_id"
                        class="w-full border p-2 rounded"
                        required
                    >
                        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                    </select>
                </div>

                <div class="flex justify-between mt-4">
                    <Link :href="route('anunci.index')" class="bg-gray-300 px-3 py-1 rounded">
                        Cancelar
                    </Link>
                    <button anunci="submit" class="bg-blue-500 text-white px-3 py-1 rounded">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps, onMounted, ref } from 'vue';

const props = defineProps({
    anunci: Object,
    categories: Array
});

const form = useForm({
    titol: '',
    descripcio:'',
    date:'',
    hora:'',
    email:'',
    category_id: '',
    _method: 'put',
});

onMounted(() => {
    if (props.anunci) {
        form.titol = props.anunci.titol;
        form.descripcio = props.anunci.descripcio;
        form.date = props.anunci.date;
        form.hora = props.anunci.hora;
        form.email = props.anunci.email;
        form.category_id = props.anunci.category_id;
    }
});

function submit() {
    form.post(route('anunci.update', props.anunci.id));
}
</script>