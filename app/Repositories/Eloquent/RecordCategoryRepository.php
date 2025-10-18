<?php

namespace App\Repositories\Eloquent;

use App\Http\Requests\RecordCategoryRequest;
use App\Models\RecordCategory;
use App\Repositories\Interfaces\RecordCategoryRepositoryInterface;

class RecordCategoryRepository implements RecordCategoryRepositoryInterface
{

    public function list(RecordCategory $recordCategory)
    {
        $recordCategory = $recordCategory->filter()->sort();

        return $recordCategory->paginate();
    }

    public function inventory(RecordCategory $recordCategory): array
    {
        $recordIncomingCategories = $recordCategory->where('type', 'incoming')->select('id', 'name');
        $recordOutgoingCategories = $recordCategory->where('type', 'outgoing')->select('id', 'name');

        return [
            'incoming' => $recordIncomingCategories->get(),
            'outgoing' => $recordOutgoingCategories->get()
        ];
    }
    public function create(RecordCategoryRequest $request): void
    {
        RecordCategory::query()->create($request->all());
    }

    public function update(RecordCategoryRequest $request, RecordCategory $recordCategory): void
    {
        $recordCategory->update($request->all());
    }
}
