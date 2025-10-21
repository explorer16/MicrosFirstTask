<?php

namespace App\Repositories\Eloquent;

use App\Http\Requests\RecordRequest;
use App\Models\Record;
use App\Models\RecordCategory;
use App\Repositories\Interfaces\RecordRepositoryInterface;

class RecordRepository implements RecordRepositoryInterface
{

    public function list(Record $record)
    {
        $records = Record::with('category')->filter()->sort();

        return $records->paginate(request('per_page', 20));
    }

    public function create(RecordRequest $request): void
    {
        $id = Record::orderBy('id', 'desc')->value('id') ?? 0;
        $total_amount = $this->getTotalAmount($request->record_category_id, $request->amount, ++$id);

        Record::query()->create([
            'record_category_id' => $request->record_category_id,
            'amount' => $request->amount,
            'total_amount' => $total_amount,
            'comment' => $request->comment,
            'date' => $request->date,
        ]);
    }

    public function update(RecordRequest $request, Record $record): void
    {
        $this->changeRecord($request->all(), $record);
    }

    public function delete(int $id): void
    {
        $record = Record::query()->findOrFail($id);
        $record->delete();

        if ($next_record = Record::where('id', '>', $record->id)->orderBy('id', 'asc')->first()) {
            $this->changeRecord([
                'record_category_id' => $next_record->record_category_id,
                'amount' => $next_record->amount,
                'comment' => $next_record->comment,
                'date' => $next_record->date,
            ], $next_record);
        }
    }

    private function getTotalAmount(int $category_id, int $amount, int $current_id): int
    {
        $category = RecordCategory::find($category_id);

        $prev_amount = Record::where('id', '<', $current_id)
            ->orderBy('id', 'desc')
            ->value('total_amount') ?? 0;

        if ($category->type === 'incoming') return ($prev_amount + $amount);
        if ($category->type === 'outgoing') return ($prev_amount - $amount);

        return $prev_amount; // на случай неизвестного типа
    }

    private function changeRecord(array $request, Record $record): void
    {
        $total_amount = $this->getTotalAmount($request['record_category_id'], $request['amount'], $record->id);

        $old_total_amount = $record->total_amount;

        $record->update([
            'record_category_id' => $request['record_category_id'],
            'amount' => $request['amount'],
            'total_amount' => $total_amount,
            'comment' => $request['comment'],
            'date' => $request['date'],
        ]);

        if ($old_total_amount !== $total_amount) {
            if ($next_record = Record::where('id', '>', $record->id)->orderBy('id', 'asc')->first()) {
                $this->changeRecord([
                    'record_category_id' => $next_record->record_category_id,
                    'amount' => $next_record->amount,
                    'comment' => $next_record->comment,
                    'date' => $next_record->date,
                ], $next_record);
            }
        }
    }
}
