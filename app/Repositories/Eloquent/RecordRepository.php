<?php

namespace App\Repositories\Eloquent;

use App\Http\Requests\RecordRequest;
use App\Models\Record;
use App\Repositories\Interfaces\RecordRepositoryInterface;

class RecordRepository implements RecordRepositoryInterface
{

    public function list(Record $record)
    {
        $records = $record->filter()->sort();

        return $records->paginate(request('per_page', 20));
    }

    public function create(RecordRequest $request): void
    {
        Record::query()->create($request->all());
    }

    public function update(RecordRequest $request, Record $record): void
    {
        $record->update($request->all());
    }
}
