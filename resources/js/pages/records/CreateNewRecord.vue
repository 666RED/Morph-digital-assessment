<script setup lang="ts">
import CategoryPopover from "@/components/CategoryPopover.vue";
import InputError from "@/components/InputError.vue";
import { Button } from "@/components/ui/button";
import Calendar from "@/components/ui/calendar/Calendar.vue";
import { Input } from "@/components/ui/input";
import Label from "@/components/ui/label/Label.vue";
import { PopoverContent, PopoverTrigger } from "@/components/ui/popover";
import Popover from "@/components/ui/popover/Popover.vue";
import { Spinner } from "@/components/ui/spinner";
import AppLayoutWithGoToPrevious from "@/layouts/AppLayoutWithGoToPrevious.vue";
import { index, store } from "@/routes/records";
import { BreadcrumbItem } from "@/types";
import { CategoriesByGroup, Category, RecordType } from "@/types/record";
import { Form, Head } from "@inertiajs/vue3";
import { DateValue, getLocalTimeZone, today } from "@internationalized/date";
import { CalendarIcon } from "lucide-vue-next";
import { ref } from "vue";

interface Props {
    categoriesByGroup: CategoriesByGroup;
}

const props = defineProps<Props>();
const { categoriesByGroup } = props;

const type = ref<RecordType>("expense");
const defaultPlaceholder = today(getLocalTimeZone());
const date = ref<DateValue>(defaultPlaceholder);
const category = ref<{ id: number, name: string }>({ id: 0, name: '' });
const name = ref<string>('');
const amount = ref<number>(0);
const note = ref<string>('');

const validateForm = () => {
    return name.value !== '' && type.value && date.value && amount.value && category.value.id !== 0
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: "Records",
        href: index().url
    },
];
</script>

<template>

    <Head title="Create new record" />

    <AppLayoutWithGoToPrevious :breadcrumbs="breadcrumbs">
        <div class="bg-surface w-full max-w-lg rounded-lg shadow-md">
            <h2 class="mb-6 text-2xl font-semibold">Create New Record</h2>

            <Form :action="store()" class="space-y-4" v-slot="{ errors, processing }">
                <!-- Type -->
                <div class="flex flex-col">
                    <Label for="type" class="mb-1">Type</Label>
                    <select id="type" name="type" v-model="type"
                        class="bg-background border-border focus:ring-primary rounded-md border p-2 focus:ring-2">
                        <option value="income">Income</option>
                        <option value="expense">Expense</option>
                    </select>
                    <InputError :message="errors.type" />
                </div>

                <!-- Name -->
                <div class="flex flex-col">
                    <Label for="name" class="mb-1">Name</Label>
                    <Input id="name" type="text" name="name" placeholder="Record name" required v-model="name"
                        class="bg-background border-border focus:ring-primary note rounded-md border p-2" />
                </div>

                <!-- Category -->
                <div class="flex flex-col">
                    <Label for="category_id" class="mb-1">Category</Label>
                    <CategoryPopover v-model="category" :categoriesByGroup="categoriesByGroup" :type="type" />
                    <input type="text" v-model="category.id" class="hidden" name="category_id">
                        <InputError :message="errors.category_id" />
                </div>

                <!-- Amount -->
                <div class="flex flex-col">
                    <Label for="amount" class="mb-1">Amount</Label>
                    <Input required id="amount" type="number" step="0.01" min="0" name="amount" placeholder="0.00"
                        v-model="amount"
                        class="bg-background border-border focus:ring-primary rounded-md border p-2 focus:ring-2" />
                    <InputError :message="errors.amount" />
                </div>

                <!-- Note -->
                <div class="flex flex-col">
                    <Label for="note" class="mb-1">Note</Label>
                    <Input id="note" type="text" name="note" placeholder="Optional note" v-model="note"
                        class="bg-background border-border focus:ring-primary note rounded-md border p-2" />
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
                            Create
                        </Button>
                    </div>
            </Form>
        </div>
    </AppLayoutWithGoToPrevious>
</template>
