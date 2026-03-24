<?php

namespace App\Filament\Resources\Pacientes\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PacienteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required(),
                TextInput::make('apellido')
                    ->required(),
                DatePicker::make('fecha_nacimiento')
                    ->required(),
                TextInput::make('DUI')
                    ->required(),
                TextInput::make('genero')
                    ->required(),
            ]);
    }
}
