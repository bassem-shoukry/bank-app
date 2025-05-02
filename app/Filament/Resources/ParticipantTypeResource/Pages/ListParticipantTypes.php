<?php

namespace App\Filament\Resources\ParticipantTypeResource\Pages;

use App\Filament\Resources\ParticipantTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParticipantTypes extends ListRecords
{
    protected static string $resource = ParticipantTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
