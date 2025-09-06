<script setup lang="ts">
import ProductController from '@/actions/App/Http/Controllers/ProductController';
import UserController from '@/actions/App/Http/Controllers/UserController';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { Button } from '@/components/ui/button';
import { DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { NumberField, NumberFieldContent, NumberFieldDecrement, NumberFieldIncrement, NumberFieldInput } from '@/components/ui/number-field';
import { Product, User } from '@/types';
import { Form } from '@inertiajs/vue3';

const props = defineProps<{
    variant?: 'add' | 'edit',
    user?: User,
}>();

const editMode = props.variant === 'edit';

</script>
<template>
    <DialogContent>
        <DialogHeader>
            <DialogTitle>
                {{ editMode ? 'Edit' : 'Add' }} product
            </DialogTitle>
        </DialogHeader>

        <Form id="dialog_form" v-bind="editMode ? UserController.update.form() : UserController.create.form()">
            <div class="grid grid-cols-2 gap-4">
                <div class="relative rounded-md border">
                    <PlaceholderPattern />
                </div>
                <div class="grid gap-2">
                    <Input type="hidden" name="id" :default-value="user?.id" />

                    <Label for="name">Full name</Label>
                    <Input type="text" name="name" :default-value="user?.name" />

                    <Label for="email">Email</Label>
                    <Input type="text" name="email" :default-value="user?.email" />

                    <Label for="name">Password</Label>
                    <Input type="password" name="name" />

                    <Label for="name">Confirm password</Label>
                    <Input type="password" name="name" />
                </div>
            </div>
        </Form>

        <DialogFooter>
            <DialogClose as-child>
                <Button class="w-20" type="submit" form="dialog_form">Save</Button>
            </DialogClose>
            <DialogClose as-child>
                <Button class="w-20" variant="outline">Cancel</Button>
            </DialogClose>
        </DialogFooter>
    </DialogContent>
</template>