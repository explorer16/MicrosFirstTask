<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecordCategoryRequest;
use App\Http\Resources\RecordCategoryCollection;
use App\Models\RecordCategory;
use App\Repositories\Interfaces\RecordCategoryRepositoryInterface;

class RecordCategoryController extends Controller
{
    private RecordCategoryRepositoryInterface $repository;
    private RecordCategory $category;
    public function __construct(
        RecordCategoryRepositoryInterface $recordCategoryRepository,
        RecordCategory $recordCategory
    )
    {
        $this->repository = $recordCategoryRepository;
        $this->category = $recordCategory;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $recordCategories = $this->repository->list($this->category);

        return response()->json(
            new RecordCategoryCollection($recordCategories)
        );
    }

    public function inventory(): \Illuminate\Http\JsonResponse
    {
        return response()->json(
            $this->repository->inventory($this->category)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RecordCategoryRequest $request): \Illuminate\Http\JsonResponse
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
    public function show(RecordCategory $recordCategory): \Illuminate\Http\JsonResponse
    {
        return response()->json($recordCategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RecordCategoryRequest $request, RecordCategory $recordCategory): \Illuminate\Http\JsonResponse
    {
        $this->repository->update($request, $recordCategory);

        return response()->json([
            'message' => 'Record Category updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        RecordCategory::destroy($id);

        return response()->json([
            'message' => 'Record Category deleted successfully',
        ]);
    }
}
