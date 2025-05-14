<?php

namespace App\Filament\Resources\DatasetResource\Pages;

use App\Filament\Resources\DatasetResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDataset extends CreateRecord
{
    protected static string $resource = DatasetResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set the user_id to the currently authenticated user
        $data['user_id'] = auth()->id();

        // Set the author to the name of the currently authenticated user
        $data['author'] = auth()->user()->name;

        // Set a default value for size if not provided
        if (!isset($data['size'])) {
            $data['size'] = 0; // Default size value
        }

        return $data;
    }
}
