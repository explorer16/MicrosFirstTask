<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Record extends Model
{
    use SoftDeletes;
    protected $fillable = ['record_category_id', 'amount', 'comment', 'date'];
}
