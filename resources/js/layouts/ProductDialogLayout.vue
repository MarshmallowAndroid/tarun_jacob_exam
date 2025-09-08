<script setup lang="ts">
import ProductController from '@/actions/App/Http/Controllers/ProductController';
import UserController from '@/actions/App/Http/Controllers/UserController';
import InputError from '@/components/InputError.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { Button } from '@/components/ui/button';
import { DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { NumberField, NumberFieldContent, NumberFieldDecrement, NumberFieldIncrement, NumberFieldInput } from '@/components/ui/number-field';
import { Product } from '@/types';
import { Form } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    product: Product,
    locale?: string,
}>();

const quantity = ref(1);

</script>
<template>
    <DialogContent class="sm:max-w-3xl">
        <Form id="dialog_form" #default="{ errors }">
            <Input type="hidden" name="id" :default-value="product?.id" />

            <div class="grid grid-cols-2 gap-4">
                <div class="relative aspect-square rounded-md border">
                    <PlaceholderPattern />
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

                        <Label for="quantity">Quantity</Label>
                        <NumberField name="quantity" :default-value="1" :min="1" :max="product.stocks" :format-options="{
                            style: 'decimal',
                        }" :model-value="quantity" @update:model-value="(v) => quantity = v">
                            <NumberFieldContent>
                                <NumberFieldDecrement />
                                <NumberFieldInput />
                                <NumberFieldIncrement />
                            </NumberFieldContent>
                        </NumberField>
                        <Button :disabled="quantity < 1 || product.stocks < 1" type="submit" form="dialog_form">Add to cart</Button>
                    </div>
                </div>
            </div>
        </Form>
    </DialogContent>
</template>