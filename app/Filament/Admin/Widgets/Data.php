<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Data as DataModel;
use Filament\Widgets\ChartWidget;

class Data extends ChartWidget
{
    protected static ?string $heading = 'Данные';

    protected function getData(): array
    {

        $dataCounts = DataModel::selectRaw('YEAR(created_at) as year, COUNT(*) as count')
            ->groupBy('year')
            ->orderBy('year')
            ->pluck('count', 'year')
            ->toArray();

        $labels = array_keys($dataCounts);
        $data = array_values($dataCounts);

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Количество',
                    'data' => $data,
                    'backgroundColor' => '#4CAF50',
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
