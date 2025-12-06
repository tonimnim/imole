<?php

namespace App\Filament\Teacher\Resources\Reviews;

use App\Filament\Teacher\Resources\Reviews\Pages\CreateReview;
use App\Filament\Teacher\Resources\Reviews\Pages\EditReview;
use App\Filament\Teacher\Resources\Reviews\Pages\ListReviews;
use App\Filament\Teacher\Resources\Reviews\Schemas\ReviewForm;
use App\Filament\Teacher\Resources\Reviews\Tables\ReviewsTable;
use App\Models\Review;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?int $navigationSort = 22;

    public static function form(Schema $schema): Schema
    {
        return ReviewForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReviewsTable::configure($table);
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Performance';
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
            'index' => ListReviews::route('/'),
            'create' => CreateReview::route('/create'),
            'edit' => EditReview::route('/{record}/edit'),
        ];
    }
}
