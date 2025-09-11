<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Form, Link, usePage } from '@inertiajs/vue3';
import { Image, LoaderCircle, ShoppingCart, Trash2 } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import { Dialog, DialogTrigger, DialogContent, DialogHeader, DialogFooter, DialogClose, DialogTitle, DialogDescription } from '@/components/ui/dialog';
import axios from 'axios';
import cart from '@/routes/cart';
import { Input } from './ui/input';
import CartController from '@/actions/App/Http/Controllers/CartController';
import CartItem from './CartItem.vue';
import { checkout } from '@/routes';
import { VisuallyHidden } from 'reka-ui';
import ThankYouGraphic from './ThankYouGraphic.vue';
import AppLogoWording from './AppLogoWording.vue';
defineProps(['cartList', 'total']);
const emit = defineEmits(['reloadRequested']);

const page = usePage();
const locale = page.props.locale;

const open = ref(false);
const checkedOut = ref(false);
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger>
            <slot />
        </DialogTrigger>
        <DialogContent class="max-h-[90dvh]">
            <VisuallyHidden>
                <DialogTitle>Cart</DialogTitle>
                <DialogDescription>View the items in your cart</DialogDescription>
            </VisuallyHidden>

            <DialogHeader>
                <div class="mt-8">
                    <div class="flex items-center gap-4 float-left">
                        <ShoppingCart class="size-8" />
                        <span class="font-bold text-2xl">Cart</span>
                    </div>
                    <Form v-bind="CartController.checkout.form()" @success="() => { open = false; checkedOut = true; }"
                        #default="{ processing }" :options="{ preserveScroll: true }">
                        <Button :disabled="!cartList[0] || processing" type="submit" class="relative float-right">
                            <LoaderCircle v-if="processing" class="w-4 h-4 animate-spin" />
                            Place order
                        </Button>
                    </Form>
                </div>
            </DialogHeader>

            <div class="grid gap-4 overflow-y-auto">
                <template v-for="product in cartList">
                    <CartItem :product="product" @success="emit('reloadRequested')" />
                </template>
            </div>

            <DialogFooter>
                <div class="flex gap-4 p-4 bg-primary text-background rounded-xl w-full">
                    <div>Total</div>
                    <div class="font-bold text-3xl">
                        {{ Intl.NumberFormat(locale, {
                            style: 'currency',
                            currency: 'PHP'
                        }).format(total) }}
                    </div>
                </div>
            </DialogFooter>

        </DialogContent>
    </Dialog>
    <Dialog v-model:open="checkedOut">
        <DialogContent>
            <div class="grid gap-8 mt-8">
                <div class="flex flex-col gap-16 items-center justify-center">
                    <AppLogoWording class="h-8" />
                    <ThankYouGraphic class="h-72" />
                    <span class="text-primary text-2xl">Thank you for shopping with us.</span>
                </div>
                <DialogClose as-child>
                    <Button>
                        Close
                    </Button>
                </DialogClose>
            </div>
        </DialogContent>
    </Dialog>
</template>