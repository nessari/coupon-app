<template>
    <Head title="Wishlist" />
    <div id="menu" class="container mx-auto px-4 lg:pt-24 lg:pb-64 mb-auto min-h-screen">
        <div class="flex flex-wrap text-center justify-center">
            <div class="w-full lg:w-6/12 px-4">
                <h2 v-if="coupons.length > 0" class="text-4xl font-semibold text-gray-900">
                    Your Saved Coupons
                </h2>
                <h2 v-else class="text-4xl font-semibold text-gray-700 mt-8 pt-8">
                    Your did not save any coupons yet
                </h2>
            </div>
        </div>
        <div
            v-for="(coupon, index) in coupons"
            :key="index"
            class="flex flex-wrap mt-12 justify-center"
        >
            <div
                class="grid grid-cols-1 sm:grid-cols-6 md:grid-cols-6 lg:grid-cols-6 xl:grid-cols-6 pb-4 gap-4"
            >
                <div class="col-span-2 sm:col-span-1 xl:col-span-1">
                    <img
                        alt="..."
                        src="https://source.unsplash.com/gUBJ9vSlky0"
                        class="h-24 w-24 rounded mx-auto"
                    />
                </div>

                <div class="col-span-2 sm:col-span-4 xl:col-span-4">
                    <Link
                        :href="route('coupons-show', coupon.slug)"
                        method="get"
                        class="mt-6 hover:underline"
                    >
                        <h3 class="font-semibold text-black">
                            {{ coupon.title }}
                        </h3>
                    </Link>
                    <p class="text-sm text-gray-600">
                        Valid to {{ $filters.formatDate(coupon.expiration) }}
                    </p>
                </div>
                <div
                    class="col-span-2 sm:col-span-1 xl:col-span-1 italic text-right"
                >
                    <p>{{ $filters.formatCurrency(coupon.discounted_price) }}</p>
                    <NavLink
                        :href="route('saved-delete', coupon)"
                        method="delete"
                        as="button"
                        class="mt-6"
                    >
                        <Icon name="trash-bin" />
                    </NavLink>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NavLink from "../../Shared/NavLink";

export default {
    components: { NavLink },
    props: {
        coupons: Array,
    }
};
</script>
