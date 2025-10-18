<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\RecordCategoryRequest;
use App\Models\RecordCategory;

interface RecordCategoryRepositoryInterface
{
    public function list(RecordCategory $recordCategory);
    public function inventory(RecordCategory $recordCategory);
    public function create(RecordCategoryRequest $request);
    public function update(RecordCategoryRequest $request, RecordCategory $recordCategory);
}
