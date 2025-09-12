<script setup lang="ts">
import AppLogoWording from '@/components/AppLogoWording.vue';
import ProductDialog from '@/components/ProductDialog.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Pagination, PaginationContent, PaginationItem, PaginationNext, PaginationPrevious } from '@/components/ui/pagination';
import { ToggleGroup, ToggleGroupItem } from '@/components/ui/toggle-group';
import AppLayoutHome from '@/layouts/AppLayoutHome.vue';
import { home } from '@/routes';
import { Form, Head } from '@inertiajs/vue3';
import axios from 'axios';
import { Image, Search } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps(['search', 'sort', 'locale']);
const products = ref();
const sortValue = ref<string>(props.sort ?? 'asc');
const formRef = ref();

function paginate(url: string, searchQuery?: string, sort?: string) {
    axios
        .get(url, {
            params: {
                search: searchQuery,
                sort: sort,
            },
        })
        .then((response) => response.data)
        .then((r) => products.value = r);
}

function refreshItems(url?: string) {
    if (!url) {
        url = '/api/products';
    }

    paginate(url, props.search, props.sort);
}

function submitForm() {
    if (formRef.value) {
        formRef.value.submit();
    }
}

refreshItems();
</script>

<template>
    <Head title="Home">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <AppLayoutHome>
        <div class="flex h-full flex-col gap-4 overflow-x-auto rounded-xl p-6">
            <div class="relative">
                <Form
                    ref="formRef"
                    v-bind="home.form()"
                    :options="{ preserveState: true }"
                    @success="refreshItems()"
                    :transform="(data) => ({ ...data, sort: sortValue })"
                >
                    <div class="relative max-w-sm">
                        <Input type="text" name="search" placeholder="Search" class="round-xl" :default-value="props.search" />
                        <span class="absolute inset-y-0 end-0 flex items-center justify-center">
                            <Button variant="ghost">
                                <Search class="text-muted-foreground" />
                            </Button>
                        </span>
                    </div>
                </Form>
                <ToggleGroup
                    type="single"
                    class="absolute inset-y-0 end-0"
                    variant="outline"
                    :default-value="sortValue"
                    :model-value="sortValue"
                    @update:model-value="
                        (val) => {
                            if (val) sortValue = val.toString();
                            submitForm();
                        }
                    "
                >
                    <ToggleGroupItem value="asc"> Price ascending </ToggleGroupItem>
                    <ToggleGroupItem value="desc"> Price descending </ToggleGroupItem>
                </ToggleGroup>
            </div>
            <div v-if="products" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <template v-for="product in products.data" :key="product.id">
                    <ProductDialog :product="product">
                        <div class="overflow-hidden rounded-xl border border-sidebar-border/70 hover:bg-accent/50 dark:border-sidebar-border">
                            <div class="flex aspect-square items-center justify-center bg-accent">
                                <Image class="size-24 text-primary opacity-50" />
                            </div>
                            <div class="m-4 grid grid-rows-2 text-left">
                                <div class="text-primary">
                                    {{ product.name }}
                                </div>
                                <div class="text-xl font-bold">
                                    {{
                                        Intl.NumberFormat(locale, {
                                            style: 'currency',
                                            currency: 'PHP',
                                        }).format(product.price)
                                    }}
                                </div>
                            </div>
                        </div>
                    </ProductDialog>
                </template>
            </div>
        </div>

        <template v-if="products">
            <!-- What a pain to figure out... -->
            <Pagination class="mt-16" v-model:page="products.current_page" :items-per-page="products.per_page" :total="products.total">
                <PaginationContent>
                    <PaginationPrevious @click="refreshItems(products.prev_page_url)" />

                    <template v-for="n in products.last_page" :key="n">
                        <PaginationItem
                            :value="products.links[n].page"
                            :is-active="products.current_page === products.links[n].page"
                            @click="refreshItems(products.links[n].url)"
                        >
                            {{ products.links[n].page }}
                        </PaginationItem>
                    </template>

                    <PaginationNext @click="refreshItems(products.next_page_url)" />
                </PaginationContent>
            </Pagination>
        </template>

        <!-- Footer -->
        <div class="mt-16 flex h-24 flex-col items-center justify-center">
            <AppLogoWording class="h-8 object-center" />
            <span class="mt-2 text-muted-foreground"> Copyright &copy; 2025 PurpleBug Inc. </span>
        </div>
    </AppLayoutHome>
</template>
