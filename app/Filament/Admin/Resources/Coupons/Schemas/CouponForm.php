<?php

namespace App\Filament\Admin\Resources\Coupons\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CouponForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('discount_type')
                    ->required(),
                TextInput::make('discount_value')
                    ->required()
                    ->numeric(),
                TextInput::make('max_discount')
                    ->numeric(),
                Select::make('course_id')
                    ->relationship('course', 'title'),
                Select::make('category_id')
                    ->relationship('category', 'name'),
                TextInput::make('usage_limit')
                    ->numeric(),
                TextInput::make('usage_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('per_user_limit')
                    ->required()
                    ->numeric()
                    ->default(1),
                DateTimePicker::make('valid_from')
                    ->required(),
                DateTimePicker::make('valid_until'),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
