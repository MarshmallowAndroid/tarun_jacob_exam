<script setup lang="ts">
import AppLogo from '@/components/AppLogo.vue';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { NavigationMenu, NavigationMenuItem, NavigationMenuList, navigationMenuTriggerStyle } from '@/components/ui/navigation-menu';
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetTrigger } from '@/components/ui/sheet';
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';
import UserMenuContent from '@/components/UserMenuContent.vue';
import { getInitials } from '@/composables/useInitials';
import { toUrl, urlIsActive } from '@/lib/utils';
import type { BreadcrumbItem, NavItem } from '@/types';
import { InertiaLinkProps, Link, usePage } from '@inertiajs/vue3';
import { BookOpen, Folder, Image, LayoutGrid, Menu, Search, ShoppingCart, Trash2 } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import { Dialog, DialogTrigger, DialogContent, DialogHeader, DialogFooter, DialogClose } from '@/components/ui/dialog';
import admin from '@/routes/admin';
import { login, register } from '@/routes';
import axios from 'axios';
import cart from '@/routes/cart';
import CartDialog from './CartDialog.vue';

interface Props {
    breadcrumbs?: BreadcrumbItem[];
}

const props = withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const page = usePage();
const auth = computed(() => page.props.auth);
const locale = page.props.locale;

const isCurrentRoute = computed(() => (url: NonNullable<InertiaLinkProps['href']>) => urlIsActive(url, page.url));

const activeItemStyles = computed(
    () => (url: NonNullable<InertiaLinkProps['href']>) =>
        isCurrentRoute.value(toUrl(url)) ? 'text-neutral-900 dark:bg-neutral-800 dark:text-neutral-100' : '',
);

const cartList = ref();

function updateCart() {
    axios.get('/api/cart').then(response => response.data).then(r => cartList.value = r);
}

const total = computed(() => {
    let t = 0;
    if (cartList.value) {
        cartList.value.forEach((product: any) => {
            let c = product.cart_item;
            let p = product.price * c.quantity;
            t += p;
        });
    }
    return t;
});
</script>

<template>
    <div>
        <div class="border-b border-sidebar-border/80">
            <div class="mx-auto flex h-16 items-center px-4 md:max-w-7xl">
                <Link class="flex items-center gap-x-2" href="/">
                <AppLogo class="size-48" />
                </Link>

                <div class="ml-auto flex items-center space-x-2">
                    <div v-if="auth.user" class="relative flex items-center space-x-1">
                        <CartDialog :cart-list="cartList" :total="total" @reload-requested="updateCart()">
                            <Button variant="ghost" size="icon" class="group h-9 w-9 cursor-pointer" @click="updateCart()">
                                <ShoppingCart class="size-5 opacity-80 group-hover:opacity-100" />
                            </Button>
                        </CartDialog>
                    </div>

                    <DropdownMenu v-if="auth.user">
                        <DropdownMenuTrigger :as-child="true">
                            <Button variant="ghost" size="icon"
                                class="relative size-10 w-auto rounded-md p-1 focus-within:ring-2 focus-within:ring-primary">
                                <Avatar class="size-8 overflow-hidden rounded-full">
                                    <AvatarImage v-if="auth.user.avatar" :src="auth.user.avatar"
                                        :alt="auth.user.name" />
                                    <AvatarFallback
                                        class="rounded-lg bg-neutral-200 font-semibold text-black dark:bg-neutral-700 dark:text-white">
                                        {{ getInitials(auth.user?.name) }}
                                    </AvatarFallback>
                                </Avatar>
                                Hi, {{ auth.user.name.split(' ')[0] }}!
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end" class="w-56">
                            <UserMenuContent :user="auth.user" />
                        </DropdownMenuContent>
                    </DropdownMenu>

                    <template v-else>
                        <Link :href="login()"
                            class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]">
                        Log in
                        </Link>
                        <Link :href="register()"
                            class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
                        Register
                        </Link>
                    </template>
                </div>
            </div>
        </div>

        <div v-if="props.breadcrumbs.length > 1" class="flex w-full border-b border-sidebar-border/70">
            <div class="mx-auto flex h-12 w-full items-center justify-start px-4 text-neutral-500 md:max-w-7xl">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </div>
        </div>
    </div>
</template>
