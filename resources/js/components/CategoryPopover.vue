<script setup lang="ts">
import { Button } from '@/components/ui/button'
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogTrigger,
} from '@/components/ui/dialog'
import { CategoriesByGroup, RecordType } from '@/types/record';
import Icon from './Icon.vue';
import { computed, watch } from 'vue';

interface Props {
    type: RecordType;
    modelValue: { id: number, name: string } | null;
    categoriesByGroup: CategoriesByGroup;
}

const props = defineProps<Props>();

const categories = computed(() => {
    if (props.type === 'income') {
        return { "Income": props.categoriesByGroup["Income"] };
    } else {
        const { Income, ...expense } = props.categoriesByGroup;
        return expense
    }
})

watch(() => props.type, () => {
    emit('update:modelValue', { id: 0, name: '' });
})

const emit = defineEmits<{ 'update:modelValue': (selected: { id: number, name: string }) => void }>();

function selectCategory(selected) {
    emit('update:modelValue', selected);
}
</script>

<template>
    <Dialog>
        <!-- Trigger button -->
        <DialogTrigger as-child>
            <Button variant="outline">
                {{ modelValue.name === '' ? 'Select a category' : modelValue.name }}
            </Button>
        </DialogTrigger>

        <!-- Dialog content -->
        <DialogContent class="sm:max-w-130 max-h-[70vh] overflow-y-auto p-4">
            <!-- Categories grouped -->
            <div v-for="(cats, group) in categories" :key="group" class="mb-4">
                <!-- Group title -->
                <h3 class="font-semibold mb-2 text-sm border-b border-gray-200 pb-1">
                    {{ group }}
                </h3>

                <!-- Categories grid -->
                <div class="grid grid-cols-3 gap-3">
                    <DialogClose v-for="category in cats" :key="category.id"
                        class="flex flex-col items-center p-2 rounded-lg hover:bg-gray-500 cursor-pointer transition group"
                        :class="{
                            'ring-2 ring-blue-500': category.id === modelValue.id
                        }" @click="selectCategory({ id: category.id, name: category.name })">
                        <div class="rounded-full p-3 mb-1">
                            <Icon :name="category.icon" :size="24" class="h-6 w-6" />
                        </div>
                        <span class="text-xs text-center truncate">{{ category.name }}</span>
                    </DialogClose>
                </div>
            </div>
        </DialogContent>
    </Dialog>
</template>
