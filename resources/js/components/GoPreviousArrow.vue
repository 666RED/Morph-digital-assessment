<script setup lang="ts">
import { cn } from '@/lib/utils';
import { ArrowLeftIcon } from 'lucide-vue-next';
import { computed } from 'vue';

interface Props {
    url?: string;
    class?: string;
    color?: string;
    size?: number;
}

const props = withDefaults(defineProps<Props>(), {
    class: '',
    size: 24,
    color: 'white',
    url: '',
})

const className = computed(() => cn('cursor-pointer', props.class))

const goBack = () => {
    if (props.url !== '') {
        window.location.href = props.url;
    } else {
        window.history.back();
    }
}

</script>
<template>
    <ArrowLeftIcon :class="className" :size="size" :color="color" @click="goBack()" />
</template>
