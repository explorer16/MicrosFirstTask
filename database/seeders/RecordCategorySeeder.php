<?php

namespace Database\Seeders;

use App\Models\RecordCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecordCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RecordCategory::query()->create([
            'name' => 'Заработная плата',
            'type' => 'incoming'
        ]);
        RecordCategory::query()->create([
            'name' => 'Иные доходы',
            'type' => 'incoming'
        ]);
        RecordCategory::query()->create([
            'name' => 'Продукты питания',
            'type' => 'outcoming'
        ]);
        RecordCategory::query()->create([
            'name' => 'Транспорт',
            'type' => 'outcoming'
        ]);
        RecordCategory::query()->create([
            'name' => 'Мобильная связь',
            'type' => 'outcoming'
        ]);
        RecordCategory::query()->create([
            'name' => 'Интернет',
            'type' => 'outcoming'
        ]);
        RecordCategory::query()->create([
            'name' => 'Развлечения',
            'type' => 'outcoming'
        ]);
    }
}
