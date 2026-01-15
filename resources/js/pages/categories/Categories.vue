<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { BreadcrumbItem } from "@/types";
import { Head, Link, usePage } from "@inertiajs/vue3";
import { index, create } from "@/routes/categories";
import { CategoriesByGroup } from "@/types/record";
import Icon from "@/components/Icon.vue";
import { Button } from "@/components/ui/button";

interface Props {
    categoriesByGroup: CategoriesByGroup;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: "Categories",
        href: index().url,
    },
];

const page = usePage();
const user = page.props.auth.user;
</script>

<template>

    <Head title="Categories" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-4 px-4">
            <!-- Create button -->
            <!-- <div class="mb-6 flex justify-end"> -->
            <!--     <Button asChild> -->
            <!--         <Link :href="create()" -->
            <!--             class="inline-flex items-center px-4 py-2 rounded-lg shadow hover:shadow-md border border-gray-200 transition"> -->
            <!--             <span>Create New</span> -->
            <!--         </Link> -->
            <!--     </Button> -->
            <!-- </div> -->

            <div v-for="(categories, group) in categoriesByGroup" :key="group" class="mb-10 text-white">
                <h2 class="text-xl font-semibold mb-4 border-b border-gray-200 pb-2">{{ group }}</h2>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                    <div v-for="category in categories" :key="category.id"
                        class="flex flex-col items-center p-4 rounded-xl shadow-sm hover:shadow-lg transition cursor-pointer group">
                        <div class="rounded-full p-4 mb-2">
                            <Icon :name="category.icon" :size="28" class="h-7 w-7" />
                        </div>

                        <span class="font-medium text-center">{{ category.name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
