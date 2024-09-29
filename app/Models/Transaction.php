<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'amount',
        'note',
        'date',
        'image',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeExpense($query)
    {
        return $query->whereHas('category', function ($query) {
            $query->where('is_expense', true);
        });
    }
    public function
    scopeIncome($query)
    {
        return $query->whereHas('category', function ($query) {
            $query->where('is_expense', false);
        });
    }
}
