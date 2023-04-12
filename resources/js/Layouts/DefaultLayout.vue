<template>
    <Head :title="title" />
    <div class="h-screen justify-between">
        <section class="p-4 bg-gray-800">
            <header class="flex justify-between">
                <div class="flex items-center">
                    <Link href="/">
                        <h1 class="font-bold text-2xl text-yellow-500">Coupon App</h1>
                    </Link>
                    <p v-if="$page.props.auth != null" id="noprint" class="text-sm ml-4 text-yellow-500" >Welcome Back, {{$page.props.auth.user.username}} !</p>
                </div>
                <Nav v-if="$page.props.auth == null" />
                <AuthNav v-else />
            </header>
        </section>

        <section class="p-6">
            <slot />
        </section>

        <Footer />
    </div>
</template>

<script>
import Nav from '../Shared/Nav';
import AuthNav from '../Shared/AuthNav';
import Footer from '../Shared/Footer';
import { Head, Link } from "@inertiajs/inertia-vue3"
import { ref } from "vue";

export default {
    props: { title: String },
    components: { Nav, AuthNav, Head, Link, Footer }
};
</script>