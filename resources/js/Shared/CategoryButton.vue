<template>
    <Link
        :href="href"
        method="get"
        as="button"
        class="px-3 py-1 border border-yellow-500 rounded-full text-yellow-500 text-xs uppercase font-semibold"
        >{{ category.name }}</Link
    >
</template>

<script>

export default {
    props: {
        category: Object,
        href: String
    }
};
</script>
