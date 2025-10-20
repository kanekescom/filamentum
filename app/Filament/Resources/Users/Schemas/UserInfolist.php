<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('email_verified_at')
                    ->label('Email Verified')
                    ->since()
                    ->tooltip(fn ($record) => $record->email_verified_at?->format('Y-m-d H:i:s'))
                    ->placeholder('-'),
                TextEntry::make('roles.name')
                    ->label('Roles')
                    ->badge()
                    ->listWithLineBreaks()
                    ->limitList(1)
                    ->expandableLimitedList(),
                TextEntry::make('created_at')
                    ->label('Created')
                    ->since()
                    ->dateTimeTooltip()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('Updated')
                    ->since()
                    ->dateTimeTooltip()
                    ->placeholder('-'),
            ]);
    }
}
