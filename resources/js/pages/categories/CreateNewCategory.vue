<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import Label from '@/components/ui/label/Label.vue';
import { Spinner } from '@/components/ui/spinner';
import { store } from '@/routes/categories';
import { Form, Head } from '@inertiajs/vue3';

</script>

<template>
    <div class="flex min-h-svh items-center justify-center bg-background">

        <Head title="Create new category" />
        <Form v-bind="store.form()" v-slot="{ errors, processing }">
            <div class="grid gap-6">
                <div class="grid-gap-2">
                    <Label for="name">Name</Label>
                    <Input id="name" type="text" required autofocus name="name" placeholder="Category name" />
                    <InputError :message="errors.name" />
                </div>
                <select id="type" name="type">
                    <option value="income">Income</option>
                    <option value="expense">Expense</option>
                </select>
            </div>

            <Button type="submit" :disabled="processing">
                <Spinner v-if="processing" />
                Create
            </Button>
        </form>
    </div>
</template>
