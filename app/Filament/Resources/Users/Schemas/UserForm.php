<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Full Name')
                    ->placeholder('Enter user\'s full name')
                    ->helperText('The user\'s full name'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->placeholder('Enter user\'s email address')
                    ->helperText('Must be a valid email address'),
                TextInput::make('password')
                    ->password()
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->maxLength(255)
                    ->minLength(8)
                    ->placeholder('Enter password')
                    ->helperText('Password must be at least 8 characters long')
                    ->visible(fn(string $operation): bool => $operation === 'create'),
                TextInput::make('new_password')
                    ->password()
                    ->label('New Password')
                    ->maxLength(255)
                    ->minLength(8)
                    ->placeholder('Enter new password')
                    ->helperText('Leave blank to keep current password. Must be at least 8 characters long')
                    ->visible(fn(string $operation): bool => $operation === 'edit'),
            ]);
    }
}
