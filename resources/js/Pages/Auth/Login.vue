<template>
    <Head title="Log In" />

    <main class="grid mb-auto place-items-center min-h-screen">
        <section class="bg-white p-8 rounded-xl max-w-md mx-auto border w-full">

            <h1 class="text-3xl mb-6">Log In</h1>

            <form @submit.prevent="submit" class="mt-8 max-w-10 mx-auto">

                <div class="mb-6">
                    <label
                        class="block mb-2 uppercase font-bold text-xs text-gray-700"
                        for="email"
                    >
                        E-mail
                    </label>

                    <input
                        v-model="form.email"
                        class="border p-2 w-full rounded"
                        type="email"
                        name="email"
                        id="email"
                    />
                    <div
                        v-if="form.errors.email"
                        v-text="form.errors.email"
                        class="text-red-500 text-xs mt-1"
                    ></div>
                </div>

                <div class="mb-6">
                    <label
                        class="block mb-2 uppercase font-bold text-xs text-gray-700"
                        for="password"
                    >
                        Password
                    </label>

                    <input
                        v-model="form.password"
                        class="border p-2 w-full rounded"
                        type="password"
                        name="password"
                        id="password"
                    />
                    <div
                        v-if="form.errors.password"
                        v-text="form.errors.password"
                        class="text-red-500 text-xs mt-1"
                    ></div>
                </div>

                <div class="mb-6">
                    <YellowButton
                        type="submit"
                        :disabled="form.processing"
                    >
                        Login
                    </YellowButton>
                </div>
            </form>
        </section>
    </main>
</template>

<script>
import YellowButton from "../../Shared/YellowButton";
export default {
    components: {YellowButton}
}
</script>

<script setup>
import { useForm } from "@inertiajs/inertia-vue3";

let form = useForm({
    email: '',
    password: ''
});

let submit = () => {
    form.post('/login');
};
</script>