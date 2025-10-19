<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecordRequest;
use App\Http\Resources\RecordCollection;
use App\Models\Record;
use App\Repositories\Interfaces\RecordRepositoryInterface;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    private RecordRepositoryInterface $repository;
    private Record $record;
    public function __construct(
        RecordRepositoryInterface $recordRepository,
        Record $record
    )
    {
        $this->repository = $recordRepository;
        $this->record = $record;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $recordCategories = $this->repository->list($this->record);

        return response()->json(
            new RecordCollection($recordCategories)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RecordRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->repository->create($request);

        return response()->json([
            'message' => 'Record category created successfully',
            'code' => 200
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Record $record): \Illuminate\Http\JsonResponse
    {
        return response()->json($record);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RecordRequest $request, Record $record): \Illuminate\Http\JsonResponse
    {
        $this->repository->update($request, $record);

        return response()->json([
            'message' => 'Record Category updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        Record::destroy($id);

        return response()->json([
            'message' => 'Record Category deleted successfully',
        ]);
    }
}
