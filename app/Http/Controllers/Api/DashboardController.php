<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\DashboardRepositoryInterface;

class DashboardController extends Controller
{
    private $repository;
    public function __construct(DashboardRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {
        return response()->json([
            'lineChart' => $this->repository->lineChartData(),
            'donutChart' => $this->repository->donutChartData()
        ]);
    }
}
