<script setup lang="ts">
import { create, index } from "@/routes/records";
import { BreadcrumbItem } from "@/types";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import RecordListItem from "./components/RecordListItem.vue";
import { Record } from "@/types/record";
import AppLayoutWithoutGoToPrevious from "@/layouts/AppLayoutWithoutGoToPrevious.vue";
import Button from "@/components/ui/button/Button.vue";
import { Input } from "@/components/ui/input";
import { computed, onMounted, ref } from "vue";

interface Props {
    records: Record[][];
    year: number,
    month: number
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: "Records",
        href: index().url,
    },
];

const year = ref<number>(props.year);
const month = ref<number>(props.month);

const selectedYearAndMonth = computed({
    get() {
        return `${year.value}-${String(month.value).padStart(2, '0')}`
    },
    set(value: string) {
        const [y, m] = value.split('-')
        year.value = Number(y)
        month.value = Number(m)
    },
})

const page = usePage();
const url = page.url;

const getRecords = () => {
    const year = selectedYearAndMonth.value.slice(0, 4);
    const month = Number(selectedYearAndMonth.value.slice(5));
    router.get(index({ query: { year, month } }), {}, { preserveScroll: true, preserveState: true })
}
</script>

<template>

    <Head title="Records" />

    <AppLayoutWithoutGoToPrevious :breadcrumbs="breadcrumbs">
        <div class="flex items-center justify-between mb-6 mt-4 gap-x-4">
            <!-- Month picker -->
            <Input type="month" class="w-auto" v-model="selectedYearAndMonth" @input="getRecords()" />
            <!-- Create button -->
            <div class="flex justify-end">
                <Button asChild>
                    <Link :href="create()"
                        class="inline-flex items-center px-4 py-2 rounded-lg shadow hover:shadow-md border border-gray-200 transition">
                        <span>Create New</span>
                    </Link>
                </Button>
            </div>
        </div>

        <!-- Records -->
        <div v-for="record in records" :key="record[0].record_date">
            <div class="mb-6">
                <div class="flex flex-col gap-y-4">
                    <!-- Upper part -->
                    <div class="flex items-center justify-between border-b border-b-gray-500 text-sm">
                        <span>{{ new Date(record[0].record_date).toLocaleDateString() }}</span>
                        <span>{{"Total: " + record.reduce(
                            (acc, current) => {
                                if (current.type === 'income') {
                                    return acc + Number(
                                        current.amount
                                    );
                                } else { return acc - Number(current.amount); }
                            }, 0,).toFixed(2)
                        }}</span>
                    </div>
                    <!-- Bottom part -->
                    <div v-for="r in record" :key="r.id">
                        <RecordListItem :record="r" :url="url" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayoutWithoutGoToPrevious>
</template>
