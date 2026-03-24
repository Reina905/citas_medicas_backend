<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del Usuario')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required(),
                        TextInput::make('email')
                            ->label('Correo Electrónico')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true),
                        Select::make('rol')
                            ->options([
                                'admin' => 'Administrador',
                                'doctor' => 'Médico',
                                'asistente' => 'Asistente',
                            ])
                            ->required(),
                        TextInput::make('password')
                            ->label('Contraseña')
                            ->password()
                            ->dehydrateStateUsing(fn($state) => bcrypt($state))
                            ->required(fn(string $context) => $context === 'create')
                            ->dehydrated(fn($state) => filled($state)),
                    ]),
            ]);
    }
}
