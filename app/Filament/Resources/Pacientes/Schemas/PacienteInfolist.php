<?php

namespace App\Filament\Resources\Pacientes\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PacienteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información Personal')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('nombre'),
                        TextEntry::make('apellido'),
                        TextEntry::make('DUI')->label('DUI'),
                        TextEntry::make('fecha_nacimiento')
                            ->date('d/m/Y'),
                        TextEntry::make('genero'),
                    ]),

                Section::make('🩺 Expediente Clínico')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('expediente.tipo_sangre')
                            ->label('Tipo de Sangre')
                            ->badge()
                            ->color('danger'),
                        TextEntry::make('expediente.alergias')
                            ->label('Alergias'),
                        TextEntry::make('expediente.condiciones')
                            ->label('Condiciones'),
                        TextEntry::make('expediente.medicaciones')
                            ->label('Medicaciones'),
                        TextEntry::make('expediente.notas')
                            ->label('Notas')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
