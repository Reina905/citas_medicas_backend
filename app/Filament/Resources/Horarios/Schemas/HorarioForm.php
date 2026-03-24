<?php

namespace App\Filament\Resources\Horarios\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HorarioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Horario del Doctor')
                    ->columns(2)
                    ->schema([
                        Select::make('user_id')
                            ->label('Médico')
                            ->options(
                                User::where('rol', 'doctor')->pluck('name', 'id')
                            )
                            ->searchable()
                            ->required(),

                        Select::make('dia')
                            ->label('Día')
                            ->options([
                                'Lunes' => 'Lunes',
                                'Martes' => 'Martes',
                                'Miercoles' => 'Miércoles',
                                'Jueves' => 'Jueves',
                                'Viernes' => 'Viernes',
                                'Sabado' => 'Sábado',
                                'Domingo' => 'Domingo',
                            ])
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
