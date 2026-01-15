<script setup lang="ts">
import AppLayoutWithGoToPrevious from '@/layouts/AppLayoutWithGoToPrevious.vue';
import { index } from '@/routes/charts';
import { BreadcrumbItem } from '@/types';
import { Category, Record } from '@/types/record';
import { Head, usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import RecordListItem from '../records/components/RecordListItem.vue';

interface Props {
    category: Category;
    records: Record[][];
    total_amount: number;
    url: string
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: "Records",
        href: index().url
    },
];

const page = usePage();
const currentPageUrl = page.url;
</script>

<template>

    <Head title="Records in a single category" />

    <AppLayoutWithGoToPrevious :breadcrumbs="breadcrumbs" :url="url">

        <div class="bg-surface w-full max-w-lg rounded-lg shadow-md">
            <h2 class="mb-6 text-2xl font-semibold">Category Records Details</h2>
            <!-- Total amount -->
            <span class="text-xl">Total: {{ total_amount.toFixed(2) }}</span>

            <!-- Records -->
            <div v-for="record in records" :key="record[0].record_date" class="mt-4">
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
                            <RecordListItem :record="r" :url="currentPageUrl" />
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </AppLayoutWithGoToPrevious>
</template>
