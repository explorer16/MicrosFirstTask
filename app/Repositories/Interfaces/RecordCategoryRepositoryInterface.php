<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\RecordCategoryRequest;
use App\Models\RecordCategory;

interface RecordCategoryRepositoryInterface
{
    public function list();
    public function create(RecordCategoryRequest $request);
    public function update(RecordCategory $recordCategory);
}
