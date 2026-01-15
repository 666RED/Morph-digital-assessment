<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::upsert([
            // ===== Income =====
            [
                'name' => 'Income',
                'type' => 'income',
                'group' => 'Income',
                'color' => 'green',
                'icon' => 'Wallet',
            ],

            // ===== Expenses =====
            [
                'name' => 'Rent',
                'type' => 'expense',
                'group' => 'Living',
                'color' => 'orange',
                'icon' => 'Home',
            ],
            [
                'name' => 'Utilities',
                'type' => 'expense',
                'group' => 'Living',
                'color' => 'yellow',
                'icon' => 'Plug',
            ],
            [
                'name' => 'Internet',
                'type' => 'expense',
                'group' => 'Living',
                'color' => 'cyan',
                'icon' => 'Wifi',
            ],
            [
                'name' => 'Phone',
                'type' => 'expense',
                'group' => 'Living',
                'color' => 'sky',
                'icon' => 'Smartphone',
            ],
            [
                'name' => 'Groceries',
                'type' => 'expense',
                'group' => 'Food',
                'color' => 'emerald',
                'icon' => 'ShoppingCart',
            ],
            [
                'name' => 'Dining Out',
                'type' => 'expense',
                'group' => 'Food',
                'color' => 'red',
                'icon' => 'Utensils',
            ],
            [
                'name' => 'Entertainment',
                'type' => 'expense',
                'group' => 'Lifestyle',
                'color' => 'purple',
                'icon' => 'Film',
            ],
            [
                'name' => 'Shopping',
                'type' => 'expense',
                'group' => 'Lifestyle',
                'color' => 'pink',
                'icon' => 'ShoppingBag',
            ],
            [
                'name' => 'Healthcare',
                'type' => 'expense',
                'group' => 'Health',
                'color' => 'rose',
                'icon' => 'HeartPulse',
            ],
            [
                'name' => 'Insurance',
                'type' => 'expense',
                'group' => 'Health',
                'color' => 'indigo',
                'icon' => 'Shield',
            ],
            [
                'name' => 'Education',
                'type' => 'expense',
                'group' => 'Education',
                'color' => 'teal',
                'icon' => 'GraduationCap',
            ],
            [
                'name' => 'Subscriptions',
                'type' => 'expense',
                'group' => 'Lifestyle',
                'color' => 'violet',
                'icon' => 'Repeat',
            ],
            [
                'name' => 'Travel',
                'type' => 'expense',
                'group' => 'Lifestyle',
                'color' => 'amber',
                'icon' => 'Plane',
            ],
            [
                'name' => 'Gifts',
                'type' => 'expense',
                'group' => 'Social',
                'color' => 'fuchsia',
                'icon' => 'Gift',
            ],
            [
                'name' => 'Personal Care',
                'type' => 'expense',
                'group' => 'Lifestyle',
                'color' => 'lime',
                'icon' => 'Scissors',
            ],
            [
                'name' => 'Fitness',
                'type' => 'expense',
                'group' => 'Health',
                'color' => 'green',
                'icon' => 'Dumbbell',
            ],
            [
                'name' => 'Pets',
                'type' => 'expense',
                'group' => 'Lifestyle',
                'color' => 'orange',
                'icon' => 'PawPrint',
            ],
            [
                'name' => 'Maintenance',
                'type' => 'expense',
                'group' => 'Living',
                'color' => 'slate',
                'icon' => 'Wrench',
            ],
            [
                'name' => 'Other',
                'type' => 'expense',
                'group' => 'Miscellaneous',
                'color' => 'gray',
                'icon' => 'MoreHorizontal',
            ],
        ], ['name', 'type']); // upsert by name + type to avoid duplicates
    }
}
