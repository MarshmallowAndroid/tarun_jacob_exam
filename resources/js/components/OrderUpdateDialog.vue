<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Form } from '@inertiajs/vue3';
import { Check, LoaderCircle } from 'lucide-vue-next';
import { ref } from 'vue';
import { Combobox, ComboboxAnchor, ComboboxGroup, ComboboxItem, ComboboxItemIndicator, ComboboxList, ComboboxTrigger } from './ui/combobox';
import { VisuallyHidden } from 'reka-ui';
import { cn } from '@/lib/utils';
import { Select, SelectContent, SelectItem, SelectLabel, SelectTrigger, SelectValue } from './ui/select';
import { FormField } from './ui/form';
import ProductUserController from '@/actions/App/Http/Controllers/ProductUserController';

const props = defineProps(['order']);
const statuses = [
    { value: 0, label: 'Pending' },
    { value: 1, label: 'For delivery' },
    { value: 2, label: 'Delivered' },
    { value: 3, label: 'Cancelled' },
];

const open = ref(false);
const statusValue = ref<typeof statuses[0]>();

// set status value on dialog open
function onOpen(value: boolean) {
    if (value) {
        statusValue.value = statuses[props.order.status];
    }
}
</script>
<template>
    <Dialog v-model:open="open" @update:open="onOpen">
        <DialogTrigger>
            <slot />
        </DialogTrigger>
        <DialogContent class="sm:max-w-3xl">
            <DialogHeader>
                <DialogTitle>{{ order.user.name }}</DialogTitle>
                <VisuallyHidden>
                    <DialogDescription>Edit order for {{ order.user.name }}</DialogDescription>
                </VisuallyHidden>
            </DialogHeader>

            <Form id="dialog_form" v-bind="ProductUserController.update.form()" #default="{ errors, processing }"
                @success="() => open = false"
                :options="{ preserveScroll: true }">
                <Input type="hidden" name="id" :default-value="order.id" />
                <Input type="hidden" name="status" :model-value="statusValue?.value" />

                <div class="grid gap-8">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-2">
                            <Label>Full name</Label>
                            <Input type="text" disabled :default-value="order.user.name" />
                        </div>

                        <div class="flex flex-col gap-2">
                            <Label>Product name</Label>
                            <Input type="text" disabled :default-value="order.product.name" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-2">
                            <Label>Status</Label>

                            <Select v-model="statusValue" class="w-full">
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Select status" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem v-for="status in statuses" :key="status.value" :value="status">
                                        {{ status.label }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                        </div>

                        <div class="flex flex-col gap-2">
                            <Label>Quantity</Label>
                            <Input type="text" disabled :default-value="order.quantity" />
                        </div>
                    </div>

                </div>

                <div class="h-24" />
                <DialogFooter>
                    <Button :disabled="processing" class="w-20" type="submit" form="dialog_form">
                        <LoaderCircle v-if="processing" class="w-4 h-4 animate-spin" />
                        Save
                    </Button>
                    <DialogClose as-child>
                    </DialogClose>
                    <DialogClose as-child>
                        <Button class="w-20" variant="outline">Cancel</Button>
                    </DialogClose>
                </DialogFooter>
            </Form>
        </DialogContent>
    </Dialog>
</template>