<template>
    <Head title="Order" />
    <main class="px-6 py-8 max-w-6xl mx-auto mt-6 space-y-8 mb-auto min-h-screen">
        <h2 class="text-xl font-semibold text-gray-800 italic">
            Order Details
        </h2>
        <Confirmation :order="order" />
        <div class="pt-6">
        <Link
            :href="route('orders-index')"
            class="text-gray-800 underline hover:text-yellow-600"
        >
            Back to orders
        </Link>
        </div>
    </main>

</template>

<script>
import Confirmation from "../../Shared/Confirmation";

export default {
    components: {Confirmation},
    props: {order: Object}
};
</script>
