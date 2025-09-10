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
import { Eye, Pencil, Plus, Trash2 } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import ProductUpdateDialog from '@/components/ProductUpdateDialog.vue';
import OrderUpdateDialog from '@/components/OrderUpdateDialog.vue';

defineProps(['orders'])

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Orders',
        href: admin.products().url,
    },
];
</script>

<template>

    <Head title="Orders" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="m-4 p-4 rounded-lg border">
            <Table>
                <TableHeader>
                    <TableHead>
                        Full Name
                    </TableHead>
                    <TableHead>
                        Product Name
                    </TableHead>
                    <TableHead class="text-center">
                        Quantity
                    </TableHead>
                    <TableHead class="text-center">
                        Status
                    </TableHead>
                    <TableHead class="text-right w-36">
                        Actions
                    </TableHead>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="order in orders" :key="order.id">
                        <TableCell>
                            {{ order.user.name }}
                        </TableCell>
                        <TableCell>
                            {{ order.product.name }}
                        </TableCell>
                        <TableCell class="text-center font-mono">
                            {{ Intl.NumberFormat().format(order.quantity) }}
                        </TableCell>
                        <TableCell class="text-center">
                            <div class="flex items-center justify-center">
                                <div class="w-24">
                                    <div v-if="order.status === 0"
                                        class="bg-amber-300 dark:bg-amber-700 rounded-md p-2">
                                        Pending
                                    </div>
                                    <div v-else-if="order.status === 1"
                                        class="bg-lime-300 dark:bg-lime-600 rounded-md p-2">
                                        For delivery
                                    </div>
                                    <div v-else-if="order.status === 2"
                                        class="bg-green-300 dark:bg-emerald-700 rounded-md p-2">
                                        Delivered
                                    </div>
                                    <div v-else-if="order.status === 3"
                                        class="bg-red-300 dark:bg-red-900 rounded-md p-2">
                                        Cancelled
                                    </div>
                                </div>
                            </div>
                        </TableCell>
                        <TableCell class="text-right">
                            <div class="items-center">
                                <OrderUpdateDialog :order="order" variant="edit">
                                    <Button size="icon" variant="ghost">
                                        <Eye />
                                    </Button>
                                </OrderUpdateDialog>
                                <Button size="icon" variant="ghost" as-child>
                                    <Link href="" method="delete" :data="{ id: order.id }" preserve-scroll>
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
