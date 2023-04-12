<template>
    <Head title="Places" />
    <main
        class="px-6 py-8 max-w-6xl mx-auto mt-6 space-y-8 mb-auto min-h-screen"
    >
        <div class="flex-center position-ref full-height">
            <Map
                :partners="partners"
                v-on:gotUserCoords="showNearest"
                v-on:showCoupons="showPicked"
            />
        </div>

        <Link
            :href="route('coupons-index')"
            class="text-gray-800 underline hover:text-yellow-600"
        >
            Back to coupons
        </Link>
        
        <CouponGrid v-if="coupons.length > 0" :coupons="coupons" />
        <h2 v-else class="text-4xl text-gray-700 pt-8">
            No offers found in your area
        </h2>
    </main>
</template>

<script>
import Map from "./Map";
import { watch } from "vue";
import CouponGrid from "../Shared/CouponGrid";

export default {
    components: { CouponGrid, Map },
    props: {
        partners: Array,
        filteredPartners: Array,
        filters: Object,
    },
    computed: {
        coupons() {
            return this.filteredPartners
                .map((f) => {
                    return f.coupons;
                })
                .flat();
        },
        partner() {
            return this.filters.partner;
        },
    },
    methods: {
        showPicked(id) {
            this.$inertia.get(
                "/map",
                { partner: id },
                {
                    preserveState: true,
                    replace: true,
                }
            );
        },
        showNearest(userCoordinates) {
            this.$inertia.get(
                "/map",
                { lat: userCoordinates.lat, lng: userCoordinates.lng },
                {
                    preserveState: true,
                    replace: true,
                }
            );
        },
    },
};
</script>
