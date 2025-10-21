<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RecordCategory extends Model
{
    protected $table = 'record_categories';
    protected $fillable = ['name', 'type'];

    public function scopeSort($query)
    {
        return $query->orderBy(request()->input('column', 'id'), request()->input('direction', 'desc'));
    }

    public function scopeFilter($query)
    {
        if ($filter = request('name')) {
            $query = $query->where('name', 'ilike', '%' . $filter . '%');
        }
        if ($filter = request('type')) {
            $query = $query->where('type', $filter);
        }

        return $query;
    }

    public function records(): HasMany
    {
        return $this->hasMany(Record::class, 'record_category_id', 'id');
    }
}
