<?php

namespace App\Repositories\Eloquent;

use App\Http\Requests\RecordCategoryRequest;
use App\Models\RecordCategory;
use App\Repositories\Interfaces\RecordCategoryRepositoryInterface;

class RecordCategoryRepository implements RecordCategoryRepositoryInterface
{

    public function list()
    {
        // TODO: Implement list() method.
    }

    public function create(RecordCategoryRequest $request)
    {
        RecordCategory::query()->create($request->all());
    }

    public function update(RecordCategory $recordCategory)
    {
        // TODO: Implement update() method.
    }
}
