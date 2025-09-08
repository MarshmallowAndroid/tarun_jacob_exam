<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import admin from '@/routes/admin';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'
import { Pencil, Plus, Trash2 } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import ProductDialogLayout from '@/layouts/admin/ProductUpdateDialog.vue'

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
            <div  class="float-right mb-4">
                <ProductDialogLayout>
                    <Button>
                        <Plus />
                        Add product
                    </Button>
                </ProductDialogLayout>
            </div>
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
                                <ProductDialogLayout :product="product" variant="edit">
                                    <Button size="icon" variant="ghost" class="mr-2">
                                        <Pencil />
                                    </Button>
                                </ProductDialogLayout>
                                <Button size="icon" variant="ghost" as-child>
                                    <Link href="" method="delete" :data="{ id: product.id }" preserve-scroll>
                                    <Trash2 class="text-destructive" />
                                    </Link>
                                </Button>
                            </div>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </AppLayout>
</template>
