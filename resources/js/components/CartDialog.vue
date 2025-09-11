<script setup lang="ts">
import CartController from '@/actions/App/Http/Controllers/CartController';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Form, usePage } from '@inertiajs/vue3';
import { LoaderCircle, ShoppingCart } from 'lucide-vue-next';
import { VisuallyHidden } from 'reka-ui';
import { ref } from 'vue';
import AppLogoWording from './AppLogoWording.vue';
import CartItem from './CartItem.vue';
import ThankYouGraphic from './ThankYouGraphic.vue';
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
                    <div class="float-left flex items-center gap-4">
                        <ShoppingCart class="size-8" />
                        <span class="text-2xl font-bold">Cart</span>
                    </div>
                    <Form
                        v-bind="CartController.checkout.form()"
                        @success="
                            () => {
                                open = false;
                                checkedOut = true;
                            }
                        "
                        #default="{ processing }"
                        :options="{ preserveScroll: true }"
                    >
                        <Button :disabled="!cartList[0] || processing" type="submit" class="relative float-right">
                            <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin" />
                            Place order
                        </Button>
                    </Form>
                </div>
            </DialogHeader>

            <div class="grid gap-4 overflow-y-auto">
                <template v-for="product in cartList" :key="product.id">
                    <CartItem :product="product" @success="emit('reloadRequested')" />
                </template>
            </div>

            <DialogFooter>
                <div class="flex w-full gap-4 rounded-xl bg-primary p-4 text-background">
                    <div>Total</div>
                    <div class="text-3xl font-bold">
                        {{
                            Intl.NumberFormat(locale, {
                                style: 'currency',
                                currency: 'PHP',
                            }).format(total)
                        }}
                    </div>
                </div>
            </DialogFooter>
        </DialogContent>
    </Dialog>
    <Dialog v-model:open="checkedOut">
        <DialogContent>
            <div class="mt-8 grid gap-8">
                <div class="flex flex-col items-center justify-center gap-16">
                    <AppLogoWording class="h-8" />
                    <ThankYouGraphic class="h-72" />
                    <span class="text-2xl text-primary">Thank you for shopping with us.</span>
                </div>
                <DialogClose as-child>
                    <Button> Close </Button>
                </DialogClose>
            </div>
        </DialogContent>
    </Dialog>
</template>
