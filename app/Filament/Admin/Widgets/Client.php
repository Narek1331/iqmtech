<?php

namespace App\Filament\Admin\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;

class Client extends ChartWidget
{
    protected static ?string $heading = 'График пользователей';

    protected function getData(): array
    {

        $userCounts = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Admin')
            ->orWhere('name', 'Super Admin');

        })
        ->selectRaw('YEAR(created_at) as year, COUNT(*) as count')
        ->groupBy('year')
        ->orderBy('year')
        ->pluck('count', 'year')
        ->toArray();

        $labels = array_keys($userCounts);
        $data = array_values($userCounts);

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Количество пользователей',
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
