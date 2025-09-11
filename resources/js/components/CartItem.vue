<script setup lang="ts">
import CartController from '@/actions/App/Http/Controllers/CartController';
import { Form, usePage } from '@inertiajs/vue3';
import { Image, Trash2 } from 'lucide-vue-next';
import { Button } from './ui/button';
import { Input } from './ui/input';

defineProps(['product']);
const emits = defineEmits(['success']);

const page = usePage();
const locale = page.props.locale;
</script>

<template>
    <div class="rounded-xl border p-4">
        <Form v-bind="CartController.delete.form()" @success="emits('success')" :options="{ preserveScroll: true }">
            <Input type="hidden" name="id" :model-value="product.id" />
            <div class="float-left flex gap-4">
                <div class="flex aspect-square size-32 items-center justify-center rounded-md bg-accent">
                    <Image class="size-8 text-primary opacity-25" />
                </div>
                <div>
                    <div class="grid gap-1">
                        <div class="text-primary">
                            {{ product.name }}
                        </div>
                        <div class="text-muted-foreground">
                            {{
                                Intl.NumberFormat(locale, {
                                    style: 'currency',
                                    currency: 'PHP',
                                }).format(product.price)
                            }}
                            x {{ Intl.NumberFormat().format(product.cart_item.quantity) }}
                        </div>
                        <div class="text-2xl font-bold">
                            {{
                                Intl.NumberFormat(locale, {
                                    style: 'currency',
                                    currency: 'PHP',
                                }).format(product.price * product.cart_item.quantity)
                            }}
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
