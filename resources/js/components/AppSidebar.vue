<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { home } from '@/routes';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { Archive, Inbox, Users } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import Separator from '@/components/ui/separator/Separator.vue';
import admin from '@/routes/admin';

const mainNavItems: NavItem[] = [
    {
        title: 'Product Management',
        href: admin.products(),
        icon: Archive,
    },
    {
        title: 'Orders',
        href: admin.orders(),
        icon: Inbox,
    },
    {
        title: 'User Management',
        href: admin.users(),
        icon: Users,
    }
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link href="/">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <Separator />
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
