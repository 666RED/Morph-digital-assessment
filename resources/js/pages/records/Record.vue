<script setup lang="ts">
import { Button } from "@/components/ui/button";
import { Record } from "@/types/record";
import { Head, Link } from "@inertiajs/vue3";
import {
    edit,
    destroy,
    index,
} from "@/routes/records";
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from "@/components/ui/alert-dialog";
import AppLayoutWithGoToPrevious from "@/layouts/AppLayoutWithGoToPrevious.vue";
import Icon from "@/components/Icon.vue";
import { BreadcrumbItem, BreadcrumbItemType } from "@/types";

const props = defineProps<Props>();
const { id, category, name, type, amount, record_date, note } =
    props.record;

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: "Records",
        href: index().url
    },
];

interface Props {
    record: Record;
    url: string;
}
</script>

<template>

    <Head title="Record details" />
    <AppLayoutWithGoToPrevious :url="url" :breadcrumbs="breadcrumbs">
        <div class="flex items-center gap-4 mb-6">
            <Icon :name="category.icon" size="28" class="h-7 w-7" />
            <span class="text-2xl">{{ name }}</span>
        </div>
        <div class="grid grid-cols-4 gap-y-4 [&>*:nth-child(even)]:col-span-3">
            <span>Type</span>
            <span>{{ type }}</span>
            <span>Amount</span>
            <span>{{ amount }}</span>
            <span>Date</span>
            <span>
                <div>{{ new Date(record_date).toLocaleDateString() }}</div>
            </span>
            <span>Note</span>
            <span>{{ note ?? "-" }}</span>
        </div>

        <div class="absolute right-0 bottom-4 left-0 flex items-center">
            <!-- Edit button -->
            <Button class="flex-1" variant="ghost" asChild>
                <Link :href="edit(id, { query: { url } })"> Edit </Link>
            </Button>

            <!-- Delete button -->
            <AlertDialog>
                <AlertDialogTrigger asChild>
                    <Button class="flex-1" variant="destructive">
                        Delete
                    </Button>
                </AlertDialogTrigger>
                <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle>Delete this record?</AlertDialogTitle>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                        <AlertDialogAction>
                            <Link :href="destroy(id)">Delete</Link>
                        </AlertDialogAction>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        </div>
    </AppLayoutWithGoToPrevious>
</template>
