<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    /** @use HasFactory<\Database\Factories\RecordFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'category_id',
        'type',
        'amount',
        'note',
        'record_date'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'record_date' => 'date',
        'type' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    public function scopeForMonth($query, int $year, int $month)
    {
        return $query->whereYear('record_date', $year)
            ->whereMonth('record_date', $month);
    }
}
