<?php

namespace App\Filament\Teacher\Resources\Certificates;

use App\Filament\Teacher\Resources\Certificates\Pages\CreateCertificate;
use App\Filament\Teacher\Resources\Certificates\Pages\EditCertificate;
use App\Filament\Teacher\Resources\Certificates\Pages\ListCertificates;
use App\Filament\Teacher\Resources\Certificates\Schemas\CertificateForm;
use App\Filament\Teacher\Resources\Certificates\Tables\CertificatesTable;
use App\Models\Certificate;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class CertificateResource extends Resource
{
    protected static ?string $model = Certificate::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 12;

    protected static ?string $recordTitleAttribute = 'title';

    protected static \UnitEnum|string|null $navigationGroup = 'Rewards';

    public static function form(Schema $schema): Schema
    {
        return CertificateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CertificatesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCertificates::route('/'),
            'create' => CreateCertificate::route('/create'),
            'edit' => EditCertificate::route('/{record}/edit'),
        ];
    }
}
