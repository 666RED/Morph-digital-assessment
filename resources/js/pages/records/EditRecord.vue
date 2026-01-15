<script setup lang="ts">
import { CategoriesByGroup, Category, Record } from '@/types/record';
import { RecordType } from '@/types/record';
import { Form, Head } from '@inertiajs/vue3';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Spinner } from '@/components/ui/spinner';
import { Button } from '@/components/ui/button';
import { CalendarDate, DateValue, getLocalTimeZone, today } from '@internationalized/date';
import { CalendarIcon } from 'lucide-vue-next';
import Popover from '@/components/ui/popover/Popover.vue';
import { PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import Calendar from '@/components/ui/calendar/Calendar.vue';
import AppLayoutWithGoToPrevious from '@/layouts/AppLayoutWithGoToPrevious.vue';
import { index, update } from '@/routes/records';
import { BreadcrumbItem } from '@/types';
import CategoryPopover from '@/components/CategoryPopover.vue';
import { ref } from 'vue';

interface Props {
    record: Record;
    categoriesByGroup: CategoriesByGroup;
    url: string
}


const props = defineProps<Props>();
const record = props.record;

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: "Records",
        href: index().url
    },
];

const validateForm = () => {
    return updatedName.value !== '' && updatedType.value && date.value && updatedAmount.value && updatedCategory.value.id !== 0
}

const updatedType = ref<RecordType>(record.type);
const updatedName = ref<string>(record.name);
const updatedAmount = ref<number>(Number(record.amount));
const updatedCategory = ref<{ id: number, name: string }>({ id: record.category.id, name: record.category.name });
const updatedNote = ref<string>(record.note);

const defaultPlaceholder = today(getLocalTimeZone());
const newDate = new Date(record.record_date);
const year = newDate.getFullYear();
const month = newDate.getMonth() + 1;
const day = newDate.getDate();

const date = ref<DateValue>(new CalendarDate(year, month, day));

</script>

<template>

    <Head title="Create new record" />

    <AppLayoutWithGoToPrevious :breadcrumbs="breadcrumbs">

        <div class="bg-surface w-full max-w-lg rounded-lg shadow-md">

            <Head title="Edit record" />

            <h2 class="mb-6 text-2xl font-semibold">Edit record</h2>

            <Form :action="update(record.id, { query: { url } })" class="space-y-4" v-slot="{ errors, processing }">
                <!-- Type -->
                <div class="flex flex-col">
                    <Label for="type" class="mb-1">Type</Label>
                    <select id="type" name="type" v-model="updatedType"
                        class="bg-background border-border focus:ring-primary rounded-md border p-2 focus:ring-2">
                        <option value="income">Income</option>
                        <option value="expense">Expense</option>
                    </select>
                    <InputError :message="errors.type" />
                </div>

                <!-- Name -->
                <div class="flex flex-col">
                    <Label for="name" class="mb-1">Name</Label>
                    <Input id="name" type="text" name="name" placeholder="Record name" required
                        class="bg-background border-border focus:ring-primary note rounded-md border p-2"
                        v-model="updatedName" />
                </div>

                <!-- Category -->
                <div class="flex flex-col">
                    <Label for="category_id" class="mb-1">Category</Label>
                    <CategoryPopover v-model="updatedCategory" :categoriesByGroup="categoriesByGroup"
                        :type="updatedType" />
                    <input type="text" v-model="updatedCategory.id" class="hidden" name="category_id">
                        <InputError :message="errors.category_id" />
                </div>

                <!-- Amount -->
                <div class="flex flex-col">
                    <Label for="amount" class="mb-1">Amount</Label>
                    <Input required id="amount" type="number" step="0.01" min="0" name="amount" placeholder="0.00"
                        class="bg-background border-border focus:ring-primary rounded-md border p-2 focus:ring-2"
                        v-model="updatedAmount" />
                    <InputError :message="errors.amount" />
                </div>

                <!-- Note -->
                <div class="flex flex-col">
                    <Label for="note" class="mb-1">Note</Label>
                    <Input id="note" type="text" name="note" placeholder="Optional note"
                        class="bg-background border-border focus:ring-primary note rounded-md border p-2"
                        v-model="updatedNote" />
                </div>

                <!-- Date picker -->
                <Popover>
                    <PopoverTrigger as-child>
                        <Button>
                            <CalendarIcon class="mr-2 h-4 w-4" />
                            {{ date ? date.toString() : "Pick a date" }}
                        </Button>
                    </PopoverTrigger>
                    <PopoverContent class="w-auto p-0">
                        <!-- note: change later -->
                        <Calendar v-model="date" :initial-focus="true" :default-placeholder="defaultPlaceholder"
                            layout="month-and-year" />
                    </PopoverContent>
                </Popover>
                <InputError :message="errors.date" />

                <input type="date" name="record_date" v-model="date" class="hidden">

                    <!-- Submit button -->
                    <div class="mt-4 flex justify-end">
                        <Button type="submit" :disabled="processing || !validateForm()">
                            <Spinner v-if="processing" />
                            Edit
                        </Button>
                    </div>
            </Form>
        </div>
    </AppLayoutWithGoToPrevious>

</template>
