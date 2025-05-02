<?php

namespace App\Filament\Resources\ParticipantTypeResource\Pages;

use App\Filament\Resources\ParticipantTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditParticipantType extends EditRecord
{
    protected static string $resource = ParticipantTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
