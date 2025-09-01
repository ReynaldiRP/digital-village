<template>
    <div class="container mx-auto h-screen bg-white px-4 py-8">
        <div class="flex flex-col items-center justify-center rounded-lg p-6 shadow-md" :class="customClass">
            <slot></slot>
        </div>
    </div>
</template>

<script setup lang="ts">
defineProps<{
    customClass?: string;
}>();
</script>

<style scoped></style>
