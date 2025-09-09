<script setup lang="ts">
import CartController from '@/actions/App/Http/Controllers/CartController';
import ProductController from '@/actions/App/Http/Controllers/ProductController';
import UserController from '@/actions/App/Http/Controllers/UserController';
import InputError from '@/components/InputError.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { NumberField, NumberFieldContent, NumberFieldDecrement, NumberFieldIncrement, NumberFieldInput } from '@/components/ui/number-field';
import { Product } from '@/types';
import { Form } from '@inertiajs/vue3';
import { Image, LoaderCircle } from 'lucide-vue-next';
import { VisuallyHidden } from 'reka-ui';
import { ref } from 'vue';

const props = defineProps<{
    product: Product,
    locale?: string,
}>();

const quantity = ref(1);
const open = ref(false);
</script>
<template>
    <Dialog v-model:open="open">
        <DialogTrigger>
            <slot />
        </DialogTrigger>
        <DialogContent class="sm:max-w-3xl">
            <VisuallyHidden>
                <DialogTitle>View product</DialogTitle>
                <DialogDescription>View details for {{ product.name }}</DialogDescription>
            </VisuallyHidden>

            <Form id="dialog_form" v-bind="CartController.store.form()" #default="{ errors, processing }"
                @success="() => open = false"
                :options="{ preserveScroll: true }">
                <Input type="hidden" name="product_id" :default-value="product?.id" />

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex bg-accent aspect-square rounded-md items-center justify-center ">
                        <Image class="size-24 text-primary opacity-25" />
                    </div>
                    <div>
                        <div class="grid gap-2">
                            <div class="text-primary">
                                {{ product.name }}
                            </div>
                            <div class="font-bold text-2xl">
                                {{ Intl.NumberFormat(locale, {
                                    style: 'currency',
                                    currency: 'PHP'
                                }).format(product.price) }}
                            </div>

                            <template v-if="product.stocks > 0">
                                <Label for="quantity">Quantity</Label>
                                <NumberField name="quantity" :default-value="1" :min="0" :max="product.stocks"
                                    :format-options="{
                                        style: 'decimal',
                                    }" :model-value="quantity" @update:model-value="(v) => quantity = v">
                                    <NumberFieldContent>
                                        <NumberFieldDecrement />
                                        <NumberFieldInput />
                                        <NumberFieldIncrement />
                                    </NumberFieldContent>
                                </NumberField>
                                <Button :disabled="quantity < 1 || product.stocks < 1 || processing" type="submit">
                                    <LoaderCircle v-if="processing" class="w-4 h-4 animate-spin" />
                                    Add to cart
                                </Button>
                            </template>
                            <div v-else class="text-red-800">
                                Out of stock
                            </div>
                        </div>
                    </div>
                </div>
            </Form>
        </DialogContent>
    </Dialog>
</template>