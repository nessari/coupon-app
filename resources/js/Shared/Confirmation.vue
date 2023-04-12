<template>
    <div id="confirmation" class="flex flex-col items-center space-y-4 w-full">
        <div class="flex justify-between items-center w-full">
            <div>
                <span class="font-semibold">Your transaction # is: </span>
                <span class="text-sm">{{ order.transaction_id }}</span>
            </div>
            <div>
                <YellowButton
                    id="print"
                    class="text-sm"
                    @click="print"
                >
                    Print
                </YellowButton>
            </div>
        </div>
        <div class="w-full">
            <div
                class="flex justify-between border-t border-b border-black py-2"
            >
                <div class="w-1/3">Item</div>
                <div class="flex justify-between w-1/2">
                    <span class="flex-1 text-center">Quantity</span>
                    <span class="flex-1 text-right">Price</span>
                </div>
            </div>
            <div v-for="(coupon, index) in order.coupons" :key="index">
                <div class="flex justify-between border-b border-black py-2">
                    <div class="flex space-x-4 w-1/2">
                        <Link
                            :href="route('coupons-show', coupon.slug)"
                            class="flex flex-1"
                        >
                            <Link :href="route('coupons-show', coupon.slug)" class="flex flex-col">
                                <span>{{ coupon.title }}</span>
                            </Link>
                        </Link>
                    </div>
                    <div class="flex justify-between w-1/2">
                        <div class="flex-1 text-center">
                            {{ coupon.pivot.quantity }}
                        </div>
                        <span class="flex-1 text-right"
                            >{{ $filters.formatCurrency(coupon.discounted_price) }} ea.</span
                        >
                    </div>
                </div>
            </div>
            <div class="flex justify-between border-t border-b border-black py-2 font-bold">
                <div v-if="order.created_at">
                    <span>Date:</span>
                    <span>{{ $filters.formatDate(order.created_at) }}</span>
                </div>
                <div class="flex flex-col">
                    <div class="flex justify-end space-x-2">
                        <span>Total:</span>
                        <span>{{
                            $filters.formatCurrency(order.billing_total)
                        }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import YellowButton from "./YellowButton";

export default {
    components: {YellowButton},
    props: {order: Object},
    methods: {
        print() {
            window.print();
        },
    },
};
</script>

<style>
@media print {
    p#noprint,footer,a,h1,nav,button#print {
        display: none;
    }
    #confirmation {
        padding: 20px 30px;
    }
}
@page {
    size: auto;
    margin: 0mm;
}
</style>
