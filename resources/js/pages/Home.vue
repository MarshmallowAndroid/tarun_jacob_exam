<script setup lang="ts">
import AppShell from '@/components/AppShell.vue';
import AppSidebar from '@/components/AppSidebar.vue';
import AppContent from '@/components/AppContent.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';
import { login, register } from '@/routes';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { BreadcrumbItem, Product } from '@/types';
import AppLayoutHome from '@/layouts/AppLayoutHome.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import ProductController from '@/actions/App/Http/Controllers/ProductController';
import { onMounted, ref } from 'vue';
import {
    Pagination,
    PaginationContent,
    PaginationEllipsis,
    PaginationItem,
    PaginationNext,
    PaginationPrevious,
} from "@/components/ui/pagination"
import { Dialog, DialogTrigger } from '@/components/ui/dialog';

const props = defineProps(['products']);
const products = props.products;
</script>

<template>

    <Head title="Home">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <AppLayoutHome>
        <Dialog>
            <DialogTrigger>
                <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                    <div class="grid auto-rows-min gap-4 md:grid-cols-4">
                        <div v-for="product in products.data"
                            class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                            <div class="bg-purple-900 aspect-square">
        
                            </div>
                            <div class="pt-4 pl-4 font-bold">
                                {{ product.name }}
                            </div>
                            <div class="pb-4 pl-4 text-muted-foreground">
                                PHP {{ product.price }}
                            </div>
                        </div>
                    </div>
                </div>
            </DialogTrigger>
        </Dialog>

        <!-- What a pain to figure out... -->
        <Pagination v-model:page="products.current_page" :items-per-page="products.per_page" :total="products.total">
            <PaginationContent>
                <PaginationPrevious v-if="products.prev_page_url === null" />
                <Link v-else :href="products.prev_page_url" class="cursor-default" preserve-scroll>
                    <PaginationPrevious />
                </Link>

                <template v-for="n in (products.last_page)">
                    <Link :href="products.links[n].url" preserve-scroll>
                        <PaginationItem :value="products.links[n].page" :is-active="products.current_page === products.links[n].page">
                            {{ products.links[n].page }}
                        </PaginationItem>
                    </Link>
                </template>

                <PaginationNext v-if="products.next_page_url === null" />
                <Link v-else="products.next_page_url !== null" :href="products.next_page_url" class="cursor-default" preserve-scroll>
                    <PaginationNext />
                </Link>
            </PaginationContent>
        </Pagination>

        <div class="h-8" />
    </AppLayoutHome>
</template>
