<?php

namespace App\Filament\Widgets;

use App\Models\Dataset;
use App\Models\Industry;
use App\Models\ParticipantType;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Datasets', Dataset::query()->count())
                ->icon('heroicon-o-circle-stack'),
            Stat::make('Users', User::query()->count())
                ->icon('heroicon-o-users'),
            Stat::make('Industries', Industry::query()->count())
                ->icon('heroicon-o-building-office'),
            Stat::make('Participant Types', ParticipantType::query()->count())
                ->icon('heroicon-o-user-group'),
        ];
    }
}
