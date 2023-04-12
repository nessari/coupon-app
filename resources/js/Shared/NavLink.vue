<template>
    <Link
        class="text-black hover:underline"
        :class="{ 'underline': active }"
        >
        <slot />
    </Link>
</template>

<script>
export default {
    props: {
        active: Boolean
    }
};
</script>