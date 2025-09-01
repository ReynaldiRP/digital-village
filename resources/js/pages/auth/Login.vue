<template>
    <div>
        <Authenticate custom-class="gap-8">
            <div class="flex flex-col items-center">
                <h1 class="text-3xl font-bold text-black">Welcome to Digital Village</h1>
                <h4 class="text-base font-medium text-gray-600">Please log in to continue</h4>
            </div>
            <Button icon="pi pi-google" label="Continue with Google" size="small" class="w-sm" />
        </Authenticate>
    </div>
</template>

<script setup lang="ts">
import Authenticate from '@/layouts/auth/Authenticate.vue';
</script>

<style scoped></style>
