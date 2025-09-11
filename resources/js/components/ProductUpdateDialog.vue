<script setup lang="ts">
import ProductController from '@/actions/App/Http/Controllers/ProductController';
import InputError from '@/components/InputError.vue';
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
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { NumberField, NumberFieldContent, NumberFieldDecrement, NumberFieldIncrement, NumberFieldInput } from '@/components/ui/number-field';
import { Product } from '@/types';
import { Form } from '@inertiajs/vue3';
import { Image, LoaderCircle } from 'lucide-vue-next';
import { VisuallyHidden } from 'reka-ui';
import { ref } from 'vue';

const props = defineProps<{
    variant?: 'add' | 'edit';
    product?: Product;
}>();

const editMode = props.variant === 'edit';
const open = ref(false);
</script>
<template>
    <Dialog v-model:open="open">
        <DialogTrigger>
            <slot />
        </DialogTrigger>
        <DialogContent class="sm:max-w-3xl">
            <DialogHeader>
                <DialogTitle> {{ editMode ? 'Edit' : 'Add' }} product </DialogTitle>
                <VisuallyHidden>
                    <DialogDescription>{{ editMode ? 'Edit details for ' + product?.name : 'Add product' }}</DialogDescription>
                </VisuallyHidden>
            </DialogHeader>

            <Form
                id="dialog_form"
                v-bind="editMode ? ProductController.update.form() : ProductController.store.form()"
                #default="{ errors, processing }"
                @success="() => (open = false)"
                :options="{ preserveScroll: true }"
            >
                <Input type="hidden" name="id" :default-value="product?.id" />

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex aspect-square items-center justify-center rounded-md bg-accent">
                        <Image class="size-24 text-primary opacity-50" />
                    </div>
                    <div>
                        <div class="grid gap-2">
                            <Label for="name">Product name</Label>
                            <Input type="text" name="name" :default-value="product?.name" />
                            <InputError :message="errors.name" />

                            <Label for="price">Price</Label>
                            <NumberField
                                name="price"
                                :format-options="{
                                    style: 'currency',
                                    currency: 'PHP',
                                    minimumFractionDigits: 2,
                                }"
                                :step="0.01"
                                :default-value="product?.price"
                            >
                                <NumberFieldContent>
                                    <NumberFieldDecrement />
                                    <NumberFieldInput />
                                    <NumberFieldIncrement />
                                </NumberFieldContent>
                            </NumberField>
                            <InputError :message="errors.price" />
                            <!-- <Input type="number" step=".01" name="price" class="font-mono" :default-value="product?.price" /> -->

                            <Label for="stocks">Stocks</Label>
                            <NumberField
                                name="stocks"
                                :format-options="{
                                    style: 'decimal',
                                }"
                                :default-value="product?.stocks"
                            >
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

                <DialogFooter class="mt-4">
                    <Button :disabled="processing" class="w-20" type="submit" form="dialog_form">
                        <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin" />
                        Save
                    </Button>
                    <DialogClose as-child>
                        <Button class="w-20" variant="outline">Close</Button>
                    </DialogClose>
                </DialogFooter>
            </Form>
        </DialogContent>
    </Dialog>
</template>
