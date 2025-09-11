<script setup lang="ts">
import OrderUpdateDialog from '@/components/OrderUpdateDialog.vue';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import admin from '@/routes/admin';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Eye, Trash2 } from 'lucide-vue-next';

defineProps(['orders']);

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
        <div class="m-4 rounded-lg border p-4">
            <Table>
                <TableHeader>
                    <TableHead> Full Name </TableHead>
                    <TableHead> Product Name </TableHead>
                    <TableHead class="text-center"> Quantity </TableHead>
                    <TableHead class="text-center"> Status </TableHead>
                    <TableHead class="w-36 text-right"> Actions </TableHead>
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
                                    <div v-if="order.status === 0" class="rounded-md bg-amber-300 p-2 dark:bg-amber-700">Pending</div>
                                    <div v-else-if="order.status === 1" class="rounded-md bg-lime-300 p-2 dark:bg-lime-600">For delivery</div>
                                    <div v-else-if="order.status === 2" class="rounded-md bg-green-300 p-2 dark:bg-emerald-700">Delivered</div>
                                    <div v-else-if="order.status === 3" class="rounded-md bg-red-300 p-2 dark:bg-red-900">Cancelled</div>
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
