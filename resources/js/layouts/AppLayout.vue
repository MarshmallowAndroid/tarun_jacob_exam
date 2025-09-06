<script setup lang="ts">
import AppHeaderLayout from '@/layouts/app/AppHeaderLayout.vue';
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { usePage } from '@inertiajs/vue3';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppSidebarLayout v-if="usePage().props.auth.user.is_admin" :breadcrumbs="breadcrumbs">
        <slot />
    </AppSidebarLayout>
    <AppHeaderLayout v-else :breadcrumbs="breadcrumbs">
        <slot />
    </AppHeaderLayout>
</template>
