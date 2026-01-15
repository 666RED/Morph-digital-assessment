<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { ButtonGroup } from '@/components/ui/button-group';
import AppLayoutWithoutGoToPrevious from '@/layouts/AppLayoutWithoutGoToPrevious.vue';
import { index } from '@/routes/charts';
import { BreadcrumbItem } from '@/types';
import { router } from '@inertiajs/vue3';
import { VisBulletLegend, VisDonut, VisSingleContainer, } from '@unovis/vue'
import { computed, onMounted, ref, useTemplateRef } from 'vue';
import { getCurrentYear, MONTHS } from '@/lib/utils';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/components/ui/carousel';
import { Card, CardContent } from '@/components/ui/card';
import Icon from '@/components/Icon.vue';
import { DataRecord, RecordType } from '@/types/record';
import CategoryListItem from './CategoryListItem.vue';
import Spinner from '@/components/ui/spinner/Spinner.vue';

interface Props {
    type: RecordType,
    groups: DataRecord[];
    total: string;
    month: number;
    year: number;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: "Charts",
        href: index().url,
    },
];


const goToMonth = (month: number) => {
    groups.value = [];
    loading.value = true;

    router.get(index({
        query: {
            year: selectedYear.value,
            month,
            type: type.value,
        }
    }), {}, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (data) => {
            groups.value = data.props.groups as DataRecord[];
            loading.value = false;
        }
    });
}

const goToYear = (year: number) => {
    groups.value = [];
    loading.value = true;

    router.get(
        index({
            query: {
                year,
                month: selectedMonth.value,
                type: type.value,
            }
        }),
        {},
        {
            preserveScroll: true,
            preserveState: true,
            onSuccess: (data) => {
                groups.value = data.props.groups as DataRecord[];
                loading.value = false;
            }
        }
    );
}

const switchType = () => {
    groups.value = [];
    loading.value = true;
    router.get(
        index({
            query: {
                year: selectedYear.value,
                month: selectedMonth.value,
                type: type.value,
            }
        }),
        {},
        {
            preserveScroll: true,
            preserveState: true,
            onSuccess: (data) => {
                groups.value = data.props.groups as DataRecord[];
                loading.value = false;
            }
        }
    );
}

const props = defineProps<Props>();

const type = ref<string>(props.type);
const CURRENT_YEAR = getCurrentYear();
const yearIndex = ref<number>(CURRENT_YEAR === props.year ? 1 : Math.ceil((CURRENT_YEAR - props.year + 1) / 5));
const selectedYear = ref<number>(props.year);
const selectedMonth = ref<number>(props.month)
const groups = ref<DataRecord[]>(props.groups);
const loading = ref<boolean>(false);

const years = computed(() => {
    const length = 5 * yearIndex.value;
    return Array.from({ length }, (_, i) => CURRENT_YEAR - (length - 1 - i))
}
)

const data = computed(() => {
    return props.groups;
});

const legendItems = computed(() =>
    data.value.map(d => ({
        label: d.group,
        value: d.total_amount,
        percentage: ((d.total_amount / Number(props.total)) * 100).toFixed(1) + '%',
    }))
);

</script>
<template>
    <AppLayoutWithoutGoToPrevious :breadcrumbs="breadcrumbs">
        <div class='flex flex-col gap-y-4 py-2 px-4'>
            <!-- Type -->
            <ButtonGroup class="w-full flex items-center gap-x-2 bg-background text-white">
                <Button class="flex-1" @click="type = 'income'; switchType()"
                    :class="type === 'income' ? 'bg-neutral-600' : 'bg-background'" variant="secondary">
                    Income
                </Button>
                <Button class="flex-1" @click="type = 'expense'; switchType()"
                    :class="type === 'expense' ? 'bg-neutral-600' : 'bg-background'" variant="secondary">
                    Expense
                </Button>
            </ButtonGroup>
            <!-- Year -->
            <Carousel ref="yearCarousel" :opts="{
                startIndex: years.findIndex(year => year === selectedYear),
            }">
                <CarouselContent class="flex items-center">
                    <CarouselItem class="basis-12 shrink-0 flex items-center justify-center" @click="yearIndex++">
                        <Icon name="ArrowLeft" size="24" class="h-6 w-6 cursor-pointer" />
                    </CarouselItem>
                    <CarouselItem v-for="(year, index) in years" :key="index"
                        class="basis-1/3 select-none cursor-pointer" @click="selectedYear = year; goToYear(year);">
                        <div class="p-1">
                            <Card :class="{ 'bg-neutral-600': selectedYear === year }">
                                <CardContent class="flex items-center justify-center">
                                    <span>{{ year }}</span>
                                </CardContent>
                            </Card>
                        </div>
                    </CarouselItem>
                </CarouselContent>
            </Carousel>
            <!-- Month -->
            <Carousel :opts="{
                startIndex: Number(props.month) - 3
            }">
                <CarouselContent>
                    <CarouselItem v-for="(month, index) in MONTHS" :key="index"
                        class="basis-1/5 select-none cursor-pointer"
                        @click="selectedMonth = index + 1; goToMonth(index + 1)">
                        <div class="p-1">
                            <Card :class="{ 'bg-neutral-600': selectedMonth === index + 1 }">
                                <CardContent class="flex items-center justify-center">
                                    <span>{{ month }}</span>
                                </CardContent>
                            </Card>
                        </div>
                    </CarouselItem>
                </CarouselContent>
                <CarouselPrevious />
                <CarouselNext />
            </Carousel>
            <!-- Donut -->
            <div class="grid grid-cols-2 gap-x-6 items-center">
                <VisSingleContainer>
                    <VisDonut :value="d => d.total_amount" :data="data" :showEmptySegments="true" :padAngle="0.01"
                        :arcWidth="70" :centralLabel="total" labelFontSize="large" />
                </VisSingleContainer>
                <VisBulletLegend :items="legendItems.map(i => ({
                    name: `${i.label} (${i.percentage})`,
                }))" orientation="vertical" labelFontSize="large" />
            </div>
            <!-- Group -->
            <Spinner v-if="loading" class="size-8 mx-auto my-20" />
            <div v-else v-for="(group, index) in groups" :key="index">
                <div class="mb-6">
                    <!-- Group and total -->
                    <div class="flex items-center justify-between border-b mb-2 border-b-gray-500 text-sm">
                        <span class="text-lg">{{ group.group }}</span>
                        <span>{{
                            "Total: " +
                            group.total_amount.toFixed(2)
                            }}</span>
                    </div>
                    <!-- Categories -->
                    <div class="flex flex-col gap-y-4">
                        <div v-for="category in group.categories" :key="category.category_id">
                            <CategoryListItem :category="category" :category_total="group.total_amount"
                                :month="selectedMonth" :year="selectedYear" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayoutWithoutGoToPrevious>
</template>
