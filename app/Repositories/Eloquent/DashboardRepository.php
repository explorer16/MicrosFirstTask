<?php

namespace App\Repositories\Eloquent;

use App\Models\Record;
use App\Repositories\Interfaces\DashboardRepositoryInterface;

class DashboardRepository implements DashboardRepositoryInterface
{
    const MONTH_COUNT = 6;
    public function lineChartData()
    {
        $data = [
            'data' => [
                'incoming' => [
                    'name' => 'Приход'
                ],
                'outgoing' => [
                    'name' => 'Расход'
                ],
            ],
            'months' => []
        ];
        for($i = self::MONTH_COUNT; $i > 0; $i--) {
            $date = now()->subMonths($i - 1);

            $monthName = $date->translatedFormat('F');
            $year = now()->subMonths($i - 1)->year;

            $data['data']['incoming']['data'][] = Record::query()
                ->whereHas('category', function ($query) {
                    $query->where('type', 'incoming');
                })
                ->whereYear('date', $year)
                ->whereMonth('date', $date->month)
                ->sum('amount');
            $data['data']['outgoing']['data'][] = Record::query()
                ->whereHas('category', function ($query) {
                    $query->where('type', 'outgoing');
                })
                ->whereYear('date', $year)
                ->whereMonth('date', $date->month)
                ->sum('amount');
            $data['months'][] = $monthName;
        }

        return $data;
    }

    public function donutChartData()
    {
        $incoming_data = Record::whereHas('category', function ($query) {
            $query->where('type', 'incoming');
        })->sum('amount');
        $outgoing_data = Record::whereHas('category', function ($query) {
            $query->where('type', 'outgoing');
        })->sum('amount');
        return [
            'data' => [
                'incoming' => $incoming_data,
                'outgoing' => $outgoing_data
            ],
            'labels' => ['Приход', 'Расход']
        ];
    }
}
