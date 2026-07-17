<?php

namespace App\Filament\Resources\DatasetResource\Pages;

use App\Filament\Resources\DatasetResource;
use Filament\Actions;
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
                Section::make('بيانات القضية')
                    ->schema([
                        TextEntry::make('name')
                            ->label('الاسم'),
                        TextEntry::make('national_id')
                            ->label('الرقم القومي'),
                        TextEntry::make('address')
                            ->label('العنوان'),
                        TextEntry::make('case_number')
                            ->label('رقم القضيه'),
                        TextEntry::make('caseType.name')
                            ->label('نوع القضيه'),
                        TextEntry::make('verdict')
                            ->label('الحكم'),
                        TextEntry::make('payment_status')
                            ->label('السداد')
                            ->badge(),
                        TextEntry::make('user.name')
                            ->label('مُدخِل البيانات'),
                        TextEntry::make('created_at')
                            ->label('تاريخ الإضافة')
                            ->dateTime(),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
