<template>
    <Head title="Cart" />
    <div class="w-full mb-auto place-items-center min-h-screen">
        <!-- Order details -->
        <div
            class="flex flex-col justify-center items-center my-4 w-full"
            v-if="$page.props.cartCount <= 0"
        >
            <h2 class="m-6 text-4xl text-gray-700">Your cart is empty!</h2>

            <NavLink
                :href="route('coupons-index')"
                class="text-gray-800 hover:text-yellow-600"
                >Continue shopping</NavLink
            >
        </div>

        <div v-else class="lg:w-2/3 w-full mx-auto mt-8 overflow-auto">
            <table class="table-auto w-full text-left whitespace-no-wrap p-4">
                <caption class="p-4 text-4xl text-gray-800">
                    Cart
                </caption>
                <thead>
                    <tr>
                        <th
                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-200 rounded-tl rounded-bl"
                        >
                            Item
                        </th>
                        <th
                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-200"
                        >
                            Price
                        </th>
                        <th
                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-200"
                        >
                            Quantity
                        </th>
                        <th
                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-200"
                        >
                            Total Price
                        </th>
                        <th
                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-200 rounded-tr rounded-br"
                        >
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in cartItems" :key="index">
                        <td class="p-4">
                            <Link
                                :href="route('coupons-show', item.options.slug)"
                                method="get"
                                class="hover:underline"
                            >
                                {{ item.name }}
                            </Link>
                            
                        </td>
                        <td class="p-4">
                            {{ $filters.formatCurrency(item.price) }}
                        </td>
                        <td class="p-4">
                            <form>
                                <input
                                    v-model="item.qty"
                                    @change="updateCart(item.rowId, item.qty)"
                                    type="number"
                                    placeholder="5"
                                    class="w-8"
                                />
                            </form>
                        </td>
                        <td class="p-4">
                            {{ $filters.formatCurrency(item.qty * item.price) }}
                        </td>
                        <td class="w-10 text-right">
                            <form @submit.prevent="deleteFromCart(item.rowId)">
                                <button>
                                    <Icon
                                        name="trash-can"
                                        class="hover:text-gray-500"
                                    />
                                </button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-4 font-bold">Total Amount</td>
                        <td class="p-4 font-bold"></td>
                        <td class="p-4 font-bold">
                            {{ $page.props.cartCount }}
                        </td>
                        <td class="p-4 font-bold">
                            {{ $filters.formatCurrency(cartTotal) }}
                        </td>
                        <td class="w-20 text-right">
                            <form @submit.prevent="deleteAllFromCart()">
                                <button
                                    as="href"
                                    class="text-sm text-center font-semibold hover:text-gray-700"
                                >
                                    Remove all
                                </button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr>
            <div class="p-2 flex items-center m-8">
            <YellowButton
                :href="route('checkout-index')"
                method="get"
                as="href"
                class="flex mx-auto px-8 text-lg"
                >Checkout</YellowButton
            >
            </div>
        </div>
    </div>
</template>

<script>
import NavLink from "../../Shared/NavLink";
import YellowButton from "../../Shared/YellowButton";

export default {
    props: {
        cartItems: Object,
        cartCount: Number,
        cartTotal: String,
    },
    components: {
        NavLink,
        YellowButton,
    },
    data() {
        return {
            form: this.$inertia.form({
                cartItems: this.cartItems,
                quantity: 0,
            }),
        };
    },
    methods: {
        updateCart(id, quantity) {
            this.form.quantity = quantity;
            this.form.patch(this.route("cart-update", id), {
                preserveScroll: true,
                onSuccess: () => {
                    console.log(this.form);
                },
            });
        },
        deleteFromCart(id) {
            this.form.delete(this.route("cart-delete", id), {
                preserveScroll: true,
                onSuccess: () => {
                    console.log(id);
                },
            });
        },
        deleteAllFromCart() {
            this.form.delete(this.route("cart-delete-all"), {
                preserveScroll: true,
                onSuccess: () => {
                    console.log("All removed.");
                },
            });
        },
    },
};
</script>
