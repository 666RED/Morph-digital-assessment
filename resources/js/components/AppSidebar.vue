<script setup lang="ts">
import NavFooter from "@/components/NavFooter.vue";
import NavMain from "@/components/NavMain.vue";
import NavUser from "@/components/NavUser.vue";
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from "@/components/ui/sidebar";
import { type NavItem } from "@/types";
import { Link } from "@inertiajs/vue3";
import { ChartPie, Coins, Folder, LayoutGrid, Box } from "lucide-vue-next";
import AppLogo from "./AppLogo.vue";
import { index as categories } from "@/routes/categories";
import { index as records } from "@/routes/records";
import { index as charts } from '@/actions/App/Http/Controllers/ChartController'
import { getCurrentMonth, getCurrentYear } from "@/lib/utils";
// import { index as charts } from "@/routes/charts";

const mainNavItems: NavItem[] = [
    {
        title: "Records",
        href: records({
            query: {
                year: getCurrentYear(),
                month: getCurrentMonth()
            }
        }),
        icon: Coins
    },
    {
        title: "Categories",
        href: categories(),
        icon: Box
    },
    {
        title: "Charts",
        href: charts({ query: { year: getCurrentYear(), month: getCurrentMonth(), type: 'expense' } }),
        icon: ChartPie
    }
];

const footerNavItems: NavItem[] = [
    {
        title: "Github Repo",
        href: "https://github.com/666RED/Morph-digital-assessment.git",
        icon: Folder,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="records()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
