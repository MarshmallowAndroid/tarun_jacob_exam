<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Form, Head, Link, router } from '@inertiajs/vue3';
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
import UserDialogLayout from '@/layouts/admin/UserDialogLayout.vue';

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
        <div class="m-4 p-4 rounded-lg border">
            <Dialog>
                <DialogTrigger class="float-right mb-4">
                    <Button>
                        <Plus />
                        Add product
                    </Button>
                </DialogTrigger>
                <UserDialogLayout />
            </Dialog>
            <Table>
                <TableHeader>
                    <TableHead class="text-center">
                        Full Name
                    </TableHead>
                    <TableHead>
                        Email
                    </TableHead>
                    <TableHead class="text-right w-10">
                        Actions
                    </TableHead>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="user in users" :key="users.id">
                        <TableCell>
                            {{ user.name }}
                        </TableCell>
                        <TableCell>
                            {{ user.email }}
                        </TableCell>
                        <TableCell class="text-right">
                            <div class="items-center">
                                <Dialog>
                                    <DialogTrigger>
                                        <Button size="icon" variant="ghost" class="mr-2">
                                            <Pencil />
                                        </Button>
                                    </DialogTrigger>
                                    <UserDialogLayout variant="edit" :user="user" />
                                </Dialog>
                                <Button size="icon" variant="ghost" as-child>
                                    <Link href="" method="delete" :data="{ id: user.id}" preserve-scroll>
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
