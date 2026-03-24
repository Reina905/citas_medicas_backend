<?php

namespace App\Filament\Resources\Horarios\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HorarioInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detalle del Horario')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Médico'),
                        TextEntry::make('dia')
                            ->label('Día'),
                        TextEntry::make('hora_inicio')
                            ->label('Hora Inicio')
                            ->time('H:i'),
                        TextEntry::make('hora_fin')
                            ->label('Hora Fin')
                            ->time('H:i'),
                    ]),
            ]);
    }
}
