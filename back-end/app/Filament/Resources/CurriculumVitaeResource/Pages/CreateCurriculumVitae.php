<?php

namespace App\Filament\Resources\CurriculumVitaeResource\Pages;

use App\Filament\Resources\CurriculumVitaeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCurriculumVitae extends CreateRecord
{
    protected static string $resource = CurriculumVitaeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
