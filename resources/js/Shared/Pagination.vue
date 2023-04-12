<template>
    <nav>
        <Component
                :is="link.url ? 'Link' : 'span'"
                v-for="link in links"
                :href="link.url"
                v-html="link.label"
                class="bg-white border border-gray-300 text-gray-500 hover:bg-gray-100 hover:text-gray-700 leading-tight py-2 px-3 dark:bg-gray-800"
                :class="{
                    'bg-white border border-gray-300 text-gray-500 hover:bg-gray-100 hover:text-gray-700 leading-tight py-2 px-3 dark:bg-gray-800': ! link.url,
                    'bg-yellow-50 border border-gray-300 text-yellow-600 hover:bg-gray-100 hover:text-yellow-700  py-2 px-3 dark:border-gray-700' : link.active
                }"
            />
	</nav>
</template>

<script>
export default {
    props: {
        links: Array
    }
};
</script>