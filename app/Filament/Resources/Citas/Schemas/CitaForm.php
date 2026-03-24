<?php

namespace App\Filament\Resources\Citas\Schemas;

use App\Models\Paciente;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CitaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información de la Cita')
                    ->columns(2)
                    ->schema([
                        Select::make('paciente_id')
                            ->label('Paciente')
                            ->options(
                                Paciente::all()->mapWithKeys(
                                    fn($p) => [$p->paciente_id => $p->nombre . ' ' . $p->apellido]
                                )
                            )
                            ->searchable()
                            ->required(),

                        Select::make('user_id')
                            ->label('Médico')
                            ->options(
                                User::where('rol', 'doctor')->pluck('name', 'id')
                            )
                            ->searchable()
                            ->required(),

                        DatePicker::make('dia')
                            ->label('Día')
                            ->minDate(now()->startOfDay())
                            ->format('Y-m-d')
                            ->required(),

                        TimePicker::make('hora_inicio')
                            ->label('Hora Inicio')
                            ->required(),

                        TimePicker::make('hora_fin')
                            ->label('Hora Fin')
                            ->required(),
                    ]),
            ]);
    }
}