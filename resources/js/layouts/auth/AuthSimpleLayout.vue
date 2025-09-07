<script setup lang="ts">
import AppLogo from '@/components/AppLogo.vue';
import { home } from '@/routes';
import { Link } from '@inertiajs/vue3';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="flex min-h-svh flex-col items-center justify-center gap-6 bg-background p-6 md:p-10">
        <div class="w-full max-w-2xl">
            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center gap-4">
                    <Link :href="home()" class="flex flex-col items-center gap-2 font-medium">
                        <div class="mb-1 flex h-16 w-96 items-center justify-center rounded-md">
                            <AppLogo variant="wording" class="size-96 fill-current text-[var(--foreground)] dark:text-white" />
                        </div>
                    </Link>
                </div>
                <slot />
            </div>
        </div>
    </div>
</template>
