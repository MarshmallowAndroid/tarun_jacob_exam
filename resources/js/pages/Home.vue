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
import { ref } from 'vue';
import axios from 'axios';
import AppLogoWording from '@/components/AppLogoWording.vue';

const props = defineProps(['products', 'locale']);
const products = ref();

function paginate(url: string) {
    axios.get(url).then(response => response.data).then(r => products.value = r);
}

paginate('/api/products');
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
                <template v-if="products" v-for="product in products.data">
                    <Dialog>
                        <DialogTrigger>
                            <div class="overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border
                                            hover:bg-accent/50">
                                <div class="flex bg-accent aspect-square items-center justify-center ">
                                    <Image class="size-24 text-primary opacity-25" />
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

        <template v-if="products">
            <!-- What a pain to figure out... -->
            <Pagination v-model:page="products.current_page" :items-per-page="products.per_page"
                :total="products.total">
                <PaginationContent>
                    <PaginationPrevious @click="paginate(products.prev_page_url)" />

                    <template v-for="n in (products.last_page)">
                        <PaginationItem :value="products.links[n].page"
                            :is-active="products.current_page === products.links[n].page"
                            @click="paginate(products.links[n].url)">
                            {{ products.links[n].page }}
                        </PaginationItem>
                    </template>

                    <PaginationNext @click="paginate(products.next_page_url)" />
                </PaginationContent>
            </Pagination>
        </template>

        <!-- Footer -->
        <div class="flex flex-col items-center justify-center h-24 mt-24">
            <AppLogoWording class="h-8 object-center" />
            <span class="text-muted-foreground mt-2">
                Copyright &copy; 2025 PurpleBug Inc.
            </span>
        </div>
    </AppLayoutHome>
</template>
