<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { show } from "@/routes/records";
import { Record } from "@/types/record";
import Icon from "@/components/Icon.vue";

interface Props {
    record: Record;
    url: string;
}

const props = defineProps<Props>();

const { id, name, category, type, amount } = props.record;
</script>

<template>
    <Link class="flex flex-col gap-2" :href="show(id, { query: { url } })">
        <div class="flex justify-between items-center">
            <!-- Left part -->
            <div class="flex flex-1 items-center gap-4">
                <div class="bg-amber-300 rounded-full p-2">
                    <Icon :name="category.icon" :size="24" class="h-6 w-6" />
                </div>
                <span>{{ name }}</span>
            </div>
            <!-- Right part -->
            <span>{{ type == "expense" ? "-" + amount : "+" + amount }}</span>
        </div>
    </Link>
</template>
