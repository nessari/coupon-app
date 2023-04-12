<template>
    <div id="review-form">
    <Create v-if="allowCreate" :couponId="couponId" v-on:createFinished="handleCreateFinished" />
    <Edit
        v-else-if="uid !== null && isEditing"
        :userReview="userReview"
        v-on:editingFinished="handleEditingFinished"
    />
    <p v-else class="font-semibold ml-2">
        You cant leave a review now.
    </p>
    </div>
    <div
        v-for="(review, index) in reviews.data"
        :key="index"
        class="border border-gray-200 p-6 rounded-xl flex justify-between"
    >
        <article class="flex space-x-4">
            <div class="flex-shrink-0">
                <img
                    src="https://i.pravatar.cc/100?u={{ review.user.id }}"
                    alt=""
                    class="rounded-xl width-60 height-60"
                />
            </div>

            <div>
                <header class="mb-4">
                    <h2 class="font-bold text-gray-900">
                        {{ review.user.name }}
                    </h2>
                    <p class="text-xs">
                        Posted
                        <time>{{
                            $filters.formatDate(review.created_at)
                        }}</time>
                    </p>
                    <div class="flex items-center">
                        <Icon name="star" class="h-5 w-5 text-yellow-500" />
                        <p class="text-gray-600 mr-2 text-sm">
                            ({{ review.rating }}/5) rating
                        </p>
                    </div>
                </header>

                <p class="text-gray-700">
                    {{ review.comment }}
                </p>
            </div>
        </article>
        <div v-if="review.user.id === uid">
            <button @click="editReview(review)">
                <Icon
                    name="pencil-square"
                    class="h-5 w-5 text-gray-800 hover:text-yellow-600 m-1"
                />
            </button>
            <button @click="deleteReview(review)">
                <Icon
                    name="trash-can"
                    class="h-5 w-5 text-gray-800 hover:text-yellow-600 m-1"
                />
            </button>
        </div>
    </div>
    <div v-if="reviews.total > 0">
        <Pagination :links="reviews.links" class="mt-6" />
    </div>
</template>

<script>
import Create from "../Pages/User/Review/Create";
import Edit from "../Pages/User/Review/Edit";
import isEmpty from "lodash/isEmpty";
import Pagination from "./Pagination";

export default {
    props: {
        reviews: Object,
        couponId: Number,
        hasReview: Boolean
    },
    components: { Create, Edit, Pagination },
    data() {
        return {
            uid: this.$page.props.auth ? this.$page.props.auth.user.id : null,
            isEditing: false,
            userHasReview: this.hasReview,
            userReview: {},
        };
    },
    remember: {
        data: ['uid', 'isEditing', 'userHasReview', 'userReview']
    },
    methods: {
        deleteReview(r) {
            this.$inertia.delete(this.route("review-delete", { review: r }), {
                preserveScroll: true,
                onFinish: () => 
                {
                    this.userReview = {}
                    this.userHasReview = false;
                }
            });
        },
        editReview(review) {
            this.isEditing = true;
            this.userReview = review;
            this.scroll("reviews");
            console.log("parentben: " + this.isEditing);
        },
        scroll(id) {
            const element = document.getElementById(id)
                ? document.getElementById(id)
                : {};
            element.scrollIntoView({ behavior: "smooth" });
        },
        handleCreateFinished(review) {
            this.userHasReview = true;
            this.userReview = review;
        },
        handleEditingFinished(review) {
            this.userHasReview = true;
            this.userHasReview = review;
            this.isEditing = false;
        }
    },
    computed: {
        allowCreate() {
            return this.uid !== null && !this.isEditing && !this.userHasReview;
        }
    }
};
</script>
