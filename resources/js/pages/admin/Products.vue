<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Form, Head, Link, router, usePage } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import admin from '@/routes/admin';
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'
import { Pencil, Plus, Trash, Trash2 } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import ProductController from '@/actions/App/Http/Controllers/ProductController';
import Input from '@/components/ui/input/Input.vue';
import { Dialog, DialogContent, DialogTrigger } from '@/components/ui/dialog'
import ProductDialogLayout from '@/layouts/admin/ProductDialogLayout.vue'
import { ref } from 'vue';

defineProps(['products', 'locale']);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Product management',
        href: admin.products().url,
    },
];

</script>

<template>

    <Head title="Product management" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="m-4 p-4 rounded-lg border">
            <Dialog>
                <DialogTrigger class="float-right mb-4">
                    <Button>
                        <Plus />
                        Add product
                    </Button>
                </DialogTrigger>
                <ProductDialogLayout />
            </Dialog>
            <Table>
                <TableHeader>
                    <TableHead class="text-center">
                        Product Name
                    </TableHead>
                    <TableHead class="text-right font-mono w-48">
                        Price
                    </TableHead>
                    <TableHead class="text-right font-mono w-48">
                        Stock
                    </TableHead>
                    <TableHead class="text-right w-36">
                        Actions
                    </TableHead>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="product in products" :key="product.id">
                        <TableCell>
                            {{ product.name }}
                        </TableCell>
                        <TableCell class="text-right font-mono">
                            {{ Intl.NumberFormat(locale, {
                                style: 'currency',
                                currency: 'PHP'
                            }).format(product.price) }}
                        </TableCell>
                        <TableCell class="text-right font-mono">
                            {{ Intl.NumberFormat().format(product.stocks) }}
                        </TableCell>
                        <TableCell class="text-right">
                            <div class="items-center">
                                <Dialog>
                                    <DialogTrigger>
                                        <Button size="icon" variant="ghost" class="mr-2">
                                            <Pencil />
                                        </Button>
                                    </DialogTrigger>
                                    <ProductDialogLayout :product="product" variant="edit" />
                                </Dialog>
                                <Button size="icon" variant="ghost" as-child>
                                    <Link href="" method="delete" :data="{ id: product.id}" preserve-scroll>
                                        <Trash2 class="text-destructive" />
                                    </Link>
                                </Button>
                            </div>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>

        <!-- <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <PlaceholderPattern />
            </div>
        </div> -->
    </AppLayout>
</template>
