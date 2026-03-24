<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del Usuario')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nombre'),
                        TextEntry::make('email')
                            ->label('Correo Electrónico'),
                        TextEntry::make('rol')
                            ->label('Rol')
                            ->badge()
                            ->color(fn(string $state) => match ($state) {
                                'admin' => 'danger',
                                'doctor' => 'success',
                                'asistente' => 'warning',
                            }),
                        TextEntry::make('created_at')
                            ->label('Creado')
                            ->dateTime('d/m/Y H:i'),
                    ]),
            ]);
    }
}
