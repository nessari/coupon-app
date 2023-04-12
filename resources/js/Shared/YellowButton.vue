<template>
    <Link :href="href" :class="classes" v-if="as === 'href'">
        <slot></slot>
    </Link>
    <button :class="classes" v-else>
        <slot></slot>
    </button>
</template>

<script>
    import { defineComponent } from "vue";
    import { Link } from '@inertiajs/inertia-vue3'
    export default defineComponent({
        components: {
            Link,
        },
        props: ['active', 'href', 'as'],
        computed: {
            classes() {
                return 'flex text-white bg-yellow-500 border-0 py-2 px-6 focus:outline-none hover:bg-yellow-600 rounded'
            }
        }
    })
</script>