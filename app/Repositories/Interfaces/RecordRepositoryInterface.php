<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\RecordRequest;
use App\Models\Record;

interface RecordRepositoryInterface
{
    public function list(Record $record);
    public function create(RecordRequest $request);
    public function update(RecordRequest $request, Record $record);
}
