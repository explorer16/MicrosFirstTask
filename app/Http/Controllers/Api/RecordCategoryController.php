<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecordCategoryRequest;
use App\Models\RecordCategory;
use App\Repositories\Interfaces\RecordCategoryRepositoryInterface;
use Illuminate\Http\Request;

class RecordCategoryController extends Controller
{
    private $repository;
    private $category;
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
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RecordCategoryRequest $request)
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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
