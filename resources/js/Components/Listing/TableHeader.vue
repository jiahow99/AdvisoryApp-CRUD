<template>
    <th scope="col" className="px-6 py-3">
        {{ title }}
    </th>
</template>

<script setup>
defineProps({
    title: String
})
</script>