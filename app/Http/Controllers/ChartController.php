<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Record;
use Carbon\Month;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ChartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type = $request->input('type', 'expense');
        $year = (int) $request->input('year', now()->year);
        $month = (int) $request->input('month', now()->month);

        $records = Category::join('records', 'records.category_id', '=', 'categories.id')
            ->whereNotNull('categories.group')
            ->when($type, function ($query, $type) {
                return $query->where('records.type', $type);
            })
            ->when($year && $month, function ($query) use ($year, $month) {
                return $query->whereYear('records.record_date', $year)
                    ->whereMonth('records.record_date', $month);
            })
            ->select(
                'records.*',
                'categories.group as category_group',
                'categories.name as category_name',
                'categories.icon as icon'
            )
            ->get();

        $grouped = $records->groupBy('category_group')->map(function ($groupRecords, $group) {
            $categories = $groupRecords->groupBy('category_name')->map(function ($categoryRecords, $categoryName) {
                return [
                    'name' => $categoryName,
                    'total_amount' => $categoryRecords->sum('amount'),
                    'category_id' => $categoryRecords->first()->category_id,
                    'icon' => $categoryRecords->first()->icon
                ];
            })->values();

            return [
                'group' => $group,
                'total_amount' => $groupRecords->sum('amount'),
                'categories' => $categories,
            ];
        })->values();

        $total = Record::query()
            ->when($type, fn($q) => $q->where('type', $type))
            ->when($year && $month, fn($q) => $q->whereYear('record_date', $year)
                ->whereMonth('record_date', $month))
            ->sum('amount');

        return Inertia::render('charts/Index', ['groups' => $grouped, 'total' => $total, 'month' => $month, 'year' => $year, 'type' => $type]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Record $record)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Record $record)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Record $record)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Record $record)
    {
        //
    }

    public function displayRecordsInCategory(Request $request)
    {
        $categoryId = $request->route('id');
        $month = (int) $request->input('month', now()->month);
        $year = (int) $request->input('year', now()->year);
        $url = $request->input(
            'url',
        );

        $category = Category::select('id', 'name', 'icon', 'color')->findOrFail($categoryId);

        $records = Record::with('category:id,name,icon,color')->select('id', 'name', 'category_id', 'record_date', 'type', 'amount')
            ->where('category_id', $categoryId)
            ->whereYear('record_date', $year)
            ->whereMonth('record_date', $month)
            ->orderBy('record_date', 'desc')
            ->get()
            ->groupBy(fn($record) => $record->record_date->format('Y-m-d'))
            ->map(fn($group) => $group->values())
            ->values();

        $totalAmount = $records
            ->flatten()
            ->sum('amount');

        return Inertia::render('categories/CategoryRecords', ['category' => $category, 'total_amount' => $totalAmount, 'records' => $records, 'url' => $url]);
    }
}
