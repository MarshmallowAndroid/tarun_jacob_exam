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
import { Product, User } from '@/types';
import { Form } from '@inertiajs/vue3';

const props = defineProps<{
    variant?: 'add' | 'edit',
    user?: User,
}>();

const editMode = props.variant === 'edit';

</script>
<template>
    <DialogContent class="sm:max-w-3xl">
        <DialogHeader>
            <DialogTitle>
                {{ editMode ? 'Edit' : 'Add' }} user
            </DialogTitle>
        </DialogHeader>

        <Form id="dialog_form" v-bind="editMode ? UserController.update.form() : UserController.create.form()"
            #default="{ errors }">
            <Input type="hidden" name="id" :default-value="user?.id" />

            <div class="grid gap-8">
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <Label for="name">Full name</Label>
                        <Input type="text" name="name" :default-value="user?.name" />
                        <InputError :message="errors.name" />
                    </div>
    
                    <div class="flex flex-col gap-2">
                        <Label for="email">Email</Label>
                        <Input type="text" name="email" :default-value="user?.email" />
                        <InputError :message="errors.email" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <Label for="password">Password</Label>
                        <Input type="password" name="password" />
                        <InputError :message="errors.password" />
                    </div>
    
                    <div class="flex flex-col gap-2">
                        <Label for="password_confirmation">Confirm password</Label>
                        <Input type="password" name="password_confirmation" />
                        <InputError :message="errors.password_confirmation" />
                    </div>
                </div>

            </div>

            <div class="h-24" />
        </Form>

        <DialogFooter>
            <Button class="w-20" type="submit" form="dialog_form">Save</Button>
            <DialogClose as-child>
            </DialogClose>
            <DialogClose as-child>
                <Button class="w-20" variant="outline">Cancel</Button>
            </DialogClose>
        </DialogFooter>
    </DialogContent>
</template>