<?php

namespace App\Filament\Resources\DatasetResource\Pages;

use App\Filament\Resources\DatasetResource;
use Filament\Actions;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewDataset extends ViewRecord
{
    protected static string $resource = DatasetResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Dataset Information')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('description'),
                        TextEntry::make('skills')
                            ->label('Skills')
                            ->getStateUsing(function ($record): string {
                                // Get primary skill + additional skills
                                $allSkills = $record->skills()->pluck('name')->unique()->toArray();
                                return implode(', ', $allSkills);
                            }),
                        TextEntry::make('industry.name')
                            ->label('Industry'),
                        TextEntry::make('year.year')
                            ->label('Year'),
                        TextEntry::make('user.name')
                            ->label('Submitted By'),
                        TextEntry::make('author'),
                        TextEntry::make('source'),
                        TextEntry::make('size')
                            ->formatStateUsing(fn ($record) => $record->formatSize()),
                    ]),
                Section::make('Approval Information')
                    ->schema([
                        IconEntry::make('is_approved')
                            ->boolean()
                            ->label('Approval Status'),
                        TextEntry::make('approved_at')
                            ->dateTime()
                            ->label('Approved At'),
                        TextEntry::make('approver.name')
                            ->label('Approved By'),
                    ]),
            ]);
    }

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
