<template>
    <div class="flex flex-col items-center relative">
        <div
            class="bg-white p-1 h-10 flex border border-gray-300 rounded-lg items-center"
        >
            <input
                :value="selectedItem.name"
                @click="toggle"
                placeholder="Select a category..."
                class="px-2 appearance-none outline-none text-gray-800"
            />
            <div>
                <button
                    @click="clear"
                    class="cursor-pointer w-6 h-full flex items-center text-gray-400 outline-none focus:outline-none"
                >
                    <Icon name="x" />
                </button>
            </div>
            <div
                class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-gray-200"
            >
                <button
                    @click="toggle"
                    class="cursor-pointer w-6 h-full text-gray-600 outline-none focus:outline-none"
                >
                    <Icon name="chevron-up" />
                </button>
            </div>
        </div>
        <div
            v-if="isVisible"
            v-click-away="close"
            class="absolute shadow top-100 z-40 w-full left-0 rounded-lg max-h-select overflow-y-auto"
        >
            <div class="flex flex-col w-full">
                <div
                    v-for="(item, index) in items"
                    :key="index"
                    @click="onSelect(item)"
                    class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-yellow-100"
                >
                    <div
                        class="flex w-full items-center p-2 pl-2 text-gray-700 border-transparent bg-white border-l-2 relative hover:bg-yellow-500 hover:text-yellow-100 hover:border-yellow-500"
                    >
                        <div class="w-full items-center flex">
                            <div class="mx-2 leading-6">
                                {{ item.name }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mixin as VueClickAway } from "vue3-click-away";
import { ref, watch } from "vue";

export default {
    mixins: [VueClickAway],
    props: {
        items: Array,
    },
    data() {
        return {
            isVisible: false,
            selectedItem: {},
        };
    },
    methods: {
        toggle() {
            this.isVisible = !this.isVisible;
        },
        close() {
            this.isVisible = false;
        },
        onSelect(item) {
            this.$emit("itemSelected", item);
            this.selectedItem = item;
            this.isVisible = false;
        },
        clear() {
            this.$emit("itemSelected", {});
            this.selectedItem = {};
        },
    },
};
</script>

<style>
.top-100 {
    top: 100%;
}
.bottom-100 {
    bottom: 100%;
}
.max-h-select {
    max-height: 300px;
}
</style>
