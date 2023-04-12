<template>
    <Head title="Coupon" />
    <main class="px-6 py-8 max-w-6xl mb-auto mx-auto mt-6 space-y-8">
        <Link
            :href="route('coupons-index')"
            class="text-gray-800 underline hover:text-yellow-600"
        >
            Back to coupons
        </Link>
        <div
            class="flex flex-col justify-center rounded-xl shadow-lg border border-gray-100 pt-8 mb-8"
        >
            <div
                class="relative flex flex-col md:flex-row md:space-x-5 space-y-3 md:space-y-0 p-3 max-w-xs md:max-w-3xl mx-auto"
            >
                <div class="w-full md:w-1/2 bg-white grid">
                    <img
                        src="https://images.pexels.com/photos/4381392/pexels-photo-4381392.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500"
                        alt="tailwind logo"
                        class="rounded-xl object-cover"
                    />
                </div>
                <div
                    class="w-full md:w-2/3 bg-white flex flex-col space-y-2 p-3 relative"
                >
                    <div class="flex justify-between item-center">
                        <div class="text-gray-600 font-medium text-sm hidden md:block">
                            <span
                                    >Valid to: {{expire}}</span
                                >
                        </div>
                        <div class="flex items-center">
                            <Icon name="star" class="h-5 w-5 text-yellow-500" />
                            <p v-if="reviews.total > 0" class="text-gray-600 font-bold text-sm ml-1">
                                {{avgRating}}
                                <span class="text-gray-500 font-normal"
                                    >({{reviews.total}} reviews)</span
                                >
                            </p>
                            <p v-else class="text-sm text-gray-500">(Nobody rated this coupon yet.)</p>
                        </div>
                    </div>
                    <h2 class="font-black text-gray-800 md:text-3xl text-xl">
                        {{ coupon.title }}
                    </h2>
                    <p class="md:text-lg text-gray-700 text-base">
                        {{ coupon.excerpt }}
                    </p>
                    <div class="flex items-center absolute inset-x-0 bottom-0 right-0">
                        <div class="flex flex-col">
                        <span
                            class="title-font font-medium text-2xl text-red-900 line-through"
                            >{{
                                $filters.formatCurrency(coupon.og_price)
                            }}</span
                        >
                        <span
                            class="title-font font-medium text-2xl text-gray-900"
                            >{{
                                $filters.formatCurrency(coupon.discounted_price)
                            }}</span
                        >
                        </div>
                        <form @submit.prevent="submit" class="ml-auto flex items-center">
                            <input v-model="form.quantity" type="number" placeholder="1" class="w-10 m-4" />
                            <YellowButton as="submit">
                                Add to Cart
                            </YellowButton>
                        </form>
                        <button
                            @click="toggleSaved"
                            :class="{ 'text-red-500': isSaved, hidden: !$page.props.auth }"
                            class="rounded-full w-10 h-10 bg-gray-200 p-0 border-0 inline-flex items-center justify-center text-gray-500 hover:text-yellow-500 ml-4"
                        >
                            <Icon name="hearth" />
                        </button>
                    </div>
                </div>
            </div>
            <div
                class="relative flex flex-col md:flex-row md:space-x-5 space-y-3 md:space-y-0 p-3 max-w-xs md:max-w-3xl mx-auto"
            >
                <p class="md:text-lg text-gray-700 text-base">
                    {{ coupon.description }}
                </p>
            </div>
        </div>

        <hr>

        <section id="reviews" class="col-span-8 col-start-5 mt-10 space-y-6">
            <h1 class="text-gray-900 font-bold text-xl ml-2">
                REVIEWS
            </h1>
            <Reviews :reviews="reviews" :couponId="coupon.id" />
        </section>
    </main>
</template>

<script>
import Create from "./User/Review/Create";
import Reviews from "../Shared/Reviews";
import CategoryButton from "../Shared/CategoryButton";
import YellowButton from "../Shared/YellowButton";

export default {
    components: { Create, Reviews, CategoryButton, YellowButton },
    props: {
        coupon: Object,
        saved: Boolean,
        reviews: Object,
        avgRating: Number
    },
    data() {
        return {
            isSaved: this.saved,
            form: this.$inertia.form({
                id: this.coupon.id,
                slug: this.coupon.slug,
                title: this.coupon.title,
                expiration: this.coupon.expiration,
                image: this.coupon.image,
                excerpt: this.coupon.excerpt,
                description: this.coupon.description,
                og_price: this.coupon.og_price,
                price: this.coupon.discounted_price,
                quantity: 1,
            }),
        };
    },
    computed: {
        expire() {
            let expire = this.coupon.expiration;
            expire = expire.split(" ")[0];
            return expire;
        },
    },
    methods: {
        toggleSaved() {
            this.isSaved = !this.isSaved;
            if (this.isSaved) {
                this.$inertia.post(`/saved/${this.coupon.id}`);
            } else {
                this.$inertia.delete(`/saved/delete/${this.coupon.id}`);
            }
        },
        submit() {
            this.form.post(this.route("cart-store", this.form), {
                preserveScroll: true,
                onSuccess: () => {
                    Toast.fire({
                        icon: "success",
                        title: `"${this.form.title}" has been added to your cart!`,
                    });
                },
            });
        },
    }
};
</script>
