<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecordRequest;
use App\Http\Requests\UpdateRecordRequest;
use App\Models\Category;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $year = (int) $request->input('year', now()->year);
        $month = (int) $request->input('month', now()->month);

        $records = Record::with('category:id,name,icon,color')
            ->select('id', 'name', 'category_id', 'record_date', 'type', 'amount')
            ->when($year && $month, function ($query) use ($year, $month) {
                $query->whereYear('record_date', $year)
                    ->whereMonth('record_date', $month);
            })
            ->orderBy('record_date', 'desc')
            ->get()
            ->groupBy('record_date')
            ->map(fn($group) => $group->values())
            ->values();

        return Inertia::render('records/Records', ['records' => $records, 'year' => $year, 'month' => $month]);
    }

    /**
        //
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoriesByGroup = Category::select('id', 'group', 'name', 'icon', 'color', 'type')->orderBy('group')->orderBy('name')->get()->groupBy('group');
        return Inertia::render('records/CreateNewRecord', ['categoriesByGroup' => $categoriesByGroup]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecordRequest $request): RedirectResponse
    {
        $record = Record::create([
            ...$request->validated(),
            'user_id' => Auth::id(),
        ]);

        $record->save();

        return redirect()->route('records.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Record $record)
    {
        $url = $request->input('url');
        $category = Category::find($record->category_id);
        $record->category = $category;
        return Inertia::render("records/Record", ['record' => $record, 'url' => $url]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Record $record)
    {
        $url = $request->input('url');
        $categoriesByGroup = Category::select('id', 'group', 'name', 'icon', 'color', 'type')->orderBy('group')->orderBy(
            'name',
        )->get()->groupBy('group');
        $record = Record::with('category')->findOrFail($record->id);
        return Inertia::render("records/EditRecord", ['record' => $record, 'categoriesByGroup' => $categoriesByGroup, 'url' => $url]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecordRequest $request, Record $record): RedirectResponse
    {
        $url = $request->input('url');
        $record->update($request->validated());
        return redirect()->route('records.show', ['record' => $record, 'url' => $url])->with('success', 'Record updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Record $record): RedirectResponse
    {
        $record->delete();

        return redirect()->route('records.index')->with('success', 'Record deleted');
    }
}
