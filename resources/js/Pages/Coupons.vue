<template>
    <Head title="Home" />
    <main class="mb-auto place-items-center min-h-screen">
        <div class="container relative mx-auto">
            <div class="items-center flex flex-wrap">
                <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center">
                    <div>
                        <h1 class="text-gray-700 font-semibold text-5xl p-8">
                            Newest coupon offers
                        </h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-8 items-center justify-between flex-auto flex flex-wrap">
            <Dropdown
                v-on:itemSelected="itemSelected"
                :selected="category"
                :items="categories"
            />
            <YellowButton
                :href="route('map-index')"
                as="href"
                class="font-bold text-xl text-gray-700"
                >Check out the nearest offers here</YellowButton
            >
            <div
                class="bg-white p-1 h-10 flex border border-gray-300 rounded-lg items-center"
            >
                <input
                    v-model="search"
                    class="px-2 focus:outline-none text-gray-800"
                    type="search"
                    name="search"
                    placeholder="Search..."
                />
                <div class="w-8 py-1 pl-2 pr-1">
                    <div
                        class="w-6 h-full text-gray-500 outline-none focus:outline-none"
                    >
                        <Icon
                            name="lupe"
                            class="text-gray-500 h-4 w-4 fill-current"
                        />
                    </div>
                </div>
            </div>
        </div>

        <section class="mb-auto p-4">
            <div
                class="flex justify-center my-4 w-full"
                v-if="coupons.total === 0"
            >
                <h2 class="text-4xl text-gray-700">No coupons found!</h2>
            </div>
            <CouponGrid v-else :coupons="coupons.data" />
            <div v-if="coupons.total > 0" class="py-6">
                <Pagination :links="coupons.links" class="mt-6" />
            </div>
        </section>
    </main>
</template>

<script>
import CategoryButton from "../Shared/CategoryButton";
import CouponGrid from "../Shared/CouponGrid";
import Pagination from "../Shared/Pagination";
import Dropdown from "../Shared/Dropdown";
import Search from "../Shared/Search";
import YellowButton from "../Shared/YellowButton";
import { watch } from "vue";
import debounce from "lodash/debounce";

export default {
    components: {
        CategoryButton,
        CouponGrid,
        Pagination,
        Dropdown,
        Search,
        YellowButton,
    },
    props: {
        coupons: Object,
        categories: Array,
        filters: Object,
    },
    data() {
        return {
            search: this.filters.search,
            category: this.filters.category,
        };
    },
    watch: {
        search: debounce(function (value) {
            this.$inertia.get(
                "/coupons",
                { search: value },
                {
                    preserveState: true,
                    replace: true,
                }
            );
        }, 300),
        category(value) {
            this.$inertia.get(
                "/coupons",
                { category: value.slug },
                {
                    preserveState: true,
                    replace: true,
                }
            );
        },
    },
    methods: {
        itemSelected(value) {
            this.category = value;
        },
    },
};
</script>
