<script setup lang="ts">
import { displayRecordsInCategory } from '@/actions/App/Http/Controllers/ChartController';
import Icon from '@/components/Icon.vue';
import Progress from '@/components/ui/progress/Progress.vue';
import { DataRecordCategory } from '@/types/record';
import { Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted, ref, toRef, toRefs } from 'vue';

interface Props {
    category: DataRecordCategory
    category_total: number;
    year: number
    month: number,
}

const props = defineProps<Props>();
const category = props.category;

const categoryId = ref<number>(category.category_id);
const name = ref<string>(category.name);
const totalAmount = ref<number>(category.total_amount);
const icon = ref<string>(category.icon);

const percentage = computed(() => {
    return totalAmount.value / props.category_total
})

const page = usePage()
const url = page.url;

</script>

<template>
    <Link :href="displayRecordsInCategory(categoryId, { query: { month, year, url } })">
        <div class="flex justify-between">
            <!-- Left part -->
            <div class="flex flex-1 items-center gap-4">
                <div class="bg-amber-300 rounded-full p-2">
                    <Icon :name="icon" :size="24" class="h-6 w-6" />
                </div>
                <div class=" flex flex-col gap-y-1 flex-1">
                    <div>
                        <span class="mr-2">{{ name }}</span>
                        <span>({{ (percentage * 100).toFixed(2) }}%)</span>
                    </div>
                    <Progress :modelValue="percentage * 100" class="w-[70%]" />
                </div>
            </div>
            <!-- Right part -->
            <span>{{ totalAmount.toFixed(2) }}</span>
        </div>
    </Link>
</template>
