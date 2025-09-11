<script setup lang="ts">
import AppLogoIcon from './AppLogoIcon.vue';
import AppLogoWording from './AppLogoWording.vue';

defineProps<{
    variant?: 'icon' | 'wording';
}>();
</script>

<template>
    <div class="flex items-center justify-center rounded-md p-1">
        <AppLogoIcon v-if="variant === 'icon'" class="size-full" />
        <AppLogoWording v-else class="size-full" />
    </div>
</template>
