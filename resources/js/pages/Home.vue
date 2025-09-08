<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayoutHome from '@/layouts/AppLayoutHome.vue';
import {
    Pagination,
    PaginationContent,
    PaginationItem,
    PaginationNext,
    PaginationPrevious,
} from "@/components/ui/pagination"
import { Dialog, DialogTrigger } from '@/components/ui/dialog';
import { Image } from 'lucide-vue-next';
import ProductDialogLayout from '@/layouts/ProductDialogLayout.vue';

const props = defineProps(['products', 'locale']);
const products = props.products;
</script>

<template>

    <Head title="Home">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <AppLayoutHome>
        <div>

        </div>
        <div class="flex h-full flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid gap-4 md:grid-cols-4">
                <template v-for="product in products.data">
                    <Dialog>
                        <DialogTrigger>
                            <div class="overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border
                                            hover:bg-accent/50">
                                <div class="flex bg-accent aspect-square ">
                                    <Image class="size-24 text-primary justify-center" />
                                </div>
                                <div class="grid grid-rows-2 gap-1 m-4 text-left">
                                    <div class="font-bold">
                                        {{ product.name }}
                                    </div>
                                    <div class="text-muted-foreground">
                                        {{ Intl.NumberFormat(locale, {
                                            style: 'currency',
                                            currency: 'PHP'
                                        }).format(product.price) }}
                                    </div>
                                </div>
                            </div>
                        </DialogTrigger>
                        <ProductDialogLayout :product="product" />
                    </Dialog>
                </template>
            </div>
        </div>

        <!-- What a pain to figure out... -->
        <Pagination v-model:page="products.current_page" :items-per-page="products.per_page" :total="products.total">
            <PaginationContent>
                <PaginationPrevious v-if="products.prev_page_url === null" />
                <Link v-else :href="products.prev_page_url" class="cursor-default" preserve-scroll>
                <PaginationPrevious />
                </Link>

                <template v-for="n in (products.last_page)">
                    <Link :href="products.links[n].url" preserve-scroll>
                    <PaginationItem :value="products.links[n].page"
                        :is-active="products.current_page === products.links[n].page">
                        {{ products.links[n].page }}
                    </PaginationItem>
                    </Link>
                </template>

                <PaginationNext v-if="products.next_page_url === null" />
                <Link v-else="products.next_page_url" :href="products.next_page_url" class="cursor-default"
                    preserve-scroll>
                <PaginationNext />
                </Link>
            </PaginationContent>
        </Pagination>

        <div class="h-8" />
    </AppLayoutHome>
</template>
