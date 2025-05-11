<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { ref, computed } from 'vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});
// Añadimos variables para la validación de contraseña
const passwordFocused = ref(false);

const submit = () => {
    // Validamos la contraseña antes de enviar el formulario
    if (!isPasswordValid.value) {
        form.setError('password', 'La contraseña no cumple con los requisitos mínimos');
        return;
    }
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const hasMinLength = computed(() => form.password.length >= 8);
const hasSpace = computed(() => !/[ ]/.test(form.password));

// Verificar si la contraseña cumple con todos los requisitos
const isPasswordValid = computed(() =>
    hasMinLength.value &&
    hasSpace
);
</script>

<template>
    <AuthBase title="Create an account" description="Enter your details below to create your account">

        <Head title="Register" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name">Name</Label>
                    <Input id="name" type="text" required autofocus :tabindex="1" autocomplete="name"
                        v-model="form.name" placeholder="Full name" />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input id="email" type="email" required :tabindex="2" autocomplete="email" v-model="form.email"
                        placeholder="email@example.com" />
                    <InputError :message="form.errors.email" />
                </div>

                <div>
                        <Label for="password" class="block text-sm font-medium text-dark dark:text-white">Password</Label>
                        <Input
                            id="password"
                            type="password"
                            required
                            :tabindex="5"
                            autocomplete="new-password"
                            v-model="form.password"
                            :placeholder="'Password'"
                            class="mt-1 block w-full bg-white dark:bg-[#202938] hover:bg-gray-200 dark:hover:bg-gray-700 text-black dark:text-white font-medium py-2 px-4 rounded-md flex items-center justify-center"  
                            @focus="passwordFocused = true"
                            @blur="passwordFocused = form.password.length > 0"
                        />
                        <InputError :message="form.errors.password" />
                        
                        <!-- Requisitos de contraseña -->
                        <div v-if="passwordFocused" class="mt-2 text-xs space-y-1 bg-gray-50 p-2 rounded-md border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <p class="font-medium text-gray-700 dark:text-white">La contraseña debe contener:</p>
                            <p :class="hasMinLength ? 'text-green-600' : 'text-red-600'">
                                ✓ Mínimo 8 caracteres
                            </p>
                            <p :class="hasSpace ? 'text-green-600' : 'text-red-600'">
                                ✓ Contraseña sense espais en blanc
                            </p>
                        </div>
                    </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation">Confirm password</Label>
                    <Input id="password_confirmation" type="password" required :tabindex="4" autocomplete="new-password"
                        v-model="form.password_confirmation" placeholder="Confirm password" />
                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <Button type="submit" class="mt-2 w-full" tabindex="5" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Create account
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                Already have an account?
                <TextLink :href="route('login')" class="underline underline-offset-4" :tabindex="6">Log in</TextLink>
            </div>
        </form>
    </AuthBase>
</template>
