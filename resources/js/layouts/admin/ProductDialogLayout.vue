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

const props = defineProps<{
    variant?: 'add' | 'edit',
    product?: Product,
}>();

const emit = defineEmits(['success']);

const editMode = props.variant === 'edit';

</script>
<template>
    <DialogContent class="sm:max-w-3xl">
        <DialogHeader>
            <DialogTitle>
                {{ editMode ? 'Edit' : 'Add' }} product
            </DialogTitle>
        </DialogHeader>

        <Form id="dialog_form" v-bind="editMode ? ProductController.update.form() : ProductController.store.form()"
            #default="{ errors }"
            @success="emit('success')">
            <Input type="hidden" name="id" :default-value="product?.id" />

            <div class="grid grid-cols-2 gap-4">
                <div class="relative aspect-square rounded-md border">
                    <PlaceholderPattern />
                </div>
                <div>
                    <div class="grid gap-2">
                        <Label for="name">Product name</Label>
                        <Input type="text" name="name" :default-value="product?.name" />
                        <InputError :message="errors.name" />

                        <Label for="price">Price</Label>
                        <NumberField name="price" :format-options="{
                            style: 'currency',
                            currency: 'PHP',
                            minimumFractionDigits: 2
                        }" :step=".01" :default-value="product?.price">
                            <NumberFieldContent>
                                <NumberFieldDecrement />
                                <NumberFieldInput />
                                <NumberFieldIncrement />
                            </NumberFieldContent>
                        </NumberField>
                        <InputError :message="errors.price" />
                        <!-- <Input type="number" step=".01" name="price" class="font-mono" :default-value="product?.price" /> -->

                        <Label for="stocks">Stocks</Label>
                        <NumberField name="stocks" :format-options="{
                            style: 'decimal',
                        }" :default-value="product?.stocks">
                            <NumberFieldContent>
                                <NumberFieldDecrement />
                                <NumberFieldInput />
                                <NumberFieldIncrement />
                            </NumberFieldContent>
                        </NumberField>
                        <InputError :message="errors.stocks" />
                    </div>
                </div>
            </div>
        </Form>

        <DialogFooter>
            <Button class="w-20" type="submit" form="dialog_form">Save</Button>
            <DialogClose as-child>
                <Button class="w-20" variant="outline">Close</Button>
            </DialogClose>
        </DialogFooter>
    </DialogContent>
</template>