<template>
    <Link :href="href" className="w-5/12 mx-auto rounded-lg py-3 text-center bg-gray-600 text-white
        hover:bg-gray-700">
        <slot />
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    href: String
})
</script>