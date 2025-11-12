<?php

namespace App\Filament\Exports\Tiers;

use App\Models\Tiers\Tiers;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class TiersExporter extends Exporter
{
    protected static ?string $model = Tiers::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('name'),
            ExportColumn::make('nature'),
            ExportColumn::make('type'),
            ExportColumn::make('code_tiers'),
            ExportColumn::make('siren'),
            ExportColumn::make('tva'),
            ExportColumn::make('num_tva'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your tiers export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
