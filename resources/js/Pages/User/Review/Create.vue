<template>
    <div class="border border-gray-200 p-6 rounded-xl">
        <form @submit.prevent="submit">
            <header class="flex items-center">
                <img
                    src="https://i.pravatar.cc/100?u="
                    alt=""
                    width="40"
                    height="40"
                    class="rounded-full"
                />
                <h2 class="ml-4 font-bold text-lg">Leave a review</h2>
            </header>

            <div class="m-6">
                <div class="flex items-center mb-1">
                    <Icon name="star" class="h-5 w-5 text-yellow-500 mr-2" />
                    <input
                        v-model="form.rating"
                        name="rating"
                        id="rating"
                        type="number"
                        min="1"
                        max="5"
                        placeholder="5"
                        class="w-10"
                    />
                </div>
                <div
                    v-if="form.errors.rating"
                    v-text="form.errors.rating"
                    class="text-red-500 text-xs mb-4"
                ></div>
                <textarea
                    v-model="form.comment"
                    name="comment"
                    id="comment"
                    class="w-full text-sm focus:outline-none focus:ring mb-2"
                    rows="5"
                    placeholder="Write your opinion..."
                ></textarea>

                <div
                    v-if="form.errors.comment"
                    v-text="form.errors.comment"
                    class="text-red-500 text-xs mb-4"
                ></div>
            </div>

            <div class="flex justify-end border-t border-gray-200 mt-6 pt-6">
                <GrayButton @click="cancel" type="button" class="m-1">
                    Cancel</GrayButton
                >
                <YellowButton type="submit" :disabled="form.processing" class="m-1"
                    >Post</YellowButton
                >
            </div>
        </form>
    </div>
</template>

<script>
import GrayButton from "../../../Shared/GrayButton";
import YellowButton from "../../../Shared/YellowButton";
import { watch } from "vue";

export default {
    components: { GrayButton, YellowButton },
    props: { couponId: Number },
    data() {
        return {
            form: this.$inertia.form({
                couponId: this.couponId,
                rating: 5,
                comment: "",
            }),
        };
    },
    methods: {
        submit() {
            this.form.post(this.route("review-store-new", this.form), {
                preserveScroll: true,
                preserveState: true,
                onFinish: () => {
                    this.form.reset();
                    this.$emit('createFinished', this.form)
                }
            });
        },
        cancel() {
            this.form.reset();
        }
    },
};
</script>