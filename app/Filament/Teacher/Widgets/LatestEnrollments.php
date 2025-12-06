<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\Enrollment;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestEnrollments extends BaseWidget
{
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Enrollment::query()
                    ->whereIn('course_id', auth()->user()->courses()->pluck('id'))
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student'),
                Tables\Columns\TextColumn::make('course.title'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Enrolled On')
                    ->date(),
            ]);
    }
}
