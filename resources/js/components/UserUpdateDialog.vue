<script setup lang="ts">
import UserController from '@/actions/App/Http/Controllers/UserController';
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
import { User } from '@/types';
import { Form } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { VisuallyHidden } from 'reka-ui';
import { ref } from 'vue';

const props = defineProps<{
    variant?: 'add' | 'edit';
    user?: User;
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
                <DialogTitle> {{ editMode ? 'Edit' : 'Add' }} user </DialogTitle>
                <VisuallyHidden>
                    <DialogDescription>{{ editMode ? 'Edit details for ' + user?.name : 'Add user' }} </DialogDescription>
                </VisuallyHidden>
            </DialogHeader>

            <Form
                id="dialog_form"
                v-bind="editMode ? UserController.update.form() : UserController.store.form()"
                #default="{ errors, processing }"
                @success="() => (open = false)"
                :options="{ preserveScroll: true }"
            >
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
                <DialogFooter>
                    <Button :disabled="processing" class="w-20" type="submit" form="dialog_form">
                        <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin" />
                        Save
                    </Button>
                    <DialogClose as-child> </DialogClose>
                    <DialogClose as-child>
                        <Button class="w-20" variant="outline">Cancel</Button>
                    </DialogClose>
                </DialogFooter>
            </Form>
        </DialogContent>
    </Dialog>
</template>
