<?php

namespace App\Filament\Teacher\Resources\Modules;

use App\Filament\Teacher\Resources\Modules\Pages\CreateModule;
use App\Filament\Teacher\Resources\Modules\Pages\EditModule;
use App\Filament\Teacher\Resources\Modules\Pages\ListModules;
use App\Filament\Teacher\Resources\Modules\Pages\ViewModule;
use App\Filament\Teacher\Resources\Modules\Schemas\ModuleForm;
use App\Filament\Teacher\Resources\Modules\Tables\ModulesTable;
use App\Models\Module;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ModuleResource extends Resource
{
    protected static ?string $model = Module::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return ModuleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ModulesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\LessonsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListModules::route('/'),
            'create' => CreateModule::route('/create'),
            'view' => ViewModule::route('/{record}'),
            'edit' => EditModule::route('/{record}/edit'),
        ];
    }
}
