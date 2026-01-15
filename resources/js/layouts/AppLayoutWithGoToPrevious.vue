<script setup lang="ts">
import GoPreviousArrow from '@/components/GoPreviousArrow.vue';
import AppLayout from './AppLayout.vue';
import { BreadcrumbItemType } from '@/types';

interface Props {
    url?: string,
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
})

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <GoPreviousArrow class="m-2" :url="url" />
        <div class="bg-background px-10 pb-6 text-white">
            <slot />
        </div>
    </AppLayout>
</template>
