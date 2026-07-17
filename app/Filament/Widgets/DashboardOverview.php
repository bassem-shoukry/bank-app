<?php

namespace App\Filament\Widgets;

use App\Models\CaseType;
use App\Models\Dataset;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('القضايا', Dataset::query()->count())
                ->icon('heroicon-o-circle-stack'),
            Stat::make('Users', User::query()->count())
                ->icon('heroicon-o-users'),
            Stat::make('أنواع القضايا', CaseType::query()->count())
                ->icon('heroicon-o-tag'),
        ];
    }
}
