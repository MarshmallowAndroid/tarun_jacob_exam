<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import UserUpdateDialog from '@/components/UserUpdateDialog.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import admin from '@/routes/admin';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Pencil, Plus, Trash2 } from 'lucide-vue-next';

defineProps(['users']);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'User management',
        href: admin.products().url,
    },
];
</script>

<template>
    <Head title="Product management" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="m-4 rounded-lg border p-4">
            <div class="float-right mb-4">
                <UserUpdateDialog variant="add">
                    <Button>
                        <Plus />
                        Add user
                    </Button>
                </UserUpdateDialog>
            </div>
            <Table>
                <TableHeader>
                    <TableHead class="text-center"> Full Name </TableHead>
                    <TableHead> Email </TableHead>
                    <TableHead class="w-10 text-right"> Actions </TableHead>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="user in users" :key="user.id">
                        <TableCell>
                            {{ user.name }}
                        </TableCell>
                        <TableCell>
                            {{ user.email }}
                        </TableCell>
                        <TableCell class="text-right">
                            <template v-if="usePage().props.auth.user.id !== user.id">
                                <div class="items-center">
                                    <UserUpdateDialog variant="edit" :user="user">
                                        <Button size="icon" variant="ghost">
                                            <Pencil />
                                        </Button>
                                    </UserUpdateDialog>
                                    <Button size="icon" variant="ghost" as-child>
                                        <Link href="" method="delete" :data="{ id: user.id }" preserve-scroll>
                                            <Trash2 class="text-destructive" />
                                        </Link>
                                    </Button>
                                </div>
                            </template>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </AppLayout>
</template>
