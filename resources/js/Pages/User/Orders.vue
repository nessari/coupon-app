<template>
    <Head title="Orders" />
    <div class="mb-auto min-h-screen">
    <div class="container relative mx-auto mt-6">
        <div class="items-center flex flex-wrap">
            <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center">
                <div class="pr-12">
                    <h1 v-if="orders.length > 0" class="text-gray-900 font-semibold text-5xl">
                        You have saved <span class="text-red-800">{{ $filters.formatCurrency(savings) }}</span> so far!
                    </h1>
                    <h2 v-else class="text-4xl font-semibold text-gray-700 mt-8 pt-8">
                        You have no orders yet
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div v-if="orders.length > 0" class="lg:w-2/3 w-full mx-auto mt-8 overflow-auto">
        <table class="table-auto w-full text-left whitespace-no-wrap">
            <caption class="p-4 text-4xl text-gray-800">Your Previous Orders</caption>
            <thead>
                <tr>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-200 rounded-tl rounded-bl"
                    >
                       Date
                    </th>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-200"
                    >
                        Items
                    </th>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-200"
                    >
                        Total
                    </th>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-red-900 text-sm bg-gray-200"
                    >
                        Saved
                    </th>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-200 rounded-tr rounded-br"
                    >
                        
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(order, index) in orders" :key="index">
                    <td class="p-4">{{ $filters.formatDate(order.created_at) }}</td>
                    <td class="p-4">{{ order.coupons.length }}</td>
                    <td class="p-4">{{ $filters.formatCurrency(order.billing_total) }}</td>
                    <td class="p-4 text-yellow-600">{{ $filters.formatCurrency(calc(order.coupons)) }}</td>
                    <td class="w-10 text-right">
                        <Link
                            :href="route('orders-show', order)"
                            class="text-gray-800 underline hover:text-yellow-600"
                        >
                            Details
                        </Link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    </div>
</template>

<script>
export default {
    props: {
        orders: Array
    },
    computed: {
        savings() {
            return this.orders.map((o) => this.calc(o.coupons)).reduce((x, y) => x + y);
        }
    },
    methods: {
        calc(coupons) {
           return coupons
                    .map((c) => c.og_price - c.discounted_price)
                    .reduce((x, y) => x + y);
        }
    },
        
};
</script>
