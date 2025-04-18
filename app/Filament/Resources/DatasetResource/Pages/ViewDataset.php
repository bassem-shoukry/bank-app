<?php

namespace App\Filament\Resources\DatasetResource\Pages;

use App\Filament\Resources\DatasetResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDataset extends ViewRecord
{
    protected static string $resource = DatasetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('approve')
                ->label('Approve Dataset')
                ->icon('heroicon-o-check')
                ->color('success')
                ->visible(fn () => !(bool)$this->record->is_approved)
                ->action(function () {
                    $this->record->update([
                        'is_approved' => true,
                        'approved_at' => now(),
                        'approved_by' => auth()->id(),
                    ]);

//                    $this->notify('success', 'Dataset approved successfully.');

                    $this->redirect(DatasetResource::getUrl('index'));
                }),
            Actions\Action::make('reject')
                ->label('Reject Approval')
                ->icon('heroicon-o-x-mark')
                ->color('danger')
                ->visible(fn () => (bool)$this->record->is_approved)
                ->action(function () {
                    $this->record->update([
                        'is_approved' => false,
                        'approved_at' => null,
                        'approved_by' => null,
                    ]);

//                    $this->notify('success', 'Dataset approval was rejected.');

                    $this->redirect(DatasetResource::getUrl('index'));
                }),
            Actions\EditAction::make(),
        ];
    }
}
