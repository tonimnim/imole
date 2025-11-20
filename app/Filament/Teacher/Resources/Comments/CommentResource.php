<?php

namespace App\Filament\Teacher\Resources\Comments;

use App\Filament\Teacher\Resources\Comments\Pages\ListComments;
use App\Filament\Teacher\Resources\Comments\Schemas\CommentForm;
use App\Filament\Teacher\Resources\Comments\Tables\CommentsTable;
use App\Models\Comment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?int $navigationSort = 23;

    protected static ?string $navigationLabel = 'Q&A';

    protected static ?string $modelLabel = 'Question';

    protected static ?string $pluralModelLabel = 'Q&A';

    public static function form(Schema $schema): Schema
    {
        return CommentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CommentsTable::configure($table);
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Communication';
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
            'index' => ListComments::route('/'),
        ];
    }
}
