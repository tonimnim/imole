<?php

namespace App\Filament\Admin\Resources\Payments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('course_id')
                    ->relationship('course', 'title')
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('currency')
                    ->required()
                    ->default('NGN'),
                TextInput::make('payment_method')
                    ->required()
                    ->default('card'),
                TextInput::make('paystack_reference')
                    ->required(),
                TextInput::make('paystack_access_code'),
                TextInput::make('paystack_authorization_code'),
                TextInput::make('transaction_id'),
                TextInput::make('reference_code')
                    ->required(),
                TextInput::make('gateway_response'),
                TextInput::make('channel'),
                TextInput::make('ip_address'),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                DateTimePicker::make('paid_at'),
                TextInput::make('customer_email')
                    ->email()
                    ->required(),
                TextInput::make('customer_code'),
                TextInput::make('metadata'),
            ]);
    }
}
