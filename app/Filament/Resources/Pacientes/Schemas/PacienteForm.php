<?php

namespace App\Filament\Resources\Pacientes\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PacienteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información Personal')
                    ->columns(2)
                    ->schema([
                        TextInput::make('nombre')->required(),
                        TextInput::make('apellido')->required(),
                        DatePicker::make('fecha_nacimiento')->required(),
                        TextInput::make('DUI')->label('DUI')->required(),
                        Select::make('genero')
                            ->options([
                                'Masculino' => 'Masculino',
                                'Femenino' => 'Femenino',
                                'Otro' => 'Otro',
                            ])->required(),
                    ]),

                Section::make('Expediente Clínico')
                    ->relationship('expediente')
                    ->columns(2)
                    ->disabled(fn() => auth()->user()->hasRole('asistente'))
                    ->schema([
                        Select::make('tipo_sangre')
                            ->label('Tipo de Sangre')
                            ->options([
                                'A+' => 'A+',
                                'A-' => 'A-',
                                'B+' => 'B+',
                                'B-' => 'B-',
                                'AB+' => 'AB+',
                                'AB-' => 'AB-',
                                'O+' => 'O+',
                                'O-' => 'O-',
                            ]),
                        Textarea::make('alergias')->rows(2),
                        Textarea::make('condiciones')->rows(2),
                        Textarea::make('medicaciones')->rows(2),
                        Textarea::make('notas')->rows(3)->columnSpanFull(),
                    ]),
            ]);
    }
}
