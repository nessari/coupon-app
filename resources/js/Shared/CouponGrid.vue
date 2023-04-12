<template>
    <div class="grid justify-center md:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-7 my-2">
        <div
            v-for="(coupon, index) in coupons"
            :key="index"
            class="bg-white rounded-lg border shadow-md max-w-xs md:max-w-none overflow-hidden"
        >
            <img
                class="h-56 lg:h-60 w-full object-cover"
                src="/images/illustration-1.jpg"
                alt=""
            />
            <div class="p-3">
                <div class="space-x-2">
                    <CategoryButton :category="coupon.category" />
                </div>
                <h2 class="font-semibold text-xl leading-6 text-gray-700 my-2">
                    {{ coupon.title }}
                </h2>
                <p class="paragraph-normal text-gray-600">
                    {{ coupon.excerpt }}
                </p>

                <div class="flex items-center flex-wrap justify-between">
                    <YellowButton
                        :href="route('coupons-show', coupon.slug)"
                        method="get"
                        as="href"
                        >Read More</YellowButton
                    >
                    <span
                        class="text-primary text-lg text-gray-700 font-bold p-8"
                        >{{
                            $filters.formatCurrency(coupon.discounted_price)
                        }}</span
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CategoryButton from "../Shared/CategoryButton";
import Pagination from "../Shared/Pagination";
import YellowButton from "../Shared/YellowButton";

export default {
    components: { CategoryButton, Pagination, YellowButton },
    props: {
        coupons: Array,
    },
    data() {
        return {
            
        };
    },
};
</script>
