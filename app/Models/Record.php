<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Record extends Model
{
    use SoftDeletes;
    protected $fillable = ['record_category_id', 'amount', 'comment', 'date'];

    public function scopeSort($query)
    {
        return $query->orderBy(
            request('column', 'id'),
            request('direction', 'desc')
        );
    }

    public function scopeFilter($query)
    {
        if ($filter = request('id')) {
            $query = $query->where('id', 'like', '%' . $filter . '%');
        }
        if ($filter = request('record_category')) {
            $query = $query->whereHas('record_category', function ($query) use ($filter) {
                $query->where('id', $filter);
            });
        }
        if ($filter = request('amount')) {
            $query = $query->where('amount', 'like', '%' . $filter . '%');
        }
        if ($filter = request('date')) {
            $query = $query->whereDate('date', $filter);
        }

        return $query;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(RecordCategory::class);
    }
}
