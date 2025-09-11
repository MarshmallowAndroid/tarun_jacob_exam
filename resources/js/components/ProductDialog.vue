<script setup lang="ts">
import CartController from '@/actions/App/Http/Controllers/CartController';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { NumberField, NumberFieldContent, NumberFieldDecrement, NumberFieldIncrement, NumberFieldInput } from '@/components/ui/number-field';
import { Form } from '@inertiajs/vue3';
import { Image, LoaderCircle } from 'lucide-vue-next';
import { VisuallyHidden } from 'reka-ui';
import { ref } from 'vue';

defineProps(['product', 'locale']);

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

            <Form
                id="dialog_form"
                v-bind="CartController.store.form()"
                #default="{ processing }"
                @success="() => (open = false)"
                :options="{ preserveScroll: true }"
            >
                <Input type="hidden" name="product_id" :default-value="product?.id" />

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex aspect-square items-center justify-center rounded-md bg-accent">
                        <Image class="size-24 text-primary opacity-50" />
                    </div>
                    <div>
                        <div class="grid gap-2">
                            <div class="text-primary">
                                {{ product.name }}
                            </div>
                            <div class="text-2xl font-bold">
                                {{
                                    Intl.NumberFormat(locale, {
                                        style: 'currency',
                                        currency: 'PHP',
                                    }).format(product.price)
                                }}
                            </div>

                            <template v-if="product.stocks > 0">
                                <Label for="quantity">Quantity</Label>
                                <NumberField
                                    name="quantity"
                                    :default-value="1"
                                    :min="0"
                                    :max="product.stocks"
                                    :format-options="{
                                        style: 'decimal',
                                    }"
                                    :model-value="quantity"
                                    @update:model-value="(v) => (quantity = v)"
                                >
                                    <NumberFieldContent>
                                        <NumberFieldDecrement />
                                        <NumberFieldInput />
                                        <NumberFieldIncrement />
                                    </NumberFieldContent>
                                </NumberField>
                                <Button :disabled="quantity < 1 || product.stocks < 1 || processing" type="submit">
                                    <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin" />
                                    Add to cart
                                </Button>
                            </template>
                            <div v-else class="text-red-800">Out of stock</div>
                        </div>
                    </div>
                </div>
            </Form>
        </DialogContent>
    </Dialog>
</template>
