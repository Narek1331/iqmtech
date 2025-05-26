<?php

namespace App\Filament\Resources\AnalyticsResource\Pages;

use App\Filament\Resources\AnalyticsResource;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use App\Models\{
    Data,
    Status
};
use Illuminate\Support\Facades\DB;
class Channel extends Page
{
    protected static string $resource = AnalyticsResource::class;

    protected static string $view = 'filament.resources.analytics.pages.channel';

    public function getTitle(): string
    {
        return 'Общая ЭФФЕКТИВНОСТЬ каналов с разбивкой по результатам';
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id'),
        ];
    }

    public function getStatuses()
    {
        return Status::get();
    }

    public function getDatas()
    {
        $recordId = request()->record;

         $datas = DB::table('data')
        ->selectRaw("
            page as page,
            COUNT(*) as total_count,
            SUM(CASE WHEN status_id = 1 THEN 1 ELSE 0 END) as status_1_count,
            SUM(CASE WHEN status_id = 2 THEN 1 ELSE 0 END) as status_2_count,
            SUM(CASE WHEN status_id = 3 THEN 1 ELSE 0 END) as status_3_count,
            SUM(CASE WHEN status_id = 4 THEN 1 ELSE 0 END) as status_4_count,
            SUM(CASE WHEN status_id = 5 THEN 1 ELSE 0 END) as status_5_count,
            SUM(CASE WHEN status_id = 6 THEN 1 ELSE 0 END) as status_6_count,
            SUM(CASE WHEN status_id = 7 THEN 1 ELSE 0 END) as status_7_count,
            SUM(CASE WHEN status_id = 8 THEN 1 ELSE 0 END) as status_8_count,
            SUM(CASE WHEN status_id = 9 THEN 1 ELSE 0 END) as status_9_count
        ")
        ->where('project_id', $recordId)
        ->whereYear('created_at', now()->year)
        ->groupBy('page')
        ->get();

        return $datas;
    }
}
