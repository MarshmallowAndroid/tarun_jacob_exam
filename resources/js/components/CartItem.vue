<script setup lang="ts">
import { Form, Link, usePage } from '@inertiajs/vue3';
import { Button } from './ui/button';
import { Image, Trash2 } from 'lucide-vue-next';
import CartController from '@/actions/App/Http/Controllers/CartController';
import { Input } from './ui/input';

defineProps(['product']);
const emits = defineEmits(['success']);

const page = usePage();
const locale = page.props.locale;
</script>

<template>
    <div class="rounded-xl border p-4">
        <Form v-bind="CartController.delete.form()" @success="emits('success')">
            <Input type="hidden" name="id" :model-value="product.id" />
            <div class="flex gap-4 float-left">
                <div class="flex bg-accent size-32 aspect-square rounded-md items-center justify-center ">
                    <Image class="size-8 text-primary opacity-25" />
                </div>
                <div>
                    <div class="grid gap-1">
                        <div class="text-primary">
                            {{ product.name }}
                        </div>
                        <div class="text-muted-foreground">
                            {{ Intl.NumberFormat(locale, {
                                style: 'currency',
                                currency: 'PHP'
                            }).format(product.price) }} x {{ product.cart_item.quantity
                            }}
                        </div>
                        <div class="font-bold text-2xl">
                            {{ Intl.NumberFormat(locale, {
                                style: 'currency',
                                currency: 'PHP'
                            }).format(product.price * product.cart_item.quantity) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="float-right aspect-square">
                <Button variant="destructive" type="submit" size="icon">
                    <Trash2 />
                </Button>
            </div>
        </Form>
    </div>
</template>