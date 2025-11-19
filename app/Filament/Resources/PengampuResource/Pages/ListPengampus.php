<?php

namespace App\Filament\Resources\PengampuResource\Pages;

use App\Filament\Resources\PengampuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPengampus extends ListRecords
{
    protected static string $resource = PengampuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
